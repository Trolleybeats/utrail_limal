<?php

use App\Http\Controllers\EquipeController;
use App\Http\Controllers\PhotoProjetController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Page statique public
Route::get('/', [ProjetController::class, 'welcome'])->name('home');
Route::get('/Presentation', [ProjetController::class, 'presentation'])->name('presentation');
Route::get('/Projet', [ProjetController::class, 'projetPage'])->name('projet');
Route::get('/Equipe', [EquipeController::class, 'equipe'])->name('equipe');
Route::inertia('/Inscription', 'Inscription')->name('inscription');
Route::inertia('/Paiement', 'Paiement')->name('paiement');
Route::inertia('/Formation', 'Formation')->name('formation');
Route::inertia('/Contact', 'Contact')->name('contact');

//Page admin
Route::middleware(['auth', 'verified'])->group(function () {

    //Page accueil admin
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    //Gestion des utilisateurs
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users');

    //Gestion des projets
    Route::resource('admin/projets', ProjetController::class);
    Route::post('admin/projets/reorder', [ProjetController::class, 'reorder'])->name('admin.projets.reorder');
    Route::post('admin/photos-projet', [PhotoProjetController::class, 'store'])->name('admin.photos-projet.store');
    Route::patch('admin/photos-projet/{photo}/principale', [PhotoProjetController::class, 'definirPrincipale'])->name('admin.photos-projet.principale');
    Route::delete('admin/photos-projet/{photo}', [PhotoProjetController::class, 'destroy'])->name('admin.photos-projet.destroy');

    //Gestion des équipes
    Route::resource('admin/equipes', EquipeController::class);
    Route::delete('admin/equipes/{equipe}/photo', [EquipeController::class, 'deletePhoto'])->name('admin.equipes.photo.delete');
});

require __DIR__.'/settings.php';
