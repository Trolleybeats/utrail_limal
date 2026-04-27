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
    <div class="mx-auto w-full max-w-[600px] px-4 py-8">
        <h1
            class="mb-6 text-center text-2xl font-bold text-[var(--primary)] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
        >
            Modifier l'utilisateur
        </h1>
        <form @submit.prevent="submitForm" class="space-y-6">
            <div>
                <label for="name" class="mb-2 block font-medium">Nom</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    required
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.name
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                    {{ form.errors.name }}
                </p>
            </div>
            <div>
                <label for="email" class="mb-2 block font-medium">Email</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.email
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">
                    {{ form.errors.email }}
                </p>
            </div>
            <div>
                <label for="password" class="mb-2 block font-medium"
                    >Mot de passe (laisser vide pour ne pas changer)</label
                >
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.password
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p
                    v-if="form.errors.password"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.password }}
                </p>
            </div>
            <div>
                <label
                    for="password_confirmation"
                    class="mb-2 block font-medium"
                    >Confirmer le mot de passe</label
                >
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    :class="[
                        'w-full rounded-md border p-2',
                        form.errors.password_confirmation
                            ? 'border-red-500'
                            : 'border-[var(--primary)]',
                    ]"
                />
                <p
                    v-if="form.errors.password_confirmation"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ form.errors.password_confirmation }}
                </p>
            </div>
            <div class="flex justify-center">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="cursor-pointer rounded-md bg-[var(--primary)] px-4 py-2 text-white disabled:bg-gray-400"
                >
                    {{
                        form.processing
                            ? 'Enregistrement...'
                            : 'Enregistrer les modifications'
                    }}
                </button>
            </div>
        </form>
    </div>
</template>
