<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    projet: Object,
});

const form = useForm({
    titre: props.projet.titre,
    description: props.projet.description,
});

function updateProjet() {
    form.put(`/admin/projets/${props.projet.id}`, { preserveScroll: true });
}

// -- Gestion multi-photos --
const photoFiles = ref(null);
const uploading = ref(false);

function ajouterPhotos() {
    if (!photoFiles.value?.files?.length) return;

    const data = new FormData();
    data.append('projet_id', props.projet.id);
    Array.from(photoFiles.value.files).forEach((f) =>
        data.append('photos[]', f),
    );

    uploading.value = true;
    router.post('/admin/photos-projet', data, {
        preserveScroll: true,
        onFinish: () => {
            uploading.value = false;
            if (photoFiles.value) photoFiles.value.value = '';
        },
    });
}

function supprimerPhoto(photoId) {
    if (confirm('Supprimer cette photo ?')) {
        router.delete(`/admin/photos-projet/${photoId}`, {
            preserveScroll: true,
        });
    }
}

function definirPrincipale(photoId) {
    router.patch(
        `/admin/photos-projet/${photoId}/principale`,
        {},
        { preserveScroll: true },
    );
}
</script>

<template>
    <section class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h2 class="mb-4 text-2xl font-bold">Modifier le projet</h2>
        <form @submit.prevent="updateProjet" class="space-y-4">
            <div>
                <label
                    for="titre"
                    class="block text-sm font-medium text-gray-700"
                    >Nom du projet</label
                >
                <input
                    v-model="form.titre"
                    type="text"
                    id="titre"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    :class="{ 'border-red-500': form.errors.titre }"
                />
                <p v-if="form.errors.titre" class="mt-1 text-sm text-red-600">
                    {{ form.errors.titre }}
                </p>
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
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    :class="{ 'border-red-500': form.errors.description }"
                ></textarea>
                <p
                    v-if="form.errors.description"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.description }}
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700"
                    >Photo principale</label
                >
                <div v-if="projet.photo_principale" class="mt-1">
                    <img
                        :src="projet.photo_principale.url"
                        alt="Photo principale"
                        class="h-32 w-auto rounded-lg object-cover shadow"
                    />
                    <p class="mt-1 text-xs text-gray-500">
                        Photo principale actuelle
                    </p>
                </div>
                <p v-else class="mt-1 text-sm text-gray-400 italic">
                    Aucune photo principale — définissez-en une depuis la
                    galerie ci-dessous.
                </p>
            </div>
            <div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 disabled:bg-gray-400"
                >
                    {{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}
                </button>
            </div>
        </form>

        <!-- Gestion des photos -->
        <div class="mt-6 rounded-lg border border-gray-200 p-4">
            <h3 class="mb-4 text-lg font-semibold">Photos</h3>

            <!-- Upload -->
            <div class="mb-4">
                <label class="mb-2 block text-sm font-medium text-gray-700"
                    >Ajouter des photos</label
                >
                <div class="flex items-center gap-3">
                    <input
                        ref="photoFiles"
                        type="file"
                        multiple
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                        class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                        :disabled="uploading"
                    />
                    <button
                        type="button"
                        @click="ajouterPhotos"
                        :disabled="uploading"
                        class="rounded bg-green-500 px-4 py-2 whitespace-nowrap text-white hover:bg-green-600 disabled:bg-gray-400"
                    >
                        {{ uploading ? 'Upload...' : 'Ajouter' }}
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Formats acceptés : JPEG, PNG, JPG, GIF, WEBP (max 2MB par
                    photo)
                </p>
            </div>

            <!-- Grille des photos -->
            <div
                v-if="projet.photos && projet.photos.length > 0"
                class="grid grid-cols-2 gap-4 md:grid-cols-4"
            >
                <div
                    v-for="photo in projet.photos"
                    :key="photo.id"
                    class="group relative"
                >
                    <img
                        :src="photo.url"
                        :alt="`Photo ${photo.id}`"
                        class="h-32 w-full rounded-lg object-cover shadow"
                        :class="{
                            'ring-2 ring-indigo-500':
                                photo.id === projet.photo_id,
                        }"
                    />
                    <!-- Badge principale -->
                    <span
                        v-if="photo.id === projet.photo_id"
                        class="absolute top-2 left-2 rounded bg-indigo-500 px-1.5 py-0.5 text-xs text-white"
                        >principale</span
                    >
                    <!-- Bouton définir principale -->
                    <button
                        v-else
                        type="button"
                        @click="definirPrincipale(photo.id)"
                        class="absolute top-2 left-2 rounded bg-white/80 px-1.5 py-0.5 text-xs text-gray-700 opacity-0 transition-opacity group-hover:opacity-100 hover:bg-white"
                        title="Définir comme principale"
                    >
                        ⭐ Principale
                    </button>
                    <!-- Bouton supprimer -->
                    <button
                        type="button"
                        @click="supprimerPhoto(photo.id)"
                        class="absolute top-2 right-2 rounded-full bg-red-500 p-1.5 text-white opacity-0 transition-opacity group-hover:opacity-100 hover:bg-red-600"
                        title="Supprimer"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </div>
            <div
                v-else
                class="rounded-lg bg-gray-50 p-4 text-center text-sm text-gray-500"
            >
                Aucune photo pour ce projet.
            </div>
        </div>
    </section>
</template>
