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
    <section class="mx-4 my-4 space-y-4">
        <h1 class="px-4 py-4 text-2xl font-bold">Créer une formation</h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label
                    for="titre"
                    class="block text-sm font-medium text-gray-700"
                    >Titre</label
                >
                <input
                    id="titre"
                    v-model="form.titre"
                    type="text"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.titre
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.titre" class="mt-1 text-sm text-red-600">
                {{ form.errors.titre }}
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
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.description
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                ></textarea>
            </div>
            <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                {{ form.errors.description }}
            </p>
            <div>
                <label
                    for="date"
                    class="block text-sm font-medium text-gray-700"
                    >Date</label
                >
                <input
                    id="date"
                    v-model="form.date"
                    type="date"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.date ? 'border-red-500' : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.date" class="mt-1 text-sm text-red-600">
                {{ form.errors.date }}
            </p>
            <div>
                <label
                    for="niveau"
                    class="block text-sm font-medium text-gray-700"
                    >Niveau</label
                >
                <select
                    id="niveau"
                    v-model="form.niveau"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.niveau
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                >
                    <option value="" disabled>Choisir un niveau</option>
                    <option value="Débutant">Débutant</option>
                    <option value="Intermédiaire">Intermédiaire</option>
                    <option value="Avancé">Avancé</option>
                </select>
            </div>
            <p v-if="form.errors.niveau" class="mt-1 text-sm text-red-600">
                {{ form.errors.niveau }}
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
                    @change="handleFileChange"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border file:border-gray-300 file:bg-gray-50 file:px-4 file:py-2 file:text-sm file:font-semibold hover:file:bg-gray-100"
                />
            </div>
            <p v-if="form.errors.photo" class="mt-1 text-sm text-red-600">
                {{ form.errors.photo }}
            </p>
            <Button type="submit" class="text-[#F6F6F6]">
                Créer la formation
            </Button>
        </form>
    </section>
</template>
