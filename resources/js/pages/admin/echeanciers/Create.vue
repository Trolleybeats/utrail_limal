<script setup>
import Button from '@/components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    label: '',
    nombre_versements: '',
    dates: [],
    est_actif: true,
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
    form.post('/admin/echeanciers', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            form.dates = originalDates;
            console.error(
                "Erreur lors de la création de l'échéancier.",
                errors,
            );
        },
    });
}
</script>

<template>
    <section class="mx-4 my-4 space-y-4">
        <h1 class="px-4 py-4 text-2xl font-bold">Créer un échéancier</h1>
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
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.label
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.label" class="mt-1 text-sm text-red-600">
                {{ form.errors.label }}
            </p>

            <div>
                <label
                    for="nombre_versements"
                    class="block text-sm font-medium text-gray-700"
                    >Nombre de versements</label
                >
                <select
                    id="nombre_versements"
                    v-model="form.nombre_versements"
                    type="number"
                    min="1"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.nombre_versements
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                >
                    <option v-for="n in 8" :key="n" :value="n">{{ n }}</option>
                </select>
            </div>

            <div>
                <label
                    for="dates"
                    class="block text-sm font-medium text-gray-700"
                    >Dates des versements</label
                >
                <input
                    id="dates"
                    v-model="form.dates"
                    type="text"
                    placeholder="Entrez les dates séparées par des virgules (ex: 01/07/2024, 01/08/2024)"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.dates
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.dates" class="mt-1 text-sm text-red-600">
                {{ form.errors.dates }}
            </p>

            <div>
                <label
                    for="est_actif"
                    class="block text-sm font-medium text-gray-700"
                    >Est actif</label
                >
                <input
                    id="est_actif"
                    v-model="form.est_actif"
                    type="checkbox"
                    :class="[
                        'focus:ring-opacity-50 mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.est_actif
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>

            <Button type="submit" class="text-[#F6F6F6] sm:w-auto"
                >Créer</Button
            >
        </form>
    </section>
</template>
