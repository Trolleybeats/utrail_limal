<?php

namespace App\Http\Controllers;

use App\Exports\MembresExport;
use App\Models\Membre;
use App\Models\Participant;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class MembreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/membres/Index', [
            'membres' => Membre::with('participant')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $token)
    {
        $participant = Participant::where('token', $token)->firstOrFail();

        $courseUn = Tarif::where('categorie', 'Course')
            ->where('course_numero', 1)
            ->where('est_actif', true)
            ->pluck('prix', 'label');

        $courseDeux = Tarif::where('categorie', 'Course')
            ->where('course_numero', 2)
            ->where('est_actif', true)
            ->pluck('prix', 'label');

        $logementUn = Tarif::where('categorie', 'Logement')
            ->where('course_numero', 1)
            ->where('est_actif', true)
            ->first(['label', 'prix']);

        $logementDeux = Tarif::where('categorie', 'Logement')
            ->where('course_numero', 2)
            ->where('est_actif', true)
            ->first(['label', 'prix']);

        $tshirtPrix = Tarif::where('categorie', 'T-shirt')
            ->where('est_actif', true)
            ->value('prix') ?? 0;

        return Inertia::render('Paiement', [
            'participant' => array_merge(
                $participant->only('id', 'nom', 'prenom', 'email'),
                ['token' => $token]
            ),
            'tarifs' => [
                'course_un' => $courseUn,
                'course_deux' => $courseDeux,
                'logement_un' => $logementUn,
                'logement_deux' => $logementDeux,
                'tshirt' => $tshirtPrix,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $token)
    {
        $participant = Participant::where('token', $token)->firstOrFail();

        $validated = $request->validate([
            'date_naissance' => 'required|date',
            'participation_un' => 'required|boolean',
            'distance_un' => 'required|string|max:255',
            'logement_un' => 'required|boolean',
            'participation_deux' => 'required|boolean',
            'distance_deux' => 'required|string|max:255',
            'logement_deux' => 'required|boolean',
            'tshirt_taille' => 'required|string|max:255',
            'rgpd' => 'accepted',
            'inscription' => 'accepted',
        ]);

        $validated['participant_id'] = $participant->id;
        $validated['payment_status'] = 'pending';

        // Calculate total from active Tarifs
        $montant = 0.0;

        if ($validated['participation_un'] && $validated['distance_un'] !== 'non') {
            $tarif = Tarif::where('categorie', 'Course')
                ->where('course_numero', 1)
                ->where('label', $validated['distance_un'])
                ->where('est_actif', true)
                ->first();
            if ($tarif) {
                $montant += $tarif->prix;
            }
        }

        if ($validated['logement_un']) {
            $tarif = Tarif::where('categorie', 'Logement')
                ->where('course_numero', 1)
                ->where('est_actif', true)
                ->first();
            if ($tarif) {
                $montant += $tarif->prix;
            }
        }

        if ($validated['participation_deux'] && $validated['distance_deux'] !== 'non') {
            $tarif = Tarif::where('categorie', 'Course')
                ->where('label', $validated['distance_deux'])
                ->where('est_actif', true)
                ->first();
            if ($tarif) {
                $montant += $tarif->prix;
            }
        }

        if ($validated['logement_deux']) {
            $tarif = Tarif::where('categorie', 'Logement')
                ->where('course_numero', 2)
                ->where('est_actif', true)
                ->first();
            if ($tarif) {
                $montant += $tarif->prix;
            }
        }

        $tarifTshirt = Tarif::where('categorie', 'T-shirt')
            ->where('est_actif', true)
            ->first();
        if ($tarifTshirt) {
            $montant += $tarifTshirt->prix;
        }

        $validated['montant_total'] = $montant;

        // Create Stripe PaymentIntent
        Stripe::setApiKey(config('services.stripe.secret'));
        $paymentIntent = PaymentIntent::create([
            'amount' => (int) round($montant * 100),
            'currency' => 'eur',
            'metadata' => [
                'participant_id' => $participant->id,
                'participant_email' => $participant->email,
            ],
        ]);

        $validated['stripe_payment_intent_id'] = $paymentIntent->id;

        $membre = Membre::create($validated);

        return redirect()->route('checkout', ['membre' => $membre->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/membres/Show', [
            'membre' => Membre::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/membres/Edit', [
            'membre' => Membre::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $membre = Membre::findOrFail($id);

        $validated = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'date_naissance' => 'required|date',
            'participation_un' => 'required|boolean',
            'distance_un' => 'required|string|max:255',
            'logement_un' => 'required|boolean',
            'participation_deux' => 'required|boolean',
            'distance_deux' => 'required|string|max:255',
            'logement_deux' => 'required|boolean',
            'tshirt_taille' => 'required|string|max:255',
        ]);

        $membre->update($validated);

        return redirect()->route('membres.index')->with('success', 'Membre updated successfully.');
    }

    public function export()
    {
        return Excel::download(new MembresExport(), 'membres.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $membre = Membre::findOrFail($id);
        $membre->delete();

        return redirect()->route('membres.index')->with('success', 'Membre deleted successfully.');
    }
}
