<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    titre: '',
    description: '',
    photos: [],
    photo_principale_index: 0,
});

const previews = ref([]); // [{ file, url, principale }]

function handleFileChange(event) {
    const files = Array.from(event.target.files);
    const newPreviews = files.map((file) => ({
        file,
        url: URL.createObjectURL(file),
        principale: false,
    }));

    // Si aucune principale définie, la première ajoutée le devient
    if (previews.value.length === 0 && newPreviews.length > 0) {
        newPreviews[0].principale = true;
    }

    previews.value.push(...newPreviews);
    event.target.value = '';
    syncPhotosToForm();
}

function supprimerPreview(index) {
    const removed = previews.value.splice(index, 1)[0];
    URL.revokeObjectURL(removed.url);

    // Si on supprime la principale, promouvoir la première restante
    if (removed.principale && previews.value.length > 0) {
        previews.value[0].principale = true;
    }
    syncPhotosToForm();
}

function definirPrincipale(index) {
    previews.value.forEach((p, i) => {
        p.principale = i === index;
    });
    syncPhotosToForm();
}

function syncPhotosToForm() {
    form.photos = previews.value.map((p) => p.file);
    const idx = previews.value.findIndex((p) => p.principale);
    form.photo_principale_index = idx >= 0 ? idx : 0;
}

function submitForm() {
    form.post('/admin/projets', {
        onSuccess: () => {
            previews.value.forEach((p) => URL.revokeObjectURL(p.url));
            previews.value = [];
            form.reset();
        },
    });
}
</script>

<template>
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Créer un projet
        </h1>
        <form @submit.prevent="submitForm" class="space-y-6">
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
                            : 'border-gray-300',
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
                            : 'border-gray-300',
                    ]"
                ></textarea>
                <p
                    v-if="form.errors.description"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.description }}
                </p>
            </div>

            <!-- Gestion multi-photos -->
            <div class="rounded-lg border border-gray-200 p-4">
                <h3 class="mb-4 text-lg font-semibold">Photos</h3>

                <!-- Upload -->
                <div class="mb-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700"
                        >Ajouter des photos</label
                    >
                    <input
                        type="file"
                        multiple
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                        @change="handleFileChange"
                        class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                    />
                    <p class="mt-1 text-xs text-gray-500">
                        Formats acceptés : JPEG, PNG, JPG, GIF, WEBP (max 2MB
                        par photo)
                    </p>
                    <p
                        v-if="form.errors['photos'] || form.errors['photos.0']"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors['photos'] || form.errors['photos.0'] }}
                    </p>
                </div>

                <!-- Grille des aperçus -->
                <div
                    v-if="previews.length > 0"
                    class="grid grid-cols-2 gap-4 md:grid-cols-4"
                >
                    <div
                        v-for="(preview, index) in previews"
                        :key="preview.url"
                        class="group relative"
                    >
                        <img
                            :src="preview.url"
                            alt="Aperçu"
                            class="h-32 w-full rounded-lg object-cover shadow"
                            :class="{
                                'ring-2 ring-[#B3A96F]': preview.principale,
                            }"
                        />
                        <!-- Badge principale -->
                        <span
                            v-if="preview.principale"
                            class="absolute top-2 left-2 rounded bg-[#B3A96F] px-1.5 py-0.5 text-xs text-white"
                            >principale</span
                        >
                        <!-- Bouton définir principale -->
                        <button
                            v-else
                            type="button"
                            @click="definirPrincipale(index)"
                            class="absolute top-2 left-2 rounded bg-white/80 px-1.5 py-0.5 text-xs text-gray-700 opacity-0 transition-opacity group-hover:opacity-100 hover:bg-white"
                            title="Définir comme principale"
                        >
                            ⭐ Principale
                        </button>
                        <!-- Bouton supprimer -->
                        <button
                            type="button"
                            @click="supprimerPreview(index)"
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
                    Aucune photo sélectionnée.
                </div>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-md bg-[#B3A96F] px-4 py-2 text-white hover:bg-[#a18e5c] disabled:bg-gray-400"
            >
                {{ form.processing ? 'Création...' : 'Créer le projet' }}
            </button>
        </form>
    </div>
</template>
