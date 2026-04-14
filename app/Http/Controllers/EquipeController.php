<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EquipeController extends Controller
{
    public function equipe()
    {
        return Inertia::render('Equipe', [
            'equipes' => Equipe::all(),
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/equipes/Index', [
            'equipes' => Equipe::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/equipes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public');
            $validated['photo'] = $photoPath;
        }

        Equipe::create($validated);

        return redirect()->route('equipes.index')->with('success', 'Equipe created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/equipes/Show', [
            'equipe' => Equipe::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/equipes/Edit', [
            'equipe' => Equipe::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $equipe = Equipe::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            if ($equipe->photo) {
                Storage::disk('public')->delete($equipe->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $equipe->update($validated);

        return redirect()->route('equipes.index')->with('success', 'Equipe updated successfully.');
    }

    public function deletePhoto(string $id)
    {
        $equipe = Equipe::findOrFail($id);

        if ($equipe->photo) {
            Storage::disk('public')->delete($equipe->photo);
            $equipe->update(['photo' => null]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipe = Equipe::findOrFail($id);
        $equipe->delete();

        return redirect()->route('equipes.index')->with('success', 'Equipe deleted successfully.');
    }
}
