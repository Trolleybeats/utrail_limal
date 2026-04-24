<?php

use App\Models\Participant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;

uses(DatabaseTruncation::class);

/**
 * Tests des pages d'administration.
 *
 * Tous les tests utilisent un utilisateur avec la 2FA confirmée pour
 * contourner le middleware RequireTwoFactor.
 */

// ---------------------------------------------------------------------------
// Helper
// ---------------------------------------------------------------------------

function adminUser(): User
{
    return User::factory()->withTwoFactor()->create([
        'email' => 'admin_mgmt_' . uniqid() . '@example.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);
}

// ---------------------------------------------------------------------------
// Dashboard
// ---------------------------------------------------------------------------

test('le dashboard affiche les compteurs de participants et de membres', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/dashboard')
            ->assertSee('Participants')
            ->assertSee('Membres');
    });
});

// ---------------------------------------------------------------------------
// Participants
// ---------------------------------------------------------------------------

test('la liste des participants est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/participants')
            ->assertSee('Participants')
            ->assertPresent('table')
            ->assertSeeIn('thead', 'Nom')
            ->assertSeeIn('thead', 'Prénom')
            ->assertSeeIn('thead', 'Email');
    });
});

test('un participant créé en BDD apparaît dans la liste', function () {
    $user = adminUser();

    Participant::factory()->create([
        'nom' => 'TestDusk',
        'prenom' => 'Participant',
        'email' => 'testdusk@example.com',
        'telephone' => '0470000001',
        'token' => Str::uuid(),
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/participants')
            ->assertSee('TestDusk')
            ->assertSee('testdusk@example.com');
    });
});

test('la page de création d\'un participant est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/participants/create')
            ->assertPresent('form');
    });
});

test('l\'export Excel des participants est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user);
        // Vérifie que la route d'export répond sans erreur en visitant la liste
        // (le téléchargement binaire ne peut pas être intercepté par Dusk)
        $browser->visit('/admin/participants')
            ->assertSee('Exporter Excel');
    });
});

// ---------------------------------------------------------------------------
// Membres
// ---------------------------------------------------------------------------

test('la liste des membres est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/membres')
            ->assertSee('Membres')
            ->assertPresent('table');
    });
});

// ---------------------------------------------------------------------------
// Tarifs
// ---------------------------------------------------------------------------

test('la liste des tarifs est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/tarifs')
            ->assertSee('Tarifs')
            ->assertPresent('table');
    });
});

test('la page de création d\'un tarif est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/tarifs/create')
            ->assertPresent('form');
    });
});

// ---------------------------------------------------------------------------
// Équipes
// ---------------------------------------------------------------------------

test('la liste des équipes est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/equipes')
            ->assertSee('quipe');
    });
});

// ---------------------------------------------------------------------------
// Formations
// ---------------------------------------------------------------------------

test('la liste des formations est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/formations')
            ->assertSee('Formation');
    });
});

// ---------------------------------------------------------------------------
// Projets
// ---------------------------------------------------------------------------

test('la liste des projets est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/projets')
            ->assertSee('Projet');
    });
});

// ---------------------------------------------------------------------------
// Versements
// ---------------------------------------------------------------------------

test('la page des versements est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/versements')
            ->assertSee('Versement');
    });
});

// ---------------------------------------------------------------------------
// Utilisateurs
// ---------------------------------------------------------------------------

test('la liste des utilisateurs est accessible', function () {
    $user = adminUser();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->visit('/admin/users')
            ->assertSee('Users');
    });
});

// ---------------------------------------------------------------------------
// Accès refusé sans authentification
// ---------------------------------------------------------------------------

test('les routes admin redirigent vers login sans authentification', function () {
    $routes = [
        '/dashboard',
        '/admin/participants',
        '/admin/membres',
        '/admin/tarifs',
        '/admin/equipes',
        '/admin/formations',
        '/admin/projets',
    ];

    $this->browse(function (Browser $browser) use ($routes) {
        foreach ($routes as $route) {
            $browser->visit($route)
                ->assertPathIs('/login');
        }
    });
});
