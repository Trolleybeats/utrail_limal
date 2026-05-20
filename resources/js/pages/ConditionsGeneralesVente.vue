<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>Conditions Générales de Vente (CGV)</title>
        <meta
            name="description"
            content="Conditions Générales de Vente du club de trail U-Trail Limal. Inscriptions, tarifs, paiement, annulation, responsabilité et données personnelles."
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
                alt="Conditions Générales de Vente U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>

    <main id="main-content" class="bg-[#f6f6f6]">
        <section class="mx-auto w-full max-w-[860px] px-4 py-12 md:py-20">
            <h1
                class="mb-10 text-3xl font-bold text-[#B3A96F] md:text-4xl lg:text-[48px]"
            >
                Conditions Générales de Vente (CGV)
            </h1>

            <!-- 1. Identification de l'organisateur -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    1. Identification de l'organisateur
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Le site U-Trail Limal est exploité par le club sportif
                        U-Trail Limal, association organisatrice d'activités
                        sportives, de formations et de projets trail.
                    </p>
                    <ul class="space-y-2">
                        <li>
                            <span class="font-medium"
                                >Adresse e-mail de contact :</span
                            >
                            loic.mascre@gmail.com
                        </li>
                        <li>
                            <span class="font-medium">Adresse postale :</span>
                            Rue d'Alvau 33, 1435 Mont-Saint-Guibert, Belgique
                        </li>
                        <li>
                            <span class="font-medium">Site web :</span>
                            <a
                                href="https://www.utrail-limal.be"
                                class="text-blue-600 hover:underline"
                                >https://www.utrail-limal.be</a
                            >
                        </li>
                    </ul>
                    <p>
                        Les présentes Conditions Générales de Vente s'appliquent
                        à toute inscription effectuée via le site.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 2. Objet -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    2. Objet
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Les présentes CGV ont pour objet de définir les
                        conditions de vente applicables aux inscriptions aux
                        activités proposées par U-Trail Limal, notamment :
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>projets annuels,</li>
                        <li>formations,</li>
                        <li>séances d'information,</li>
                        <li>événements et activités sportives,</li>
                        <li>paiements liés aux participations.</li>
                    </ul>
                    <p>
                        Toute inscription implique l'acceptation pleine et
                        entière des présentes conditions.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 3. Processus d'inscription -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    3. Processus d'inscription
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>L'inscription se déroule en plusieurs étapes :</p>
                    <ol class="list-decimal space-y-1 pl-5">
                        <li>
                            Le participant complète un formulaire de
                            pré-inscription ;
                        </li>
                        <li>
                            Un lien personnel de paiement est envoyé par e-mail
                            ;
                        </li>
                        <li>Le participant complète ses informations ;</li>
                        <li>Le paiement est effectué en ligne via Stripe.</li>
                    </ol>
                    <p>
                        L'inscription est considérée comme définitive après
                        validation du paiement ou acceptation d'un plan de
                        paiement échelonné.
                    </p>
                    <p>
                        U-Trail Limal se réserve le droit de refuser une
                        inscription incomplète ou frauduleuse.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 4. Tarifs -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    4. Tarifs
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Les prix affichés sur le site sont exprimés en euros
                        (€).
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>
                            Les tarifs applicables sont ceux affichés au moment
                            de l'inscription.
                        </li>
                        <li>
                            U-Trail Limal se réserve le droit de modifier ses
                            prix à tout moment sans effet rétroactif sur les
                            inscriptions déjà validées.
                        </li>
                    </ul>
                    <p>
                        Certaines options complémentaires peuvent être proposées
                        :
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>logement,</li>
                        <li>équipement,</li>
                        <li>t-shirt,</li>
                        <li>activités annexes.</li>
                    </ul>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 5. Paiement -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    5. Paiement
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Les paiements sont réalisés de manière sécurisée via la
                        plateforme Stripe.
                    </p>
                    <p>
                        Les moyens de paiement acceptés dépendent des options
                        proposées par Stripe au moment du paiement.
                    </p>
                    <p>
                        Les données bancaires ne transitent jamais par les
                        serveurs du club et ne sont pas conservées par celui-ci.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 6. Paiement échelonné -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    6. Paiement échelonné
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Lorsque cette option est proposée, le participant peut
                        choisir un paiement en plusieurs échéances.
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>
                            Le calendrier des versements est communiqué lors de
                            l'inscription.
                        </li>
                        <li>
                            Le participant s'engage à respecter les dates de
                            paiement prévues.
                        </li>
                    </ul>
                    <p>En cas de non-paiement d'une échéance :</p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>
                            le club peut suspendre la participation aux
                            activités ;
                        </li>
                        <li>des rappels peuvent être envoyés par e-mail ;</li>
                        <li>
                            l'accès à certaines prestations peut être refusé
                            jusqu'à régularisation.
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 7. Droit de rétractation -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    7. Droit de rétractation
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Conformément au Code de droit économique belge, le
                        consommateur dispose d'un délai de 14 jours pour exercer
                        son droit de rétractation lorsqu'il s'inscrit à
                        distance.
                    </p>
                    <p>
                        Toutefois, ce droit peut ne plus être applicable lorsque
                        :
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>
                            l'activité a commencé avec l'accord du participant ;
                        </li>
                        <li>l'événement est prévu à une date déterminée ;</li>
                        <li>des prestations ont déjà été réalisées.</li>
                    </ul>
                    <p>
                        Toute demande de rétractation doit être adressée par
                        écrit à l'adresse de contact du club.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 8. Annulation et remboursement -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    8. Annulation et remboursement
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <h3 class="font-semibold text-black">
                        Annulation par le participant
                    </h3>
                    <p>
                        Toute demande d'annulation doit être communiquée par
                        e-mail.
                    </p>
                    <p>
                        Les modalités de remboursement peuvent varier selon la
                        date d'annulation et les frais déjà engagés par le club.
                    </p>
                    <p>Sauf mention contraire :</p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>
                            aucun remboursement ne sera garanti après le début
                            du projet ou de l'événement.
                        </li>
                    </ul>

                    <h3 class="pt-2 font-semibold text-black">
                        Annulation par le club
                    </h3>
                    <p>
                        U-Trail Limal se réserve le droit d'annuler une activité
                        en cas :
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>de force majeure,</li>
                        <li>de conditions météorologiques dangereuses,</li>
                        <li>d'un nombre insuffisant de participants,</li>
                        <li>d'un problème de sécurité.</li>
                    </ul>
                    <p>
                        Dans ce cas, un remboursement total ou partiel pourra
                        être proposé.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 9. Responsabilité -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    9. Responsabilité
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Le participant reconnaît pratiquer les activités
                        sportives sous sa propre responsabilité.
                    </p>
                    <p>Il lui appartient :</p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>de vérifier son aptitude physique ;</li>
                        <li>de disposer d'une assurance adaptée ;</li>
                        <li>
                            de respecter les consignes de sécurité communiquées
                            par les encadrants.
                        </li>
                    </ul>
                    <p>U-Trail Limal ne pourra être tenu responsable :</p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>
                            d'un accident résultant du non-respect des consignes
                            ;
                        </li>
                        <li>d'une perte ou d'un vol d'effets personnels ;</li>
                        <li>
                            d'une indisponibilité temporaire du site ou du
                            système de paiement.
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 10. Protection des données personnelles -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    10. Protection des données personnelles
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Les données personnelles collectées dans le cadre des
                        inscriptions sont traitées conformément au Règlement
                        Général sur la Protection des Données (RGPD).
                    </p>
                    <p>
                        Les informations collectées sont utilisées uniquement
                        pour :
                    </p>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>la gestion des inscriptions,</li>
                        <li>l'organisation des activités,</li>
                        <li>le suivi administratif et comptable,</li>
                        <li>la communication liée au club.</li>
                    </ul>
                    <p>
                        Le participant peut exercer ses droits d'accès, de
                        rectification ou de suppression en contactant le club.
                    </p>
                    <p>
                        La politique de confidentialité complète est accessible
                        sur le site.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 11. Propriété intellectuelle -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    11. Propriété intellectuelle
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        Les contenus présents sur le site (textes, photos,
                        vidéos, logo, identité graphique) sont protégés par le
                        droit d'auteur.
                    </p>
                    <p>
                        Toute reproduction ou utilisation sans autorisation
                        préalable est interdite.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 12. Droit applicable et juridiction compétente -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    12. Droit applicable et juridiction compétente
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>Les présentes CGV sont soumises au droit belge.</p>
                    <p>
                        En cas de litige, les parties privilégieront une
                        solution amiable avant toute action judiciaire.
                    </p>
                    <p>
                        À défaut d'accord, les tribunaux compétents de
                        l'arrondissement judiciaire du Brabant wallon seront
                        seuls compétents.
                    </p>
                </div>
            </div>

            <hr class="mb-10 border-gray-300" />

            <!-- 13. Modification des conditions générales -->
            <div class="mb-10">
                <h2 class="mb-4 text-xl font-semibold text-black md:text-2xl">
                    13. Modification des conditions générales
                </h2>
                <div class="space-y-3 text-sm text-gray-700 md:text-base">
                    <p>
                        U-Trail Limal se réserve le droit de modifier les
                        présentes CGV à tout moment.
                    </p>
                    <p>
                        Les conditions applicables sont celles en vigueur à la
                        date de l'inscription du participant.
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
