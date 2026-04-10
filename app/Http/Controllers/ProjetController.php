<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/projet/Index', [
            'projets' => Projet::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/projet/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required|string|max:255',
            'date' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Handle file upload if photo is provided
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('projets', 'public');
        }

        // Create the project
        Projet::create($validated);

        return redirect()->route('projet.index')->with('success', 'Project created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/projet/Show', [
            'projet' => Projet::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/projet/Edit', [
            'projet' => Projet::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'niveau' => 'required|string|max:255',
            'date' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ]);

        $projet = Projet::findOrFail($id);

        // Handle file upload if photo is provided
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('projets', 'public');
        }

        // Update the project
        $projet->update($validated);

        return redirect()->route('projet.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projet = Projet::findOrFail($id);
        $projet->delete();

        return redirect()->route('projet.index')->with('success', 'Project deleted successfully.');
    }
}
