<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import CheckoutSummary from '@/components/site/CheckoutSummary.vue';
import PaymentModeToggle from '@/components/site/PaymentModeToggle.vue';
import { computed, onMounted, ref } from 'vue';
import { loadStripe } from '@stripe/stripe-js';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const flashError = ref(page.props.flash?.error ?? null);

const props = defineProps({
    membre: {
        type: Object,
        required: true,
    },
    clientSecret: {
        type: String,
        required: true,
    },
    stripeKey: {
        type: String,
        required: true,
    },
    echeanciers: {
        type: Array,
        default: () => [],
    },
    echeancier: {
        type: Object,
        default: null,
    },
    versement: {
        type: Object,
        default: null,
    },
    versements: {
        type: Array,
        default: () => [],
    },
});

const isLoading = ref(false);
const errorMessage = ref(null);
let stripe = null;
let elements = null;

// ── Payment mode toggle (caché en mode versement unique) ──────────────────────
const toggleRef = ref(null);

const showToggle = computed(
    () => !props.versement && props.echeanciers.length > 0,
);

const montantAPayer = computed(() => {
    if (props.versement) {
        return props.versement.montant;
    }
    if (
        toggleRef.value?.paymentMode === 'echelonne' &&
        toggleRef.value?.currentVersements.length > 0
    ) {
        return toggleRef.value.currentVersements[0].montant;
    }
    return props.membre.montant_total;
});

// ── Stripe init ────────────────────────────────────────────────────────────
onMounted(async () => {
    stripe = await loadStripe(props.stripeKey);
    mountElements();
});

function mountElements() {
    elements = stripe.elements({
        clientSecret: props.clientSecret,
        appearance: {
            theme: 'stripe',
            variables: { colorPrimary: '#B3A96F' },
        },
    });

    const paymentElement = elements.create('payment', {
        paymentMethodOrder: ['bancontact'],
        wallets: { applePay: 'never', googlePay: 'never' },
    });
    paymentElement.mount('#payment-element');
}

// ── Stripe confirm ─────────────────────────────────────────────────────────
const handleSubmit = async () => {
    isLoading.value = true;
    errorMessage.value = null;

    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            return_url: window.location.origin + '/paiement/confirmation',
        },
    });

    if (error) {
        errorMessage.value = error.message;
        isLoading.value = false;
    }
};
</script>

<template>
    <Head>
        <title>Paiement</title>
        <meta
            name="description"
            content="Effectuez le paiement de votre inscription au trail annuel organisé par U-Trail Limal. Un processus de paiement sécurisé pour les traileurs francophones."
        />
        <meta
            name="keywords"
            content="paiement inscription, paiement trail, paiement sécurisé, inscription trail, trail annuel, trail Brabant wallon, trail Limal"
        />
        <meta property="og:title" content="Paiement" />
        <meta
            property="og:description"
            content="Effectuez le paiement de votre inscription au trail annuel organisé par U-Trail Limal. Un processus de paiement sécurisé pour les traileurs francophones."
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
            class="relative mx-auto flex w-full max-w-[1182px] flex-col items-center justify-center px-4 py-8 md:py-14"
        >
            <h2
                class="mb-6 w-full text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Paiement
            </h2>

            <p
                v-if="flashError"
                class="w-full rounded-[6px] bg-red-50 px-4 py-3 text-center text-sm text-[#c42827]"
            >
                {{ flashError }}
            </p>
        </section>

        <section class="mx-auto w-full max-w-[640px] px-4 pb-14">
            <!-- Résumé -->
            <CheckoutSummary :membre="membre" :versement="versement" />

            <!-- Payment-mode toggle (caché en mode versement unique) -->
            <PaymentModeToggle
                v-if="showToggle"
                ref="toggleRef"
                :membre="membre"
                :echeanciers="echeanciers"
                :versements="versements"
                :stripe-elements="elements"
            />

            <!-- Stripe Payment Element -->
            <form @submit.prevent="handleSubmit">
                <div id="payment-element" class="mb-6"></div>

                <p v-if="errorMessage" class="mb-4 text-sm text-[#c42827]">
                    {{ errorMessage }}
                </p>

                <button
                    type="submit"
                    :disabled="isLoading || toggleRef?.isSwitching"
                    class="h-[54px] w-full rounded-[6px] bg-[#B3A96F] text-[16px] font-semibold text-white transition hover:bg-[#9e9460] disabled:opacity-60"
                >
                    <span v-if="isLoading">Traitement en cours…</span>
                    <span v-else>
                        Payer {{ Number(montantAPayer).toFixed(2) }} €
                        <span
                            v-if="toggleRef?.paymentMode === 'echelonne'"
                            class="text-[13px] font-normal"
                        >
                            (1<sup>er</sup> versement)
                        </span>
                    </span>
                </button>
            </form>
        </section>
    </main>

    <Footer />
</template>
