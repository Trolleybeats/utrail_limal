<?php

namespace App\Http\Controllers;

use App\Exports\MembresExport;
use App\Models\Membre;
use App\Models\Participant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

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

        return Inertia::render('Paiement', [
            'participant' => array_merge(
                $participant->only('id', 'nom', 'prenom', 'email'),
                ['token' => $token]
            ),
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

        Membre::create($validated);

        return redirect()->route('projet')->with('success', 'Votre inscription est confirmée !');
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
