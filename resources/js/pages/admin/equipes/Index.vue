<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogFooter from '@/components/ui/dialog/DialogFooter.vue';
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';

const props = defineProps({
    equipes: {
        type: Array,
        required: true,
    },
});

const deleteDialog = ref(false);
const equipeToDelete = ref(null);

function openDeleteDialog(equipe) {
    equipeToDelete.value = equipe;
    deleteDialog.value = true;
}

const deleteEquipe = () => {
    if (equipeToDelete.value) {
        router.delete(`/admin/equipes/${equipeToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                equipeToDelete.value = null;
            },
            onError: (errors) => {
                console.error(
                    "Erreur lors de la suppression de l'équipe.",
                    errors,
                );
            },
        });
    }
};

const editEquipe = (equipe) => {
    router.visit(`/admin/equipes/${equipe.id}/edit`);
};

const createEquipe = () => {
    router.visit('/admin/equipes/create');
};
</script>

<template>
    <section class="mx-4 my-4 space-y-4">
        <h1 class="px-4 py-4 text-2xl font-bold">Équipes</h1>
        <Button @click="createEquipe" class="text-[#F6F6F6]"
            >Créer une équipe</Button
        >
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Nom</th>
                    <th class="border px-4 py-2 text-left">Prénom</th>
                    <th class="border px-4 py-2 text-left">Rôle</th>
                    <th class="border px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="equipe in equipes"
                    :key="equipe.id"
                    class="hover:bg-gray-50"
                >
                    <td class="border px-4 py-2">{{ equipe.nom }}</td>
                    <td class="border px-4 py-2">{{ equipe.prenom }}</td>
                    <td class="border px-4 py-2">{{ equipe.role }}</td>
                    <td
                        class="border px-6 py-4 text-right text-sm font-medium whitespace-nowrap"
                        @click.stop
                    >
                        <DropdownMenu>
                            <DropdownMenuTrigger>
                                <Button variant="outline" size="sm">
                                    •••
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent
                                style="
                                    background-color: var(--background-footer);
                                    color: var(--secondary);
                                "
                            >
                                <DropdownMenuLabel>
                                    Actions pour {{ equipe.nom }}
                                </DropdownMenuLabel>
                                <DropdownMenuItem @click="editEquipe(equipe)">
                                    Modifier
                                </DropdownMenuItem>
                                <DropdownMenuItem
                                    @click="openDeleteDialog(equipe)"
                                >
                                    Supprimer
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <!-- Dialog de confirmation de suppression -->
    <Dialog v-model:open="deleteDialog">
        <DialogContent
            style="
                background-color: var(--background-footer);
                color: var(--secondary);
            "
        >
            <DialogHeader>
                <DialogTitle>Confirmer la suppression</DialogTitle>
                <DialogDescription>
                    Êtes-vous sûr de vouloir supprimer l'équipe "{{
                        equipeToDelete?.nom
                    }}" ? Cette action est irréversible.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button
                    variant="outline"
                    @click="deleteDialog = false"
                    style="color: var(--primary)"
                >
                    Annuler
                </Button>
                <Button
                    variant="destructive"
                    @click="deleteEquipe"
                    style="background-color: var(--button)"
                >
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
