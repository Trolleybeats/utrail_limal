<?php

namespace App\Http\Controllers;

use App\Models\Echeancier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EcheancierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/echeanciers/Index', [
            'echeanciers' => Echeancier::all()
        ]);
    }

    public function echeanciersActifs(Echeancier $echeancier)
    {
        $echeancier->update(['est_actif' => !$echeancier->est_actif]);

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/echeanciers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'nombre_versements' => 'required|integer|min:1',
            'dates' => 'required|array',
            'dates.*' => 'required|date',
            'est_actif' => 'boolean',
        ]);

        Echeancier::create([
            'label' => $request->label,
            'nombre_versements' => $request->nombre_versements,
            'dates' => $request->dates,
            'est_actif' => $request->est_actif,
        ]);

        return redirect()->route('echeanciers.index')->with('success', 'Echéancier créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/echeanciers/Edit', [
            'echeancier' => Echeancier::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'nombre_versements' => 'required|integer|min:1',
            'dates' => 'required|array',
            'dates.*' => 'required|date',
            'est_actif' => 'boolean',
        ]);

        $echeancier = Echeancier::findOrFail($id);
        $echeancier->update([
            'label' => $request->label,
            'nombre_versements' => $request->nombre_versements,
            'dates' => $request->dates,
            'est_actif' => $request->est_actif,
        ]);

        return redirect()->route('echeanciers.index')->with('success', 'Echéancier mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $echeancier = Echeancier::findOrFail($id);
        $echeancier->delete();

        return redirect()->route('echeanciers.index')->with('success', 'Echéancier supprimé avec succès.');
    }
}
