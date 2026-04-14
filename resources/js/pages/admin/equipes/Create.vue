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
    <section class="mx-4 my-4 space-y-4">
        <h1 class="px-4 py-4 text-2xl font-bold">
            Créer un membre de l'équipe
        </h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700"
                    >Nom</label
                >
                <input
                    id="nom"
                    v-model="form.nom"
                    type="text"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.nom ? 'border-red-500' : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.nom" class="mt-1 text-sm text-red-600">
                {{ form.errors.nom }}
            </p>
            <div>
                <label
                    for="prenom"
                    class="block text-sm font-medium text-gray-700"
                    >Prénom</label
                >
                <input
                    id="prenom"
                    v-model="form.prenom"
                    type="text"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.prenom
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.prenom" class="mt-1 text-sm text-red-600">
                {{ form.errors.prenom }}
            </p>
            <div>
                <label
                    for="role"
                    class="block text-sm font-medium text-gray-700"
                    >Rôle</label
                >
                <input
                    id="role"
                    v-model="form.role"
                    type="text"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.role ? 'border-red-500' : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.role" class="mt-1 text-sm text-red-600">
                {{ form.errors.role }}
            </p>
            <div>
                <label
                    for="photo"
                    class="block text-sm font-medium text-gray-700"
                    >Photo</label
                >
                <input
                    id="photo"
                    type="file"
                    accept="image/*"
                    @change="handleFileChange"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border file:border-gray-300 file:bg-gray-50 file:px-4 file:py-2 file:text-sm file:font-semibold hover:file:bg-gray-100"
                />
            </div>
            <p v-if="form.errors.photo" class="mt-1 text-sm text-red-600">
                {{ form.errors.photo }}
            </p>
            <div>
                <label
                    for="description"
                    class="block text-sm font-medium text-gray-700"
                    >Description</label
                >
                <textarea
                    id="description"
                    v-model="form.description"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 p-10 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
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
            <div>
                <button
                    type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                >
                    Créer
                </button>
            </div>
        </form>
    </section>
</template>
