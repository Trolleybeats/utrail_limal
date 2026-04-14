<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    equipe: Object,
});

const form = useForm({
    prenom: props.equipe.prenom,
    nom: props.equipe.nom,
    role: props.equipe.role,
    description: props.equipe.description,
});

const updateEquipe = () => {
    form.put(`/admin/equipes/${props.equipe.id}`, { preserveScroll: true });
};

// -- Gestion photo --
const photoFile = ref(null);
const uploading = ref(false);

function changerPhoto() {
    if (!photoFile.value?.files?.[0]) return;

    const data = new FormData();
    data.append('_method', 'PUT');
    data.append('prenom', props.equipe.prenom);
    data.append('nom', props.equipe.nom);
    data.append('role', props.equipe.role);
    data.append('description', props.equipe.description);
    data.append('photo', photoFile.value.files[0]);

    uploading.value = true;
    router.post(`/admin/equipes/${props.equipe.id}`, data, {
        preserveScroll: true,
        onFinish: () => {
            uploading.value = false;
            if (photoFile.value) photoFile.value.value = '';
        },
    });
}

function supprimerPhoto() {
    if (confirm('Supprimer la photo ?')) {
        router.delete(`/admin/equipes/${props.equipe.id}/photo`, {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <section class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h2 class="mb-4 text-2xl font-bold">Modifier le membre de l'équipe</h2>
        <form @submit.prevent="updateEquipe" class="space-y-6">
            <div>
                <label
                    for="prenom"
                    class="block text-sm font-medium text-gray-700"
                    >Prénom</label
                >
                <input
                    v-model="form.prenom"
                    type="text"
                    id="prenom"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                />
            </div>
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700"
                    >Nom</label
                >
                <input
                    v-model="form.nom"
                    type="text"
                    id="nom"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                />
            </div>
            <div>
                <label
                    for="role"
                    class="block text-sm font-medium text-gray-700"
                    >Rôle</label
                >
                <input
                    v-model="form.role"
                    type="text"
                    id="role"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                />
            </div>
            <div>
                <label
                    for="description"
                    class="block text-sm font-medium text-gray-700"
                    >Description</label
                >
                <textarea
                    v-model="form.description"
                    id="description"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                ></textarea>
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
                :disabled="form.processing || uploading || !props.equipe.photo"
            >
                Supprimer la photo
            </button>
        </div>
    </section>
</template>
