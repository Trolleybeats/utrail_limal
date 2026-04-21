<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { onMounted, ref } from 'vue';
import { loadStripe } from '@stripe/stripe-js';
import { usePage } from '@inertiajs/vue3';
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
});

const isLoading = ref(false);
const errorMessage = ref(null);
let stripe = null;
let elements = null;

onMounted(async () => {
    stripe = await loadStripe(props.stripeKey);

    elements = stripe.elements({
        clientSecret: props.clientSecret,
        appearance: {
            theme: 'stripe',
            variables: {
                colorPrimary: '#B3A96F',
            },
        },
    });

    const paymentElement = elements.create('payment', {
        paymentMethodOrder: ['card', 'bancontact'],
        wallets: { applePay: 'never', googlePay: 'never' },
    });
    paymentElement.mount('#payment-element');
});

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
    <Nav />
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
            <!-- Summary -->
            <div class="mb-8 rounded-[6px] bg-white px-6 py-4">
                <p
                    class="text-[18px] font-medium text-[#586166] md:text-[20px]"
                >
                    Inscription pour :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ membre.participant.prenom }}
                        {{ membre.participant.nom }}
                    </span>
                </p>
                <p class="mt-2 text-[16px] text-[#586166]">
                    Course n°1 :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ membre.participation_un ? 'Oui' : 'Non' }}
                    </span>
                </p>
                <p class="mt-2 text-[16px] text-[#586166]">
                    Distance :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ membre.distance_un ? membre.distance_un : 'Aucune' }}
                    </span>
                </p>
                <p class="mt-2 text-[16px] text-[#586166]">
                    Logement :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ membre.logement_un ? 'Oui' : 'Non' }}
                    </span>
                </p>
                <p class="mt-2 text-[16px] text-[#586166]">
                    Course n°2 :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ membre.participation_deux ? 'Oui' : 'Non' }}
                    </span>
                </p>
                <p class="mt-2 text-[16px] text-[#586166]">
                    Distance :
                    <span class="font-semibold text-[#B3A96F]">
                        {{
                            membre.distance_deux
                                ? membre.distance_deux
                                : 'Aucune'
                        }}
                    </span>
                </p>
                <p class="mt-2 text-[16px] text-[#586166]">
                    Logement :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ membre.logement_deux ? 'Oui' : 'Non' }}
                    </span>
                </p>
                <p class="mt-2 text-[16px] text-[#586166]">
                    T-shirt:
                    <span class="font-semibold text-[#B3A96F] uppercase">
                        {{ membre.tshirt_taille }}
                    </span>
                </p>

                <p class="mt-2 text-[16px] text-[#586166]">
                    Montant total :
                    <span class="font-semibold text-[#B3A96F]">
                        {{ membre.montant_total.toFixed(2) }} €
                    </span>
                </p>
            </div>

            <!-- Stripe Payment Element -->
            <form @submit.prevent="handleSubmit">
                <div id="payment-element" class="mb-6"></div>

                <p v-if="errorMessage" class="mb-4 text-sm text-[#c42827]">
                    {{ errorMessage }}
                </p>

                <button
                    type="submit"
                    :disabled="isLoading"
                    class="h-[54px] w-full rounded-[6px] bg-[#B3A96F] text-[16px] font-semibold text-white transition hover:bg-[#9e9460] disabled:opacity-60"
                >
                    <span v-if="isLoading">Traitement en cours…</span>
                    <span v-else
                        >Payer {{ membre.montant_total.toFixed(2) }} €</span
                    >
                </button>
            </form>
        </section>
    </main>

    <Footer />
</template>
