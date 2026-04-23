<script setup>
import { ref } from 'vue';

const props = defineProps({
    membre: {
        type: Object,
        required: true,
    },
    echeanciers: {
        type: Array,
        default: () => [],
    },
    versements: {
        type: Array,
        default: () => [],
    },
    stripeElements: {
        type: Object,
        default: null,
    },
});

const paymentMode = ref(props.membre.mode_paiement ?? 'immediat');
const selectedEcheancier = ref(props.membre.echeancier_id ?? null);
const currentVersements = ref([...props.versements]);
const isSwitching = ref(false);
const switchError = ref(null);

// ── CSRF (reads the XSRF-TOKEN cookie set by Laravel) ─────────────────────
function getCsrfToken() {
    const match = document.cookie
        .split('; ')
        .find((row) => row.startsWith('XSRF-TOKEN='));
    return match ? decodeURIComponent(match.split('=')[1]) : '';
}

// ── Mode switching ─────────────────────────────────────────────────────────
async function onModeChange(mode) {
    if (mode === paymentMode.value || isSwitching.value) return;

    if (mode === 'immediat') {
        await doSwitchToFull();
    } else {
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
        await props.stripeElements?.fetchUpdates();
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
        await props.stripeElements?.fetchUpdates();
    } catch (e) {
        switchError.value = e.message;
    } finally {
        isSwitching.value = false;
    }
}

defineExpose({ paymentMode, currentVersements, isSwitching });
</script>

<template>
    <div class="mb-8 rounded-[6px] bg-white px-6 py-5">
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
                <option v-for="e in echeanciers" :key="e.id" :value="e.id">
                    {{ e.label }}
                </option>
            </select>
        </div>

        <!-- Spinner during switch -->
        <p v-if="isSwitching" class="text-center text-[13px] text-[#586166]">
            Mise à jour en cours…
        </p>

        <!-- Switch error -->
        <p v-if="switchError" class="text-[13px] text-[#c42827]">
            {{ switchError }}
        </p>

        <!-- Versements recap table -->
        <div
            v-if="paymentMode === 'echelonne' && currentVersements.length > 0"
            class="mt-4"
        >
            <p class="mb-2 text-[14px] font-medium text-[#586166]">
                Récapitulatif des versements
            </p>
            <table class="w-full text-[13px] text-[#586166]">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="py-1 text-left font-semibold">N°</th>
                        <th class="py-1 text-left font-semibold">Échéance</th>
                        <th class="py-1 text-right font-semibold">Montant</th>
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
</template>
