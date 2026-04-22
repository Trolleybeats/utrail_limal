<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
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

// ── Payment mode toggle (not shown in versement mode) ──────────────────────
const paymentMode = ref(props.membre.mode_paiement ?? 'immediat');
const selectedEcheancier = ref(props.membre.echeancier_id ?? null);
const currentVersements = ref([...props.versements]);
const isSwitching = ref(false);
const switchError = ref(null);

const showToggle = computed(
    () => !props.versement && props.echeanciers.length > 0,
);

const montantAPayer = computed(() => {
    if (
        paymentMode.value === 'echelonne' &&
        currentVersements.value.length > 0
    ) {
        return currentVersements.value[0].montant;
    }
    return props.membre.montant_total;
});

// ── CSRF (reads the XSRF-TOKEN cookie set by Laravel) ─────────────────────
function getCsrfToken() {
    const match = document.cookie
        .split('; ')
        .find((row) => row.startsWith('XSRF-TOKEN='));
    return match ? decodeURIComponent(match.split('=')[1]) : '';
}

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

// ── Mode switching ─────────────────────────────────────────────────────────
async function onModeChange(mode) {
    if (mode === paymentMode.value || isSwitching.value) return;

    if (mode === 'immediat') {
        await doSwitchToFull();
    } else {
        // Auto-pick first echeancier when entering echelonne mode
        if (!selectedEcheancier.value && props.echeanciers.length > 0) {
            selectedEcheancier.value = props.echeanciers[0].id;
        }
        if (selectedEcheancier.value) {
            await doSwitchToInstallments(selectedEcheancier.value);
        }
    }
}

async function onEcheancierChange() {
    if (
        paymentMode.value !== 'echelonne' ||
        !selectedEcheancier.value ||
        isSwitching.value
    )
        return;
    await doSwitchToInstallments(selectedEcheancier.value);
}

async function doSwitchToInstallments(echeancier_id) {
    isSwitching.value = true;
    switchError.value = null;

    try {
        const res = await fetch(`/checkout/${props.membre.id}/echelonne`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-XSRF-TOKEN': getCsrfToken(),
            },
            body: JSON.stringify({ echeancier_id }),
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(
                data.message ?? 'Erreur lors du passage en mode échelonné.',
            );
        }

        currentVersements.value = data.versements;
        paymentMode.value = 'echelonne';
        await elements.fetchUpdates();
    } catch (e) {
        switchError.value = e.message;
    } finally {
        isSwitching.value = false;
    }
}

async function doSwitchToFull() {
    isSwitching.value = true;
    switchError.value = null;

    try {
        const res = await fetch(`/checkout/${props.membre.id}/immediat`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-XSRF-TOKEN': getCsrfToken(),
            },
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(
                data.message ??
                    'Erreur lors du retour au paiement en une fois.',
            );
        }

        currentVersements.value = [];
        paymentMode.value = 'immediat';
        await elements.fetchUpdates();
    } catch (e) {
        switchError.value = e.message;
    } finally {
        isSwitching.value = false;
    }
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

                <!-- Versement info (single-versement mode from admin link) -->
                <p v-if="versement" class="mt-2 text-[16px] text-[#586166]">
                    Versement n°{{ versement.numero_versement }} —
                    <span class="font-semibold text-[#B3A96F]">
                        {{ versement.montant.toFixed(2) }} €
                    </span>
                    (échéance {{ versement.date_echeance }})
                </p>
            </div>

            <!-- Payment-mode toggle (hidden in versement mode) -->
            <div
                v-if="showToggle"
                class="mb-8 rounded-[6px] bg-white px-6 py-5"
            >
                <p class="mb-3 text-[16px] font-medium text-[#586166]">
                    Mode de paiement
                </p>

                <!-- Toggle buttons -->
                <div
                    class="mb-4 flex overflow-hidden rounded-[6px] border border-[#B3A96F]"
                >
                    <button
                        type="button"
                        :disabled="isSwitching"
                        :class="[
                            'flex-1 py-2 text-[14px] font-semibold transition',
                            paymentMode === 'immediat'
                                ? 'bg-[#B3A96F] text-white'
                                : 'bg-white text-[#B3A96F] hover:bg-[#f5f2e8]',
                        ]"
                        @click="onModeChange('immediat')"
                    >
                        Payer en totalité
                    </button>
                    <button
                        type="button"
                        :disabled="isSwitching || echeanciers.length === 0"
                        :class="[
                            'flex-1 border-l border-[#B3A96F] py-2 text-[14px] font-semibold transition',
                            paymentMode === 'echelonne'
                                ? 'bg-[#B3A96F] text-white'
                                : 'bg-white text-[#B3A96F] hover:bg-[#f5f2e8]',
                        ]"
                        @click="onModeChange('echelonne')"
                    >
                        Payer en plusieurs fois
                    </button>
                </div>

                <!-- Echeancier selector (visible in echelonne mode) -->
                <div
                    v-if="paymentMode === 'echelonne' && echeanciers.length > 1"
                    class="mb-4"
                >
                    <label
                        for="echeancier-select"
                        class="mb-1 block text-[14px] text-[#586166]"
                    >
                        Choisir l'échéancier
                    </label>
                    <select
                        id="echeancier-select"
                        v-model="selectedEcheancier"
                        :disabled="isSwitching"
                        class="w-full rounded-[6px] border border-gray-300 px-3 py-2 text-[14px] text-[#586166] focus:border-[#B3A96F] focus:outline-none disabled:opacity-60"
                        @change="onEcheancierChange"
                    >
                        <option
                            v-for="e in echeanciers"
                            :key="e.id"
                            :value="e.id"
                        >
                            {{ e.label }}
                        </option>
                    </select>
                </div>

                <!-- Spinner during switch -->
                <p
                    v-if="isSwitching"
                    class="text-center text-[13px] text-[#586166]"
                >
                    Mise à jour en cours…
                </p>

                <!-- Switch error -->
                <p v-if="switchError" class="text-[13px] text-[#c42827]">
                    {{ switchError }}
                </p>

                <!-- Versements recap table -->
                <div
                    v-if="
                        paymentMode === 'echelonne' &&
                        currentVersements.length > 0
                    "
                    class="mt-4"
                >
                    <p class="mb-2 text-[14px] font-medium text-[#586166]">
                        Récapitulatif des versements
                    </p>
                    <table class="w-full text-[13px] text-[#586166]">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="py-1 text-left font-semibold">N°</th>
                                <th class="py-1 text-left font-semibold">
                                    Échéance
                                </th>
                                <th class="py-1 text-right font-semibold">
                                    Montant
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="v in currentVersements"
                                :key="v.id"
                                :class="[
                                    'border-b border-gray-100',
                                    v.numero_versement === 1
                                        ? 'font-semibold text-[#B3A96F]'
                                        : '',
                                ]"
                            >
                                <td class="py-1">{{ v.numero_versement }}</td>
                                <td class="py-1">{{ v.date_echeance }}</td>
                                <td class="py-1 text-right">
                                    {{ Number(v.montant).toFixed(2) }} €
                                    <span
                                        v-if="v.numero_versement === 1"
                                        class="ml-1 text-[11px] text-[#B3A96F]"
                                    >
                                        (à payer maintenant)
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Stripe Payment Element -->
            <form @submit.prevent="handleSubmit">
                <div id="payment-element" class="mb-6"></div>

                <p v-if="errorMessage" class="mb-4 text-sm text-[#c42827]">
                    {{ errorMessage }}
                </p>

                <button
                    type="submit"
                    :disabled="isLoading || isSwitching"
                    class="h-[54px] w-full rounded-[6px] bg-[#B3A96F] text-[16px] font-semibold text-white transition hover:bg-[#9e9460] disabled:opacity-60"
                >
                    <span v-if="isLoading">Traitement en cours…</span>
                    <span v-else>
                        Payer {{ Number(montantAPayer).toFixed(2) }} €
                        <span
                            v-if="paymentMode === 'echelonne'"
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
