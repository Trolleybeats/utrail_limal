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
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[var(--primary)] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Modifier la formation
        </h1>
        <form @submit.prevent="updateFormation" class="space-y-6">
            <div>
                <label for="titre" class="mb-2 block font-medium">Titre</label>
                <input
                    v-model="form.titre"
                    type="text"
                    id="titre"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.titre
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.titre" class="mt-1 text-sm text-red-600">
                    {{ form.errors.titre }}
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
            <div>
                <label for="date" class="mb-2 block font-medium">Date</label>
                <input
                    v-model="form.date"
                    type="text"
                    id="date"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.date
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.date" class="mt-1 text-sm text-red-600">
                    {{ form.errors.date }}
                </p>
            </div>
            <div>
                <label for="niveau" class="mb-2 block font-medium"
                    >Niveau</label
                >
                <select
                    v-model="form.niveau"
                    id="niveau"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.niveau
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                >
                    <option value="">-- Sélectionner le niveau --</option>
                    <option value="Débutant">Débutant</option>
                    <option value="Intermédiaire">Intermédiaire</option>
                    <option value="Avancé">Avancé</option>
                </select>
                <p v-if="form.errors.niveau" class="mt-1 text-sm text-red-600">
                    {{ form.errors.niveau }}
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
        <h2 class="mb-4 text-xl font-semibold text-[var(--primary)]">Photo</h2>
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
                :disabled="
                    form.processing || uploading || !props.formation.photo
                "
                class="cursor-pointer rounded-md bg-red-500 px-4 py-2 text-white hover:bg-red-600 disabled:bg-gray-400"
            >
                Supprimer la photo
            </button>
        </div>
    </div>
</template>
