<?php

namespace App\Http\Controllers;

use App\Models\PhotoProjet;
use App\Models\Projet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjetController extends Controller
{
    public function presentation()
    {
        return Inertia::render('Presentation', [
            'projets' => Projet::with(['photoPrincipale', 'photos'])->orderBy('ordre')->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/projets/Index', [
            'projets' => Projet::orderBy('ordre')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/projets/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:5120',
            'photo_principale_index' => 'nullable|integer|min:0',
        ]);

        $projet = Projet::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'ordre' => (Projet::max('ordre') ?? 0) + 1,
        ]);

        if ($request->hasFile('photos')) {
            $principaleIndex = (int) ($request->input('photo_principale_index', 0));
            $firstPhoto = null;

            foreach ($request->file('photos') as $index => $file) {
                $chemin = $file->store('projets', 'public');
                $photo = $projet->photos()->create(['chemin' => $chemin]);

                if ($index === $principaleIndex) {
                    $firstPhoto = $photo;
                }
            }

            if ($firstPhoto) {
                $projet->update(['photo_id' => $firstPhoto->id]);
            }
        }

        return redirect()->route('projets.index')->with('success', 'Projet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/projets/Show', [
            'projet' => Projet::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/projets/Edit', [
            'projet' => Projet::with(['photos', 'photoPrincipale'])->findOrFail($id),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        $projet = Projet::findOrFail($id);
        $projet->update([
            'titre' => $request->titre,
            'description' => $request->description,
        ]);

        if ($request->hasFile('photo')) {
            $chemin = $request->file('photo')->store('projets', 'public');
            $photo = $projet->photos()->create(['chemin' => $chemin]);
            $projet->update(['photo_id' => $photo->id]);
        }

        return redirect()->route('projets.index')->with('success', 'Projet mis à jour avec succès.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ordre' => 'required|array',
            'ordre.*' => 'integer|exists:projets,id',
        ]);

        foreach ($request->ordre as $position => $id) {
            Projet::where('id', $id)->update(['ordre' => $position + 1]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projet = Projet::findOrFail($id);
        $projet->delete();

        return redirect()->route('projets.index')->with('success', 'Project deleted successfully.');
    }
}
