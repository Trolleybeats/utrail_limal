<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MembreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/membre/Index', [
            'membres' => Membre::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/membre/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'date_naissance' => 'required|date',
            'participation_un' => 'required|boolean',
            'distance_un' => 'required|string|max:255',
            'logement_un' => 'required|string|max:255',
            'participation_deux' => 'required|boolean',
            'distance_deux' => 'required|string|max:255',
            'logement_deux' => 'required|string|max:255',
            'tshirt_taille' => 'required|string|max:255',
        ]);

        Membre::create($validated);

        return redirect()->route('membre.index')->with('success', 'Membre created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/membre/Show', [
            'membre' => Membre::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/membre/Edit', [
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
            'logement_un' => 'required|string|max:255',
            'participation_deux' => 'required|boolean',
            'distance_deux' => 'required|string|max:255',
            'logement_deux' => 'required|string|max:255',
            'tshirt_taille' => 'required|string|max:255',
        ]);

        $membre->update($validated);

        return redirect()->route('membre.index')->with('success', 'Membre updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $membre = Membre::findOrFail($id);
        $membre->delete();

        return redirect()->route('membre.index')->with('success', 'Membre deleted successfully.');
    }
}
