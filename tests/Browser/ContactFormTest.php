<?php

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;

uses(DatabaseTruncation::class);

/**
 * Tests du formulaire de contact.
 */

test('la page Contact affiche le formulaire', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Contact')
            ->assertSee('Contact')
            ->assertSee('Une question sur le projet?')
            ->assertPresent('form')
            ->assertPresent('button[type="submit"]');
    });
});

test('l\'envoi du formulaire de contact avec des données valides réinitialise le formulaire', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Contact')
            ->type('#prenom', 'Marie')
            ->type('#nom', 'Martin')
            ->type('#email', 'marie.martin@example.com')
            ->type('#telephone', '0470123456')
            ->type('#message', 'Bonjour, je souhaite obtenir des informations sur le projet.')
            ->press('Envoyer')
            // Attendre que le champ email soit vidé par form.reset() après la réponse Inertia
            ->waitUntil("document.querySelector('#email').value === ''", 15)
            ->assertPathIs('/Contact');
    });

    expect(\App\Models\ContactForm::where('email', 'marie.martin@example.com')->exists())->toBeTrue();
});

test('le formulaire de contact affiche des erreurs si les champs requis sont vides', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Contact')
            ->press('Envoyer')
            ->pause(3000)
            // Inertia renvoie les erreurs de validation : au moins un message d'erreur doit apparaître
            ->assertPresent('.text-red-500');
    });
});
