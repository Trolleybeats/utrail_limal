<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    echeancier: {
        type: Object,
        required: true,
    },
});

function normalizeDatesInput(dates) {
    let arr;
    if (Array.isArray(dates)) {
        arr = dates;
    } else if (typeof dates === 'string') {
        try {
            const parsed = JSON.parse(dates);
            arr = Array.isArray(parsed) ? parsed : [dates];
        } catch {
            return dates;
        }
    } else {
        return '';
    }
    return arr
        .map((d) => {
            const parts = String(d).split('-');
            if (parts.length === 3)
                return `${parts[2]}/${parts[1]}/${parts[0]}`;
            return d;
        })
        .join(', ');
}

const form = useForm({
    label: props.echeancier.label,
    nombre_versements: props.echeancier.nombre_versements,
    dates: normalizeDatesInput(props.echeancier.dates),
    est_actif: props.echeancier.est_actif,
});

function parseDates(raw) {
    return raw
        .split(',')
        .map((d) => {
            const parts = d.trim().split('/');
            if (parts.length !== 3) return d.trim();
            const [day, month, year] = parts;
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        })
        .filter(Boolean);
}

function submitForm() {
    const originalDates = form.dates;
    form.dates = parseDates(
        typeof originalDates === 'string'
            ? originalDates
            : originalDates.join(', '),
    );
    form.put(`/admin/echeanciers/${props.echeancier.id}`, {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            form.dates = originalDates;
            console.error(
                "Erreur lors de la mise à jour de l'échéancier.",
                errors,
            );
        },
    });
}
</script>

<template>
    <section class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h2 class="mb-4 text-2xl font-bold">Modifier l'échéancier</h2>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label
                    for="label"
                    class="block text-sm font-medium text-gray-700"
                    >Label</label
                >
                <input
                    id="label"
                    v-model="form.label"
                    type="text"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                />
            </div>
            <div>
                <label
                    for="nombre_versements"
                    class="block text-sm font-medium text-gray-700"
                    >Nombre de versements</label
                >
                <select
                    id="nombre_versements"
                    v-model="form.nombre_versements"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                    <option v-for="n in 8" :key="n" :value="n">{{ n }}</option>
                </select>
            </div>
            <div>
                <label
                    for="dates"
                    class="block text-sm font-medium text-gray-700"
                    >Dates (séparées par des virgules, format JJ/MM/AAAA)</label
                >
                <input
                    id="dates"
                    v-model="form.dates"
                    type="text"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                />
            </div>
            <div class="flex items-center">
                <label
                    for="est_actif"
                    class="block text-sm font-medium text-gray-700"
                    >Actif</label
                >
                <input
                    id="est_actif"
                    v-model="form.est_actif"
                    type="checkbox"
                    class="ml-2 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
            </div>
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="hover:bg-primary-dark inline-flex items-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none disabled:opacity-50"
                    :disabled="form.processing"
                >
                    Enregistrer
                </button>
            </div>
        </form>
    </section>
</template>
