<script setup>
import Button from '@/components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
const form = useForm({
    label: '',
    prix: '',
    categorie: '',
    est_actif: false,
});

const submitForm = () => {
    form.post('/admin/tarifs', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            // Gérer les erreurs si nécessaire
            console.error('Erreur lors de la création du tarif.', errors);
        },
    });
};
</script>

<template>
    <section class="mx-4 my-4 space-y-4">
        <h1 class="px-4 py-4 text-2xl font-bold">Créer un tarif</h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label
                    for="label"
                    class="block text-sm font-medium text-gray-700"
                    >Label (Nom du produit : ex. T-shirt 2026, Dolomiti
                    50k...)</label
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
                <p v-if="form.errors.label" class="mt-1 text-sm text-red-600">
                    {{ form.errors.label }}
                </p>
            </div>
            <div>
                <label
                    for="prix"
                    class="block text-sm font-medium text-gray-700"
                    >Prix (en euros)</label
                >
                <input
                    id="prix"
                    v-model="form.prix"
                    type="number"
                    step="0.01"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.prix ? 'border-red-500' : 'border-gray-300',
                    ]"
                />
                <p v-if="form.errors.prix" class="mt-1 text-sm text-red-600">
                    {{ form.errors.prix }}
                </p>
            </div>
            <div>
                <label
                    for="categorie"
                    class="block text-sm font-medium text-gray-700"
                    >Catégorie</label
                >
                <select
                    id="categorie"
                    v-model="form.categorie"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.categorie
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                >
                    <option value="" disabled>
                        -- Sélectionnez une catégorie --
                    </option>
                    <option value="Course">Course</option>
                    <option value="T-shirt">T-shirt</option>
                    <option value="Logement">Logement</option>
                </select>
                <p
                    v-if="form.errors.categorie"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.categorie }}
                </p>
            </div>
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
                    class="mt-1"
                />
            </div>
            <Button type="submit" class="text-[#F6F6F6]">Créer le tarif</Button>
        </form>
    </section>
</template>
