<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        {{-- Global SEO meta tags --}}
        <meta name="robots" content="index, follow">
        <meta name="author" content="Utrail Limal">
        <meta name="language" content="fr">
        <meta name="geo.region" content="BE-WBR">
        <meta name="geo.placename" content="Limal, Brabant wallon, Belgique">

        {{-- Global Open Graph --}}
        <meta property="og:site_name" content="Utrail Limal">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="fr_BE">

        {{-- Global keywords (trail, club, Belgique) --}}
        <meta name="keywords" content="trail, club de trail, Brabant wallon, Limal, traileurs Belgique, événements trail, inscription trail, formation trail, équipe trail, course nature, trail francophone, entraînement trail, courses Belgique, course à pied, running, sport nature, outdoor, sport collectif, parcours trail, défi sportif, randonnée sportive, compétition trail, coach trail, préparation trail, course longue distance, trail annuel, courses locales, club sportif, loisirs sportifs, événement sportif, santé sport">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        <x-inertia::head>
            <title>{{ config('app.name', 'Utrail Limal') }}</title>
        </x-inertia::head>
    </head>
    <body class="font-sans antialiased">
        <x-inertia::app />
    </body>
</html>
