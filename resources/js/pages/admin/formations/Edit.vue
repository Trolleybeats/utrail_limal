<script setup>
import { formation } from '@/routes';
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    formation: Object,
});

const form = useForm({
    titre: props.formation.titre,
    description: props.formation.description,
    date: props.formation.date,
    niveau: props.formation.niveau,
});

const updateFormation = () => {
    form.put(`/admin/formations/${props.formation.id}`, {
        preserveScroll: true,
    });
};

// -- Gestion photo --
const photoFile = ref(null);
const uploading = ref(false);

function changerPhoto() {
    if (!photoFile.value?.files?.[0]) return;

    const data = new FormData();
    data.append('_method', 'PUT');
    data.append('titre', props.formation.titre);
    data.append('description', props.formation.description);
    data.append('date', props.formation.date);
    data.append('niveau', props.formation.niveau);
    data.append('photo', photoFile.value.files[0]);

    uploading.value = true;
    router.post(`/admin/formations/${props.formation.id}`, data, {
        preserveScroll: true,
        onFinish: () => {
            uploading.value = false;
            if (photoFile.value) photoFile.value.value = '';
        },
    });
}

function supprimerPhoto() {
    if (confirm('Supprimer la photo ?')) {
        router.delete(`/admin/formations/${props.formation.id}/photo`, {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <section class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h2 class="mb-4 text-2xl font-bold">Modifier la formation</h2>
        <form @submit.prevent="updateFormation" class="space-y-6">
            <div>
                <label
                    for="titre"
                    class="block text-sm font-medium text-gray-700"
                    >Titre</label
                >
                <input
                    v-model="form.titre"
                    type="text"
                    id="titre"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                />
            </div>
            <div>
                <label
                    for="description"
                    class="block text-sm font-medium text-gray-700"
                    >Description</label
                >
                <input
                    v-model="form.description"
                    type="text"
                    id="description"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                />
            </div>
            <div>
                <label
                    for="date"
                    class="block text-sm font-medium text-gray-700"
                    >Date</label
                >
                <input
                    v-model="form.date"
                    type="text"
                    id="date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                />
            </div>
            <div>
                <label
                    for="niveau"
                    class="block text-sm font-medium text-gray-700"
                    >Niveau</label
                >
                <select
                    v-model="form.niveau"
                    id="niveau"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                >
                    <option value="">-- Sélectionner le niveau --</option>
                    <option value="Débutant">Débutant</option>
                    <option value="Intermédiaire">Intermédiaire</option>
                    <option value="Avancé">Avancé</option>
                </select>
            </div>
            <button
                type="submit"
                class="hover:bg-primary-dark inline-flex items-center rounded-md border border-transparent bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none disabled:opacity-50"
                :disabled="form.processing || uploading"
            >
                Enregistrer
            </button>
        </form>
        <hr class="my-8" />
        <h3 class="mb-4 text-xl font-semibold text-gray-800">
            Photo de profil
        </h3>
        <div class="flex items-center gap-4">
            <input
                ref="photoFile"
                type="file"
                accept="image/*"
                @change="changerPhoto"
                class="hover:file:bg-primary-dark block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
            />
            <button
                @click="supprimerPhoto"
                class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none disabled:opacity-50"
                :disabled="
                    form.processing || uploading || !props.formation.photo
                "
            >
                Supprimer la photo
            </button>
        </div>
    </section>
</template>
