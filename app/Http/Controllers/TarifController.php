<?php

namespace App\Http\Controllers;

use App\Models\Tarif;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/tarifs/Index',[
            'tarifs' => Tarif::all()
        ]);
    }

    public function tarifsActifs(Tarif $tarif)
    {
        $tarif->update(['est_actif' => !$tarif->est_actif]);

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/tarifs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'est_actif' => 'required|boolean',
        ]);

        Tarif::create($request->only('label', 'categorie', 'prix', 'est_actif'));

        return redirect()->route('tarifs.index')->with('success', 'Tarif créé avec succès.');
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
        return Inertia::render('admin/tarifs/Edit', [
            'tarif' => Tarif::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'categorie' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'est_actif' => 'required|boolean',
        ]);

        $tarif = Tarif::findOrFail($id);
        $tarif->update($request->only('label', 'categorie', 'prix', 'est_actif'));

        return redirect()->route('tarifs.index')->with('success', 'Tarif mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarif = Tarif::findOrFail($id);
        $tarif->delete();

        return redirect()->route('tarifs.index')->with('success', 'Tarif supprimé avec succès.');
    }
}
