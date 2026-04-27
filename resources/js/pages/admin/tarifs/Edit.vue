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
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[var(--primary)] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Modifier le tarif
        </h1>
        <form @submit.prevent="updateTarif" class="space-y-6">
            <div>
                <label for="label" class="mb-2 block font-medium">Label</label>
                <input
                    v-model="form.label"
                    type="text"
                    id="label"
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
                <label for="categorie" class="mb-2 block font-medium"
                    >Catégorie</label
                >
                <select
                    v-model="form.categorie"
                    id="categorie"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.categorie
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
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
                <label for="prix" class="mb-2 block font-medium"
                    >Prix (€)</label
                >
                <input
                    v-model.number="form.prix"
                    type="number"
                    step="0.01"
                    id="prix"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.prix
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.prix" class="mt-1 text-sm text-red-600">
                    {{ form.errors.prix }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <input
                    v-model="form.est_actif"
                    type="checkbox"
                    id="est_actif"
                    class="h-4 w-4 rounded border-[var(--primary)] text-[var(--primary)]"
                />
                <label for="est_actif" class="font-medium">Est actif</label>
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
