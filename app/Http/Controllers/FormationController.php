<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FormationController extends Controller
{

    public function formation()
    {
        return Inertia::render('Formation', [
            'formations' => Formation::all(),
        ]);
     }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/formations/Index', [
            'formations' => Formation::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/formations/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'photo' => 'nullable|image|max:5120',
            'niveau' => 'required|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('formations', 'public');
            $validated['photo'] = $photoPath;
        }

        Formation::create($validated);

        return redirect()->route('formations.index')->with('success', 'Formation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/formations/Show', [
            'formation' => Formation::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/formations/Edit', [
            'formation' => Formation::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $formation = Formation::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'photo' => 'nullable|image|max:5120',
            'niveau' => 'required|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            if ($formation->photo) {
                Storage::disk('public')->delete($formation->photo);
            }
            $validated['photo'] = $request->file('photo')->store('formations', 'public');
        }

        $formation->update($validated);

        return redirect()->route('formations.index')->with('success', 'Formation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $formation = Formation::findOrFail($id);
        $formation->delete();

        return redirect()->route('formations.index')->with('success', 'Formation deleted successfully.');
    }
}
