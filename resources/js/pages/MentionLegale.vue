<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>Mentions légales</title>
        <meta
            name="description"
            content="Mentions légales du club de trail U-Trail Limal. Éditeur du site, hébergement, propriété intellectuelle, données personnelles et cookies."
        />
        <meta name="robots" content="noindex, follow" />
    </Head>

    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/mention.jpg"
                alt="Mentions légales U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>

    <main id="main-content" class="bg-[#f6f6f6]">
        <section class="mx-auto w-full max-w-[860px] px-4 py-12 md:py-20">
            <h1
                class="mb-10 text-3xl font-bold text-[#B3A96F] md:text-4xl lg:text-[48px]"
            >
                Mentions légales
            </h1>

            <!-- 1. Éditeur du site -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    1. Éditeur du site
                </h2>
                <ul class="space-y-2 text-sm text-gray-700 md:text-base">
                    <li>
                        <span class="font-medium"
                            >Nom de l'association / club :</span
                        >
                        [Nom du club de trail]
                    </li>
                    <li>
                        <span class="font-medium">Statut juridique :</span>
                        [ASBL / Association / autre]
                    </li>
                    <li>
                        <span class="font-medium"
                            >Numéro d'entreprise (BCE) :</span
                        >
                        [Numéro BCE]
                    </li>
                    <li>
                        <span class="font-medium"
                            >Adresse du siège social :</span
                        >
                        [Adresse complète, code postal, ville, Belgique]
                    </li>
                    <li>
                        <span class="font-medium">E-mail de contact :</span>
                        [adresse e-mail]
                    </li>
                    <li>
                        <span class="font-medium">Téléphone :</span> [numéro de
                        téléphone]
                    </li>
                    <li>
                        <span class="font-medium">Représentant légal :</span>
                        [Nom et prénom du président ou responsable]
                    </li>
                </ul>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 2. Hébergement du site -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    2. Hébergement du site
                </h2>
                <ul class="space-y-2 text-sm text-gray-700 md:text-base">
                    <li>
                        <span class="font-medium">Nom de l'hébergeur :</span>
                        [Nom de l'hébergeur web]
                    </li>
                    <li>
                        <span class="font-medium">Adresse :</span> [Adresse de
                        l'hébergeur]
                    </li>
                    <li>
                        <span class="font-medium">Téléphone :</span> [Numéro de
                        l'hébergeur]
                    </li>
                    <li>
                        <span class="font-medium">Site web :</span> [URL de
                        l'hébergeur]
                    </li>
                </ul>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 3. Propriété intellectuelle -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    3. Propriété intellectuelle
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        L'ensemble du contenu présent sur ce site (textes,
                        images, logos, photographies, vidéos, éléments
                        graphiques, structure, etc.) est protégé par le droit de
                        la propriété intellectuelle.
                    </p>
                    <p>
                        Sauf mention contraire, ces contenus sont la propriété
                        exclusive de [Nom du club de trail].
                    </p>
                    <p>
                        Toute reproduction, représentation, modification,
                        publication, transmission ou adaptation, totale ou
                        partielle, du site ou de ses éléments, est interdite
                        sans autorisation écrite préalable.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 4. Données personnelles -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    4. Données personnelles
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Les informations recueillies via le site (formulaire de
                        contact, inscription, etc.) sont utilisées uniquement
                        dans le cadre des activités du club.
                    </p>
                    <ul class="space-y-2">
                        <li>
                            <span class="font-medium"
                                >Responsable du traitement des données :</span
                            >
                            [Nom du responsable]
                        </li>
                        <li>
                            <span class="font-medium"
                                >Finalité des données :</span
                            >
                            gestion des membres, communication, organisation
                            d'événements, etc.
                        </li>
                        <li>
                            <span class="font-medium">Base légale :</span>
                            consentement de l'utilisateur et/ou intérêt légitime
                            du club.
                        </li>
                        <li>
                            <span class="font-medium"
                                >Durée de conservation :</span
                            >
                            [ex. 3 ans après dernier contact]
                        </li>
                    </ul>
                    <p>
                        Conformément au RGPD, vous disposez des droits suivants
                        :
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>Droit d'accès</li>
                        <li>Droit de rectification</li>
                        <li>Droit à l'effacement</li>
                        <li>Droit à la limitation du traitement</li>
                        <li>Droit d'opposition</li>
                    </ul>
                    <p>
                        Pour exercer ces droits, contactez : [adresse e-mail
                        RGPD]
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 5. Cookies -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    5. Cookies
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Le site peut utiliser des cookies afin d'améliorer
                        l'expérience utilisateur et réaliser des statistiques de
                        visite.
                    </p>
                    <p>
                        Lors de votre première visite, un bandeau vous permet
                        d'accepter ou de refuser les cookies non essentiels.
                    </p>
                    <p>
                        Vous pouvez à tout moment modifier vos préférences via
                        les paramètres de votre navigateur.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 6. Responsabilité -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    6. Responsabilité
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Le club de trail s'efforce de fournir des informations
                        aussi précises que possible. Toutefois, il ne saurait
                        être tenu responsable des omissions, inexactitudes ou
                        carences dans la mise à jour.
                    </p>
                    <p>
                        Le site peut contenir des liens vers d'autres sites dont
                        le club n'assume aucune responsabilité quant aux
                        contenus.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 7. Droit applicable -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    7. Droit applicable
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Les présentes mentions légales sont régies par le droit
                        belge.
                    </p>
                    <p>
                        En cas de litige et à défaut de résolution amiable, les
                        tribunaux belges seront seuls compétents.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <p class="text-sm text-gray-500">
                Dernière mise à jour : {{ new Date().toLocaleDateString() }}
            </p>
        </section>
    </main>

    <Footer />
</template>
