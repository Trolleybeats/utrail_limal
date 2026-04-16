<?php

namespace App\Http\Controllers;

use App\Mail\LienPaiement;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/participants/Index', [
            'participants' => Participant::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Inscription');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'telephone' => 'nullable|string|max:20',
            'rgpd' => 'accepted',
            'pre_inscription' => 'accepted',
        ]);

        $validated['token'] = Str::uuid()->toString();

        $participant = Participant::create($validated);

        Mail::to($participant->email)->send(new LienPaiement($participant));

        return redirect()->route('inscription')->with('success', 'Votre inscription a été envoyée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/participants/Show', [
            'participant' => Participant::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/participants/Edit', [
            'participant' => Participant::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $participant = Participant::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email,' . $participant->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        $participant->update($validated);

        return redirect()->route('participants.index')->with('success', 'Participant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();

        return redirect()->route('participants.index')->with('success', 'Participant deleted successfully.');
    }
}
