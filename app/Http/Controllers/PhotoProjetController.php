<?php

namespace App\Http\Controllers;

use App\Models\PhotoProjet;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoProjetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'photos.*' => 'required|image|max:5120',
        ]);

        $projet = Projet::findOrFail($request->projet_id);

        foreach ($request->file('photos', []) as $file) {
            $chemin = $file->store('projets', 'public');
            $projet->photos()->create(['chemin' => $chemin]);
        }

        return back()->with('success', 'Photos ajoutées avec succès.');
    }

    public function destroy(string $id)
    {
        $photo = PhotoProjet::findOrFail($id);

        // Si c'est la photo principale, on retire la référence d'abord
        $photo->projet()->where('photo_id', $photo->id)->update(['photo_id' => null]);

        Storage::disk('public')->delete($photo->chemin);
        $photo->delete();

        return back()->with('success', 'Photo supprimée avec succès.');
    }

    public function definirPrincipale(string $id)
    {
        $photo = PhotoProjet::findOrFail($id);
        $photo->projet->update(['photo_id' => $photo->id]);

        return back()->with('success', 'Photo principale définie.');
    }
}
