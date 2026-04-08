<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

//Page statique public
Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
Route::inertia('/Contact', 'Contact')->name('contact');


//Page admin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
