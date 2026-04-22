<?php

namespace App\Http\Controllers;

use App\Models\Echeancier;
use App\Models\Membre;
use App\Models\Versement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaiementReussi;
use Inertia\Inertia;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaiementController extends Controller
{
    public function show(Membre $membre)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::retrieve($membre->stripe_payment_intent_id);

        $echeanciers = Echeancier::where('est_actif', true)
            ->get(['id', 'label', 'nombre_versements', 'dates']);

        $versements = $membre->mode_paiement === 'echelonne'
            ? $membre->versements()->orderBy('numero_versement')->get(['id', 'numero_versement', 'montant', 'date_echeance', 'statut'])->toArray()
            : [];

        return Inertia::render('Checkout', [
            'membre' => $membre->load('participant')->only('id', 'montant_total', 'participant', 'participation_un', 'distance_un', 'logement_un', 'participation_deux', 'distance_deux', 'logement_deux', 'tshirt_taille', 'mode_paiement', 'echeancier_id'),
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey' => config('services.stripe.key'),
            'echeancier' => $membre->echeancier ? [
                'id' => $membre->echeancier->id,
                'label' => $membre->echeancier->label,
                'nombre_versements' => $membre->echeancier->nombre_versements,
                'dates' => $membre->echeancier->dates,
            ] : null,
            'echeanciers' => $echeanciers,
            'versements' => $versements,
        ]);
    }

    public function switchToInstallments(Request $request, Membre $membre)
    {
        $validated = $request->validate([
            'echeancier_id' => ['required', 'integer', 'exists:echeanciers,id'],
        ]);

        $echeancier = Echeancier::where('id', $validated['echeancier_id'])
            ->where('est_actif', true)
            ->firstOrFail();

        $n = $echeancier->nombre_versements;
        $dates = $echeancier->dates; // already cast as array
        $base = intdiv($membre->montant_total, $n);
        $remainder = $membre->montant_total % $n;
        $firstAmount = $base + $remainder;

        Stripe::setApiKey(config('services.stripe.secret'));
        PaymentIntent::update($membre->stripe_payment_intent_id, [
            'amount' => $firstAmount * 100,
        ]);

        // Idempotency: remove any previous versements before recreating
        $membre->versements()->delete();

        $now = now();
        $versementsData = [];
        for ($i = 0; $i < $n; $i++) {
            $versementsData[] = [
                'membre_id'              => $membre->id,
                'numero_versement'       => $i + 1,
                'montant'                => $i === 0 ? $firstAmount : $base,
                'date_echeance'          => $dates[$i],
                'stripe_payment_intent_id' => $i === 0 ? $membre->stripe_payment_intent_id : null,
                'statut'                 => 'pending',
                'created_at'             => $now,
                'updated_at'             => $now,
            ];
        }
        Versement::insert($versementsData);

        $membre->update([
            'mode_paiement' => 'echelonne',
            'echeancier_id' => $echeancier->id,
        ]);

        $versements = $membre->versements()
            ->orderBy('numero_versement')
            ->get(['id', 'numero_versement', 'montant', 'date_echeance', 'statut'])
            ->toArray();

        return response()->json([
            'versements' => $versements,
            'echeancier' => [
                'id'                => $echeancier->id,
                'label'             => $echeancier->label,
                'nombre_versements' => $echeancier->nombre_versements,
            ],
            'firstAmount' => $firstAmount,
        ]);
    }

    public function switchToFull(Membre $membre)
    {
        // Only allowed when in echelonne mode and first versement is still pending
        if ($membre->mode_paiement === 'echelonne') {
            $firstPaid = $membre->versements()
                ->where('numero_versement', 1)
                ->where('statut', 'succeeded')
                ->exists();

            if ($firstPaid) {
                return response()->json(['message' => 'Le premier versement a déjà été réglé.'], 422);
            }

            $membre->versements()->delete();
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        PaymentIntent::update($membre->stripe_payment_intent_id, [
            'amount' => $membre->montant_total * 100,
        ]);

        $membre->update([
            'mode_paiement' => 'immediat',
            'echeancier_id' => null,
        ]);

        return response()->json(['montant_total' => $membre->montant_total]);
    }

    public function showVersement(Versement $versement)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $membre = $versement->membre->load('participant');

        $paymentIntent = PaymentIntent::create([
            'amount'   => $versement->montant,
            'currency' => 'eur',
            'metadata' => [
                'membre_id'    => $membre->id,
                'versement_id' => $versement->id,
            ],
        ]);

        $versement->update(['stripe_payment_intent_id' => $paymentIntent->id]);

        return Inertia::render('Checkout', [
            'membre'      => $membre->only('id', 'montant_total', 'participant', 'participation_un', 'distance_un', 'logement_un', 'participation_deux', 'distance_deux', 'logement_deux', 'tshirt_taille'),
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey'   => config('services.stripe.key'),
            'versement'   => [
                'id'               => $versement->id,
                'numero_versement' => $versement->numero_versement,
                'montant'          => $versement->montant,
                'date_echeance'    => $versement->date_echeance,
            ],
            'echeanciers' => [],
        ]);
    }

    public function confirmation(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');

        if (!$paymentIntentId) {
            abort(400, 'Paramètre payment_intent manquant.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

        // Mode échelonné : le PI appartient à un versement
        $versement = Versement::where('stripe_payment_intent_id', $paymentIntentId)->first();

        if ($versement) {
            $membre = $versement->membre;

            if ($paymentIntent->status === 'succeeded' && $versement->statut !== 'succeeded') {
                $versement->update(['statut' => 'succeeded']);

                $allPaid = $membre->versements()->where('statut', '!=', 'succeeded')->doesntExist();
                if ($allPaid && $membre->payment_status !== 'succeeded') {
                    $membre->update(['payment_status' => 'succeeded']);
                    Mail::to($membre->participant->email)->send(new PaiementReussi($membre));
                }
            }

            if ($paymentIntent->status !== 'succeeded') {
                if ($versement->numero_versement === 1) {
                    return redirect()->route('checkout', $membre)
                        ->with('error', 'Le paiement a échoué ou a été annulé. Veuillez réessayer.');
                }
                return redirect()->route('versement.checkout', $versement)
                    ->with('error', 'Le paiement a échoué ou a été annulé. Veuillez réessayer.');
            }

            $totalVersements = $membre->versements()->count();

            return Inertia::render('PaiementConfirmation', [
                'status'    => $paymentIntent->status,
                'membre'    => $membre->load('participant')->only('id', 'montant_total', 'participant'),
                'versement' => [
                    'numero_versement'  => $versement->numero_versement,
                    'montant'           => $versement->montant,
                    'total_versements'  => $totalVersements,
                    'date_echeance'     => $versement->date_echeance,
                ],
            ]);
        }

        // Mode immédiat : le PI appartient directement au membre
        $membre = Membre::where('stripe_payment_intent_id', $paymentIntentId)->firstOrFail();

        if ($paymentIntent->status === 'succeeded' && $membre->payment_status !== 'succeeded') {
            $membre->update(['payment_status' => 'succeeded']);
            Mail::to($membre->participant->email)->send(new PaiementReussi($membre));
        }

        if ($paymentIntent->status !== 'succeeded') {
            return redirect()->route('checkout', $membre)
                ->with('error', 'Le paiement a échoué ou a été annulé. Veuillez réessayer.');
        }

        return Inertia::render('PaiementConfirmation', [
            'status' => $paymentIntent->status,
            'membre' => $membre->load('participant')->only('id', 'montant_total', 'participant'),
        ]);
    }
}
