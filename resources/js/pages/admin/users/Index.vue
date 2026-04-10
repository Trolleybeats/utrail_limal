<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import DialogFooter from '@/components/ui/dialog/DialogFooter.vue';
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const deleteDialog = ref(false);
const userToDelete = ref(null);

function openDeleteDialog(user) {
    userToDelete.value = user;
    deleteDialog.value = true;
}

const deleteUser = () => {
    if (userToDelete.value) {
        router.delete(`/users/${userToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                userToDelete.value = null;
            },
            onError: (errors) => {
                // Gérer les erreurs si nécessaire
                console.error(
                    "Erreur lors de la suppression de l'utilisateur.",
                    errors,
                );
            },
        });
    }
};
</script>

<template>
    <div class="mx-4 my-4 space-y-4">
        <h1 class="px-4 py-4 text-2xl font-bold">Users</h1>
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Email</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" class="border-t">
                    <td class="px-4 py-2">{{ user.name }}</td>
                    <td class="px-4 py-2">{{ user.email }}</td>
                    <td
                        class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap"
                        @click.stop
                    >
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Button variant="outline" size="sm">
                                    •••
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent>
                                <DropdownMenuLabel>
                                    Actions pour {{ user.name }}
                                </DropdownMenuLabel>
                                <DropdownMenuItem
                                    @click="
                                        router.visit(`/users/${user.id}/edit`)
                                    "
                                >
                                    Modifier
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    @click="openDeleteDialog(user)"
                                >
                                    Supprimer
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Dialog de confirmation de suppression -->
    <Dialog v-model:open="deleteDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Confirmer la suppression</DialogTitle>
                <DialogDescription>
                    Êtes-vous sûr de vouloir supprimer l'utilisateur "{{
                        userToDelete?.name
                    }}" ? Cette action est irréversible.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button
                    type="button"
                    variant="outline"
                    @click="deleteDialog = false"
                >
                    Annuler
                </Button>
                <Button type="button" variant="destructive" @click="deleteUser">
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
