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
    formations: {
        type: Array,
        required: true,
    },
});

const deleteDialog = ref(false);
const formationToDelete = ref(null);

function openDeleteDialog(formation) {
    formationToDelete.value = formation;
    deleteDialog.value = true;
}

const deleteFormation = () => {
    if (formationToDelete.value) {
        router.delete(`/admin/formations/${formationToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                formationToDelete.value = null;
            },
            onError: (errors) => {
                console.error(
                    'Erreur lors de la suppression de la formation.',
                    errors,
                );
            },
        });
    }
};

const editFormation = (formation) => {
    router.visit(`/admin/formations/${formation.id}/edit`);
};

const createFormation = () => {
    router.visit('/admin/formations/create');
};
</script>

<template>
    <section class="mx-2 my-2 space-y-4 sm:mx-4 sm:my-4">
        <div
            class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h1 class="py-4 text-xl font-bold sm:text-2xl">Formations</h1>
            <Button @click="createFormation" class="text-[#F6F6F6] sm:w-auto"
                >Créer une formation</Button
            >
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="border px-4 py-2 text-left">Titre</th>
                        <th class="border px-4 py-2 text-left">Description</th>
                        <th class="border px-4 py-2 text-left">Date</th>
                        <th class="border px-4 py-2 text-left">Niveau</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="formation in formations" :key="formation.id">
                        <td class="border px-4 py-2">{{ formation.titre }}</td>
                        <td class="border px-4 py-2">
                            {{ formation.description }}
                        </td>
                        <td class="border px-4 py-2">{{ formation.date }}</td>
                        <td class="border px-4 py-2">{{ formation.niveau }}</td>
                        <td class="border px-4 py-2">
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="outline" size="sm">
                                        •••
                                    </Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    class="min-w-40"
                                    @click.stop
                                >
                                    <DropdownMenuLabel>
                                        Actions pour {{ formation.titre }}
                                    </DropdownMenuLabel>
                                    <DropdownMenuItem
                                        @click="editFormation(formation)"
                                    >
                                        Modifier
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="openDeleteDialog(formation)"
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
    </section>
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
                    Êtes-vous sûr de vouloir supprimer cette formation ?
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
                    @click="deleteFormation"
                    style="background-color: var(--button)"
                >
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
