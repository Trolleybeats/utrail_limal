<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;

uses(DatabaseTruncation::class);

/**
 * Tests d'authentification de l'administration.
 *
 * Note : Le middleware RequireTwoFactor redirige vers /settings/security
 * si l'utilisateur n'a pas activé la 2FA. Les tests admin utilisent donc
 * un utilisateur avec la 2FA confirmée.
 */

test('la page de connexion est accessible', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->assertTitleContains('Connexion')
            ->assertSee('Se connecter')
            ->assertPresent('input[name="email"]')
            ->assertPresent('input[name="password"]');
    });
});

test('une tentative de connexion avec des identifiants invalides affiche une erreur', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/login')
            ->type('email', 'inconnu@example.com')
            ->type('password', 'mauvais_mot_de_passe')
            ->press('Se connecter')
            ->pause(1000)
            // Reste sur la page de connexion avec une erreur
            ->assertPathIs('/login')
            ->assertPresent('form');
    });
});

test('un utilisateur peut se connecter et accéder au dashboard', function () {
    $user = User::factory()->withTwoFactor()->create([
        'email' => 'admin_dusk@example.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/dashboard')
            ->assertPathIs('/dashboard')
            ->assertSee('Participants')
            ->assertSee('Membres');
    });
});

test('un utilisateur non authentifié est redirigé vers la page de connexion', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/dashboard')
            ->assertPathIs('/login');
    });
});

test('un utilisateur sans 2FA activée est redirigé vers la confirmation de mot de passe ou la sécurité', function () {
    $user = User::factory()->create([
        'email' => 'sans2fa@example.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/dashboard')
            // Sans 2FA, redirigé hors du dashboard (confirm-password ou settings/security)
            ->assertDontSee("Vue d'ensemble");
    });
});

test('un utilisateur peut se déconnecter', function () {
    $user = User::factory()->withTwoFactor()->create([
        'email' => 'logout_test@example.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/dashboard')
            ->assertAuthenticated();

        // Déconnexion via requête POST (route Fortify)
        $browser->script("
            fetch('/logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.content ?? '',
                    'Accept': 'application/json',
                },
            });
        ");

        $browser->pause(1500)
            ->visit('/dashboard')
            ->assertPathIs('/login');
    });
});
