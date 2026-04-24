<?php

use Laravel\Dusk\Browser;

/**
 * Tests des pages publiques du site U-Trail Limal.
 */

test('la page d\'accueil est accessible et affiche les éléments principaux', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertTitle('Utrail Limal')
            ->assertSee('U-Trail Limal')
            ->assertSee('Intégrer le projet')
            ->assertSee('U-Trail Limal c\'est quoi ?');
    });
});

test('la navigation principale est présente sur la page d\'accueil', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertPresent('nav');
    });
});

test('le footer est présent sur la page d\'accueil', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertPresent('footer');
    });
});

test('la page Présentation est accessible', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Presentation')
            ->assertTitleContains('Présentation');
    });
});

test('la page Projet est accessible', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Projet')
            ->assertSee('Projet');
    });
});

test('la page Équipe est accessible', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Equipe')
            ->assertSee('quipe');
    });
});

test('la page Formation est accessible', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Formation')
            ->assertSee('Formation');
    });
});

test('la page Contact est accessible et affiche le titre', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Contact')
            ->assertTitleContains('Contact')
            ->assertSee('Contact');
    });
});

test('la page Mentions légales est accessible', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/MentionLegale')
            ->assertTitleContains('Mention');
    });
});

test('la page Confidentialité est accessible', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/Confidentialite')
            ->assertSee('confidentialité');
    });
});

test('le lien "Intégrer le projet" mène à la page d\'inscription', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->click('a[href="/Inscription"]')
            ->pause(500)
            ->assertPathIs('/Inscription')
            ->assertSee('Inscription au projet');
    });
});

test('les liens de navigation fonctionnent depuis l\'accueil', function () {
    $this->browse(function (Browser $browser) {
        // Équipe
        $browser->visit('/')
            ->click('a[href="/Equipe"]')
            ->pause(500)
            ->assertPathIs('/Equipe');

        // Contact
        $browser->visit('/')
            ->click('a[href="/Contact"]')
            ->pause(500)
            ->assertPathIs('/Contact');
    });
});
