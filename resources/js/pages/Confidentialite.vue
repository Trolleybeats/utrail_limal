<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>Politique de confidentialité</title>
        <meta
            name="description"
            content="Politique de confidentialité du club de trail U-Trail Limal. Découvrez comment nous collectons, utilisons et protégeons vos données personnelles (RGPD)."
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
                src="/storage/confidentialite.jpg"
                alt="Politique de confidentialité U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>

    <main class="bg-[#f6f6f6]">
        <section class="mx-auto w-full max-w-[860px] px-4 py-12 md:py-20">
            <h1
                class="mb-10 text-3xl font-bold text-[#B3A96F] md:text-4xl lg:text-[48px]"
            >
                Politique de confidentialité
            </h1>

            <!-- 1. Introduction -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    1. Introduction
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        La présente politique de confidentialité décrit la
                        manière dont le site du club de trail basé à Limal
                        (Belgique) collecte, utilise et protège vos données
                        personnelles.
                    </p>
                    <p>
                        En utilisant ce site, vous acceptez la collecte et
                        l'utilisation de vos données conformément à cette
                        politique.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 2. Responsable du traitement -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    2. Responsable du traitement
                </h2>
                <ul class="space-y-2 text-sm text-gray-700 md:text-base">
                    <li>
                        <span class="font-medium">Nom du club :</span> [Nom du
                        club de trail]
                    </li>
                    <li>
                        <span class="font-medium">Statut juridique :</span>
                        [ASBL / autre]
                    </li>
                    <li>
                        <span class="font-medium">Adresse :</span> [Adresse
                        complète]
                    </li>
                    <li>
                        <span class="font-medium">E-mail de contact :</span>
                        [adresse e-mail]
                    </li>
                    <li>
                        <span class="font-medium"
                            >Responsable du traitement des données :</span
                        >
                        [Nom et prénom]
                    </li>
                </ul>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 3. Données collectées -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    3. Données collectées
                </h2>
                <p class="mb-4 text-sm text-gray-700 md:text-base">
                    Dans le cadre de nos activités, nous pouvons collecter les
                    données suivantes :
                </p>

                <div class="space-y-6">
                    <div>
                        <h3
                            class="mb-2 text-base font-semibold text-black md:text-lg"
                        >
                            3.1 Formulaire de contact
                        </h3>
                        <ul
                            class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                        >
                            <li>Nom et prénom</li>
                            <li>Adresse e-mail</li>
                            <li>Message</li>
                        </ul>
                    </div>

                    <div>
                        <h3
                            class="mb-2 text-base font-semibold text-black md:text-lg"
                        >
                            3.2 Inscription aux événements
                        </h3>
                        <ul
                            class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                        >
                            <li>Nom et prénom</li>
                            <li>Date de naissance (si nécessaire)</li>
                            <li>Adresse e-mail</li>
                            <li>Numéro de téléphone</li>
                            <li>
                                Informations médicales éventuelles (si demandées
                                pour la sécurité)
                            </li>
                            <li>Historique d'inscription aux événements</li>
                        </ul>
                    </div>

                    <div>
                        <h3
                            class="mb-2 text-base font-semibold text-black md:text-lg"
                        >
                            3.3 Paiement en ligne (Stripe)
                        </h3>
                        <p class="mb-2 text-sm text-gray-700 md:text-base">
                            Lors des paiements en ligne via Stripe, nous pouvons
                            collecter ou traiter :
                        </p>
                        <ul
                            class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                        >
                            <li>Nom et prénom</li>
                            <li>Adresse e-mail</li>
                            <li>Informations de facturation</li>
                            <li>Statut de paiement</li>
                        </ul>
                        <p
                            class="mt-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800"
                        >
                            ⚠️ Les données de carte bancaire ne sont jamais
                            stockées par le club. Elles sont traitées
                            directement et de manière sécurisée par Stripe.
                        </p>
                    </div>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 4. Finalités du traitement -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    4. Finalités du traitement
                </h2>
                <p class="mb-3 text-sm text-gray-700 md:text-base">
                    Les données personnelles sont utilisées pour :
                </p>
                <ul
                    class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                >
                    <li>Répondre aux demandes via le formulaire de contact</li>
                    <li>Gérer les inscriptions aux événements sportifs</li>
                    <li>Organiser et sécuriser les activités du club</li>
                    <li>Gérer les paiements et la comptabilité</li>
                    <li>
                        Communiquer des informations liées aux activités du club
                    </li>
                </ul>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 5. Base légale du traitement -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    5. Base légale du traitement
                </h2>
                <p class="mb-3 text-sm text-gray-700 md:text-base">
                    Le traitement des données repose sur :
                </p>
                <ul
                    class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                >
                    <li>Le consentement de l'utilisateur</li>
                    <li>
                        L'exécution d'un contrat (inscription à un événement)
                    </li>
                    <li>
                        L'intérêt légitime du club (organisation des activités)
                    </li>
                    <li>Obligations légales (comptabilité)</li>
                </ul>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 6. Partage des données -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    6. Partage des données
                </h2>
                <p class="mb-3 text-sm text-gray-700 md:text-base">
                    Les données personnelles peuvent être partagées avec :
                </p>
                <ul
                    class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                >
                    <li>
                        <span class="font-medium"
                            >Prestataire de paiement :</span
                        >
                        Stripe (paiements sécurisés)
                    </li>
                    <li>
                        <span class="font-medium">Hébergeur du site web :</span>
                        [nom de l'hébergeur]
                    </li>
                    <li>
                        Outils de gestion des inscriptions ou e-mails (si
                        utilisés)
                    </li>
                </ul>
                <p class="mt-3 text-sm font-medium text-gray-700 md:text-base">
                    Le club ne vend jamais vos données personnelles.
                </p>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 7. Conservation des données -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    7. Conservation des données
                </h2>
                <p class="mb-3 text-sm text-gray-700 md:text-base">
                    Les données sont conservées pendant une durée limitée :
                </p>
                <ul
                    class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                >
                    <li>
                        <span class="font-medium">Données de contact :</span>
                        jusqu'à 3 ans après le dernier échange
                    </li>
                    <li>
                        <span class="font-medium">Données d'inscription :</span>
                        durée nécessaire à la gestion administrative et légale
                    </li>
                    <li>
                        <span class="font-medium">Données de paiement :</span>
                        selon les obligations comptables légales (jusqu'à 7 ans
                        en Belgique)
                    </li>
                </ul>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 8. Sécurité des données -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    8. Sécurité des données
                </h2>
                <p class="text-sm text-gray-700 md:text-base">
                    Le club met en œuvre toutes les mesures techniques et
                    organisationnelles appropriées pour protéger vos données
                    contre la perte, l'accès non autorisé, la divulgation ou la
                    modification.
                </p>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 9. Cookies -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    9. Cookies
                </h2>
                <p class="mb-3 text-sm text-gray-700 md:text-base">
                    Le site utilise des cookies pour :
                </p>
                <ul
                    class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                >
                    <li>Assurer son bon fonctionnement</li>
                    <li>Améliorer l'expérience utilisateur</li>
                    <li>Réaliser des statistiques de fréquentation</li>
                </ul>
                <p class="mt-3 text-sm text-gray-700 md:text-base">
                    Vous pouvez accepter ou refuser les cookies non essentiels
                    via le bandeau prévu à cet effet.
                </p>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 10. Vos droits (RGPD) -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    10. Vos droits (RGPD)
                </h2>
                <p class="mb-3 text-sm text-gray-700 md:text-base">
                    Conformément au Règlement Général sur la Protection des
                    Données (RGPD), vous disposez des droits suivants :
                </p>
                <ul
                    class="list-disc space-y-1 pl-5 text-sm text-gray-700 md:text-base"
                >
                    <li>Droit d'accès à vos données</li>
                    <li>Droit de rectification</li>
                    <li>Droit à l'effacement (droit à l'oubli)</li>
                    <li>Droit à la limitation du traitement</li>
                    <li>Droit d'opposition</li>
                    <li>Droit à la portabilité des données</li>
                </ul>
                <p class="mt-3 text-sm text-gray-700 md:text-base">
                    Pour exercer vos droits : [adresse e-mail RGPD]
                </p>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 11. Transfert hors Union européenne -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    11. Transfert hors Union européenne
                </h2>
                <p class="text-sm text-gray-700 md:text-base">
                    Certaines données peuvent être traitées en dehors de l'Union
                    européenne (ex : Stripe). Dans ce cas, des garanties
                    appropriées sont mises en place conformément au RGPD.
                </p>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 12. Modifications de la politique -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    12. Modifications de la politique
                </h2>
                <p class="text-sm text-gray-700 md:text-base">
                    Cette politique de confidentialité peut être mise à jour à
                    tout moment. La date de dernière mise à jour sera indiquée
                    ci-dessous.
                </p>
            </div>

            <hr class="mb-10 border-gray-300" />

            <p class="text-sm text-gray-500">
                Dernière mise à jour : {{ new Date().toLocaleDateString() }}
            </p>
        </section>
    </main>

    <Footer />
</template>
