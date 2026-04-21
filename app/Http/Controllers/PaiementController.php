<?php

namespace App\Http\Controllers;

use App\Models\Membre;
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

        return Inertia::render('Checkout', [
            'membre' => $membre->load('participant')->only('id', 'montant_total', 'participant', 'participation_un', 'distance_un', 'logement_un', 'participation_deux', 'distance_deux', 'logement_deux', 'tshirt_taille'),
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey' => config('services.stripe.key'),
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
