<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

//Page statique public
Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
Route::inertia('/Presentation', 'Presentation')->name('presentation');
Route::inertia('/Projet', 'Projet')->name('projet');
Route::inertia('/Equipe', 'Equipe')->name('equipe');
Route::inertia('/Inscription', 'Inscription')->name('inscription');
Route::inertia('/Paiement', 'Paiement')->name('paiement');
Route::inertia('/Formation', 'Formation')->name('formation');
Route::inertia('/Contact', 'Contact')->name('contact');



//Page admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
