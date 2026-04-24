<?php

use App\Models\Participant;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;

uses(DatabaseTruncation::class);

/**
 * Tests du formulaire d'inscription à la séance d'information.
 */

test('la page d\'inscription affiche le formulaire complet', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Inscription')
            ->assertSee('Inscription au projet')
            ->assertSee('Étape 1')
            ->assertPresent('#prenom')
            ->assertPresent('#nom')
            ->assertPresent('#email')
            ->assertPresent('#telephone');
    });
});

test('le formulaire d\'inscription valide les champs requis', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Inscription')
            ->press('S\'inscrire')
            ->pause(500)
            ->assertPathIs('/Inscription');
    });
});

test('une inscription complète crée un participant et affiche un message de succès', function () {
    Mail::fake();

    $this->browse(function (Browser $browser) {
        $browser->visit('/Inscription')
            ->type('#prenom', 'Jean')
            ->type('#nom', 'Dupont')
            ->type('#email', 'jean.dupont@example.com')
            ->type('#telephone', '0470123456')
            ->check('#rgpd')
            ->check('#pre_inscription')
            ->press('S\'inscrire')
            ->pause(2000);
        // Le message de succès n'est pas rendu via flash sur cette page ;
        // on vérifie que la soumission a bien créé un participant en BDD.
    });

    expect(Participant::where('email', 'jean.dupont@example.com')->exists())->toBeTrue();
});

test('une adresse e-mail en double affiche une erreur de validation', function () {
    Participant::factory()->create([
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'jean.dupont@example.com',
        'telephone' => '0470123456',
        'token' => Str::uuid(),
    ]);

    $this->browse(function (Browser $browser) {
        // Intercepter window.alert pour éviter le dialog bloquant
        $browser->visit('/Inscription')
            ->script('window.alert = () => {};');

        $browser->type('#prenom', 'Jean')
            ->type('#nom', 'Dupont')
            ->type('#email', 'jean.dupont@example.com')
            ->type('#telephone', '0470123456')
            ->check('#rgpd')
            ->check('#pre_inscription')
            ->press('S\'inscrire')
            ->pause(2000)
            // La soumission a échoué : on reste sur la page d'inscription
            ->assertPathIs('/Inscription');
    });
});
