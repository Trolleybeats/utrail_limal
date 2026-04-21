<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
    membre: {
        type: Object,
        required: true,
    },
});

const isSuccess = props.status === 'succeeded';
</script>

<template>
    <Head>
        <title>Paiement {{ isSuccess ? 'confirmé' : 'en attente' }}</title>
        <meta
            name="description"
            content="Confirmation de paiement pour votre inscription au trail annuel organisé par U-Trail Limal. Merci pour votre participation à notre événement trail en Brabant wallon."
        />
        <meta
            name="keywords"
            content="confirmation paiement, inscription trail, paiement réussi, paiement en attente, trail annuel, événement trail, U-Trail Limal"
        />
        <meta
            property="og:title"
            content="Paiement {{ isSuccess ? 'confirmé' : 'en attente' }}"
        />
        <meta
            property="og:description"
            content="Confirmation de paiement pour votre inscription au trail annuel organisé par U-Trail Limal. Merci pour votre participation à notre événement trail en Brabant wallon."
        />
    </Head>
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-[580px]"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/paiement.jpg"
                alt="Paiement U-Trail Limal"
                class="h-full w-full object-cover object-[center_60%]"
            />
        </figure>
    </header>
    <main>
        <section
            class="relative mx-auto flex w-full max-w-[1182px] items-center justify-center px-4 py-8 md:py-14"
        >
            <h2
                class="mb-6 w-full text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                {{ isSuccess ? 'Paiement confirmé' : 'Paiement en attente' }}
            </h2>
        </section>

        <section class="mx-auto w-full max-w-[640px] px-4 pb-14">
            <div class="rounded-[6px] bg-white px-6 py-8 text-center">
                <div v-if="isSuccess">
                    <p class="mb-4 text-[18px] font-medium text-[#586166]">
                        Merci
                        <span class="font-semibold text-[#B3A96F]">
                            {{ membre.participant.prenom }}
                            {{ membre.participant.nom }}
                        </span>
                        , votre paiement de
                        <span class="font-semibold text-[#B3A96F]">
                            {{ membre.montant_total.toFixed(2) }} €
                        </span>
                        a bien été reçu.
                    </p>
                    <p class="text-[16px] text-[#586166]">
                        Votre inscription est maintenant complète. Vous recevrez
                        une confirmation par e-mail.
                    </p>
                </div>
                <div v-else>
                    <p class="text-[18px] text-[#586166]">
                        Votre paiement est en cours de traitement. Vous recevrez
                        une confirmation dès qu'il sera validé.
                    </p>
                </div>
            </div>
        </section>
    </main>
    <Footer />
</template>
