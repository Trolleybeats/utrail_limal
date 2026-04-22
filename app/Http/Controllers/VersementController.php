<?php

namespace App\Http\Controllers;

use App\Mail\LienVersement;
use App\Models\Membre;
use App\Models\Versement;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class VersementController extends Controller
{
    /**
     * Display all members with their versements.
     */
    public function index()
    {
        $membres = Membre::with(['participant', 'versements' => function ($q) {
            $q->orderBy('numero_versement');
        }])
            ->whereHas('versements')
            ->get();

        return Inertia::render('admin/versements/Index', [
            'membres' => $membres,
        ]);
    }

    /**
     * Manually send a payment link for a given versement.
     */
    public function sendLienVersement(Versement $versement)
    {
        $versement->load('membre.participant');

        $email = $versement->membre->participant->email;

        Mail::to($email)->send(new LienVersement($versement));

        return back()->with('success', 'Lien de paiement envoyé à ' . $email . '.');
    }
}
