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
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[var(--primary)] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Modifier le membre de l'équipe
        </h1>
        <form @submit.prevent="updateEquipe" class="space-y-6">
            <div>
                <label for="prenom" class="mb-2 block font-medium"
                    >Prénom</label
                >
                <input
                    v-model="form.prenom"
                    type="text"
                    id="prenom"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.prenom
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.prenom" class="mt-1 text-sm text-red-600">
                    {{ form.errors.prenom }}
                </p>
            </div>
            <div>
                <label for="nom" class="mb-2 block font-medium">Nom</label>
                <input
                    v-model="form.nom"
                    type="text"
                    id="nom"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.nom
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.nom" class="mt-1 text-sm text-red-600">
                    {{ form.errors.nom }}
                </p>
            </div>
            <div>
                <label for="role" class="mb-2 block font-medium">Rôle</label>
                <input
                    v-model="form.role"
                    type="text"
                    id="role"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.role
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.role" class="mt-1 text-sm text-red-600">
                    {{ form.errors.role }}
                </p>
            </div>
            <div>
                <label for="description" class="mb-2 block font-medium"
                    >Description</label
                >
                <textarea
                    v-model="form.description"
                    id="description"
                    rows="4"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.description
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                ></textarea>
                <p
                    v-if="form.errors.description"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.description }}
                </p>
            </div>
            <div class="flex justify-center">
                <button
                    type="submit"
                    :disabled="form.processing || uploading"
                    class="cursor-pointer rounded-md bg-[var(--primary)] px-4 py-2 text-white disabled:bg-gray-400"
                >
                    {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                </button>
            </div>
        </form>
        <hr class="my-8" />
        <h2 class="mb-4 text-xl font-semibold text-[var(--primary)]">
            Photo de profil
        </h2>
        <div class="flex items-center gap-4">
            <input
                ref="photoFile"
                type="file"
                accept="image/*"
                @change="changerPhoto"
                class="block w-full rounded-md border border-[var(--primary)] px-3 py-2 text-sm"
            />
            <button
                @click="supprimerPhoto"
                :disabled="form.processing || uploading || !props.equipe.photo"
                class="cursor-pointer rounded-md bg-red-500 px-4 py-2 text-white hover:bg-red-600 disabled:bg-gray-400"
            >
                Supprimer la photo
            </button>
        </div>
    </div>
</template>
