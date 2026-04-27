<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nom: '',
    prenom: '',
    role: '',
    photo: null,
    description: '',
});

function handleFileChange(event) {
    const file = event.target.files[0];
    form.photo = file;
}

function submitForm() {
    form.post('/admin/equipes', {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error("Erreur lors de la création de l'équipe.", errors);
        },
    });
}
</script>

<template>
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[var(--primary)] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Créer un membre de l'équipe
        </h1>
        <form @submit.prevent="submitForm" class="space-y-6">
            <div>
                <label for="nom" class="mb-2 block font-medium">Nom</label>
                <input
                    id="nom"
                    v-model="form.nom"
                    type="text"
                    required
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
                <label for="prenom" class="mb-2 block font-medium"
                    >Prénom</label
                >
                <input
                    id="prenom"
                    v-model="form.prenom"
                    type="text"
                    required
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
                <label for="role" class="mb-2 block font-medium">Rôle</label>
                <input
                    id="role"
                    v-model="form.role"
                    type="text"
                    required
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
                <label for="photo" class="mb-2 block font-medium">Photo</label>
                <input
                    id="photo"
                    type="file"
                    accept="image/*"
                    @change="handleFileChange"
                    class="block w-full rounded-md border border-[var(--primary)] px-3 py-2 text-sm"
                />
                <p v-if="form.errors.photo" class="mt-1 text-sm text-red-600">
                    {{ form.errors.photo }}
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
            <div class="flex justify-center">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="cursor-pointer rounded-md bg-[var(--primary)] px-4 py-2 text-white disabled:bg-gray-400"
                >
                    {{ form.processing ? 'Création...' : 'Créer' }}
                </button>
            </div>
        </form>
    </div>
</template>
