<script setup>
import Button from '@/components/ui/button/Button.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
});

function submitForm() {
    form.put(`/admin/users/${props.user.id}`, {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(
                "Erreur lors de la mise à jour de l'utilisateur.",
                errors,
            );
        },
    });
}
</script>

<template>
    <section class="mx-4 my-4 space-y-4">
        <h1 class="px-4 py-4 text-2xl font-bold">Modifier l'utilisateur</h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                    >Nom</label
                >
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.name ? 'border-red-500' : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                {{ form.errors.name }}
            </p>
            <div>
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700"
                    >Email</label
                >
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.email
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                {{ form.errors.email }}
            </p>
            <div>
                <label
                    for="password"
                    class="block text-sm font-medium text-gray-700"
                    >Mot de passe (laisser vide pour ne pas changer)</label
                >
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.password
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>
            <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">
                {{ form.errors.password }}
            </p>
            <div>
                <label
                    for="password_confirmation"
                    class="block text-sm font-medium text-gray-700"
                    >Confirmer le mot de passe</label
                >
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    :class="[
                        'focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200',
                        form.errors.password_confirmation
                            ? 'border-red-500'
                            : 'border-gray-300',
                    ]"
                />
            </div>
            <p
                v-if="form.errors.password_confirmation"
                class="mt-1 text-sm text-red-600"
            >
                {{ form.errors.password_confirmation }}
            </p>
            <div>
                <Button type="submit" style="background-color: var(--button)">
                    Enregistrer les modifications
                </Button>
            </div>
        </form>
    </section>
</template>
