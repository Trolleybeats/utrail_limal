<?php

use App\Http\Controllers\EnvoiContactFormController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\MembreController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PhotoProjetController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\UserController;
use App\Models\Membre;
use App\Models\Participant;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Page statique public
Route::get('/', [ProjetController::class, 'welcome'])->name('home');
Route::get('/Presentation', [ProjetController::class, 'presentation'])->name('presentation');
Route::get('/Projet', [ProjetController::class, 'projetPage'])->name('projet');
Route::get('/Equipe', [EquipeController::class, 'equipe'])->name('equipe');
Route::inertia('/Inscription', 'Inscription')->name('inscription');
Route::post('/inscription', [ParticipantController::class, 'store'])->name('inscription.store');
Route::get('/paiement/confirmation', [PaiementController::class, 'confirmation'])->name('paiement.confirmation');
Route::get('/paiement/{token}', [MembreController::class, 'create'])->name('paiement');
Route::post('/paiement/{token}', [MembreController::class, 'store'])->name('paiement.store');
Route::get('/checkout/{membre}', [PaiementController::class, 'show'])->name('checkout');
Route::get('/Formation', [FormationController::class, 'formation'])->name('formation');
Route::inertia('/Contact', 'Contact')->name('contact');

//Contact form submission
Route::post('/contact', EnvoiContactFormController::class)->name('contact.submit');

//Page admin
Route::middleware(['auth', 'verified'])->group(function () {

    //Page accueil admin
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard', [
            'participantsCount' => Participant::count(),
            'membresCount' => Membre::count(),
        ]);
    })->name('dashboard');

    //Gestion des utilisateurs
    Route::resource('admin/users', UserController::class);


    //Gestion des projets
    Route::resource('admin/projets', ProjetController::class);
    Route::post('admin/projets/reorder', [ProjetController::class, 'reorder'])->name('admin.projets.reorder');
    Route::post('admin/photos-projet', [PhotoProjetController::class, 'store'])->name('admin.photos-projet.store');
    Route::patch('admin/photos-projet/{photo}/principale', [PhotoProjetController::class, 'definirPrincipale'])->name('admin.photos-projet.principale');
    Route::delete('admin/photos-projet/{photo}', [PhotoProjetController::class, 'destroy'])->name('admin.photos-projet.destroy');

    //Gestion des équipes
    Route::resource('admin/equipes', EquipeController::class);
    Route::post('admin/equipes/reorder', [EquipeController::class, 'reorder'])->name('admin.equipes.reorder');
    Route::delete('admin/equipes/{equipe}/photo', [EquipeController::class, 'deletePhoto'])->name('admin.equipes.photo.delete');
    Route::patch('admin/equipes/{equipe}/masquer', [EquipeController::class, 'masquer'])->name('admin.equipes.masquer');

    //Gestion des formations
    Route::resource('admin/formations', FormationController::class);

    //Gestion des participants
    Route::post('admin/participants/send-mail-all', [ParticipantController::class, 'sendMailAll'])->name('admin.participants.send-mail-all');
    Route::get('admin/participants/export', [ParticipantController::class, 'export'])->name('admin.participants.export');
    Route::resource('admin/participants', ParticipantController::class);
    Route::post('admin/participants/{participant}/send-mail', [ParticipantController::class, 'resendMail'])->name('admin.participants.resend-mail');

    //Gestion des membres
    Route::get('admin/membres/export', [MembreController::class, 'export'])->name('admin.membres.export');
    Route::resource('admin/membres', MembreController::class);

    //Gestion des tarifs
    Route::resource('admin/tarifs', \App\Http\Controllers\TarifController::class);
    Route::patch('admin/tarifs/{tarif}/actifs', [\App\Http\Controllers\TarifController::class, 'tarifsActifs'])->name('admin.tarifs.actifs');

    //Gestion des échéanciers
    Route::resource('admin/echeanciers', \App\Http\Controllers\EcheancierController::class);
    Route::patch('admin/echeanciers/{echeancier}/actifs', [\App\Http\Controllers\EcheancierController::class, 'echeanciersActifs'])->name('admin.echeanciers.actifs');
});

require __DIR__.'/settings.php';
