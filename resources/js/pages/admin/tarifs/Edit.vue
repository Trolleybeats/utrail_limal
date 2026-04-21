<script setup>
import Button from '@/components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({
    tarif: Object,
});

const form = useForm({
    label: props.tarif.label,
    categorie: props.tarif.categorie,
    prix: props.tarif.prix,
    est_actif: props.tarif.est_actif,
});

function updateTarif() {
    form.put(`/admin/tarifs/${props.tarif.id}`, { preserveScroll: true });
}
</script>

<template>
    <section class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h2 class="mb-4 text-2xl font-bold">Modifier le tarif</h2>
        <form @submit.prevent="updateTarif" class="space-y-4">
            <div>
                <label for="label" class="block text-sm font-medium"
                    >Label</label
                >
                <input
                    v-model="form.label"
                    type="text"
                    id="label"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                />
            </div>
            <div>
                <label for="categorie" class="block text-sm font-medium"
                    >Catégorie</label
                >
                <input
                    v-model="form.categorie"
                    type="text"
                    id="categorie"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                />
            </div>
            <div>
                <label for="prix" class="block text-sm font-medium"
                    >Prix (€)</label
                >
                <input
                    v-model.number="form.prix"
                    type="number"
                    step="0.01"
                    id="prix"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                />
            </div>
            <div class="flex items-center gap-2">
                <input
                    v-model="form.est_actif"
                    type="checkbox"
                    id="est_actif"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                />
                <label for="est_actif" class="text-sm font-medium"
                    >Est actif</label
                >
            </div>
            <Button type="submit" style="background-color: var(--button)"
                >Enregistrer</Button
            >
        </form>
    </section>
</template>
