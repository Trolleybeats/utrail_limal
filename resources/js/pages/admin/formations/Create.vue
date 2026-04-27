<script setup>
import Button from '@/components/ui/button/Button.vue';
import photo from '@/routes/admin/equipes/photo';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    titre: '',
    description: '',
    date: '',
    niveau: '',
    photo: null,
});

function handleFileChange(event) {
    const file = event.target.files[0];
    form.photo = file;
}

function submitForm() {
    form.post('/admin/formations', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(
                'Erreur lors de la création de la formation.',
                errors,
            );
        },
    });
}
</script>

<template>
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[var(--primary)] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Créer une formation
        </h1>
        <form @submit.prevent="submitForm" class="space-y-6">
            <div>
                <label for="titre" class="mb-2 block font-medium">Titre</label>
                <input
                    id="titre"
                    v-model="form.titre"
                    type="text"
                    required
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
                    id="description"
                    v-model="form.description"
                    required
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
                    id="date"
                    v-model="form.date"
                    type="date"
                    required
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
                    id="niveau"
                    v-model="form.niveau"
                    required
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.niveau
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                >
                    <option value="" disabled>Choisir un niveau</option>
                    <option value="Débutant">Débutant</option>
                    <option value="Intermédiaire">Intermédiaire</option>
                    <option value="Avancé">Avancé</option>
                </select>
                <p v-if="form.errors.niveau" class="mt-1 text-sm text-red-600">
                    {{ form.errors.niveau }}
                </p>
            </div>
            <div>
                <label for="photo" class="mb-2 block font-medium">Photo</label>
                <input
                    id="photo"
                    type="file"
                    @change="handleFileChange"
                    accept="image/*"
                    class="block w-full rounded-md border border-[var(--primary)] px-3 py-2 text-sm"
                />
                <p v-if="form.errors.photo" class="mt-1 text-sm text-red-600">
                    {{ form.errors.photo }}
                </p>
            </div>
            <div class="flex justify-center">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="cursor-pointer rounded-md bg-[var(--primary)] px-4 py-2 text-white disabled:bg-gray-400"
                >
                    {{ form.processing ? 'Création...' : 'Créer la formation' }}
                </button>
            </div>
        </form>
    </div>
</template>
