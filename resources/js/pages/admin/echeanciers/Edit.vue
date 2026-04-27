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
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[var(--primary)] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Modifier l'échéancier
        </h1>
        <form @submit.prevent="submitForm" class="space-y-6">
            <div>
                <label for="label" class="mb-2 block font-medium">Label</label>
                <input
                    id="label"
                    v-model="form.label"
                    type="text"
                    required
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.label
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.label" class="mt-1 text-sm text-red-600">
                    {{ form.errors.label }}
                </p>
            </div>
            <div>
                <label for="nombre_versements" class="mb-2 block font-medium"
                    >Nombre de versements</label
                >
                <select
                    id="nombre_versements"
                    v-model="form.nombre_versements"
                    required
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.nombre_versements
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                >
                    <option v-for="n in 8" :key="n" :value="n">{{ n }}</option>
                </select>
                <p
                    v-if="form.errors.nombre_versements"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.nombre_versements }}
                </p>
            </div>
            <div>
                <label for="dates" class="mb-2 block font-medium"
                    >Dates (séparées par des virgules, format JJ/MM/AAAA)</label
                >
                <input
                    id="dates"
                    v-model="form.dates"
                    type="text"
                    required
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.dates
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.dates" class="mt-1 text-sm text-red-600">
                    {{ form.errors.dates }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <input
                    id="est_actif"
                    v-model="form.est_actif"
                    type="checkbox"
                    class="h-4 w-4 rounded border-[var(--primary)] text-[var(--primary)]"
                />
                <label for="est_actif" class="font-medium">Actif</label>
            </div>
            <div class="flex justify-center">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="cursor-pointer rounded-md bg-[var(--primary)] px-4 py-2 text-white disabled:bg-gray-400"
                >
                    {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                </button>
            </div>
        </form>
    </div>
</template>
