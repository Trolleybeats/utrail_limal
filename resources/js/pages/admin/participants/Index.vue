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
    participants: {
        type: Array,
        required: true,
    },
});

const deleteDialog = ref(false);
const participantToDelete = ref(null);

function openDeleteDialog(participant) {
    participantToDelete.value = participant;
    deleteDialog.value = true;
}

const deleteParticipant = () => {
    if (participantToDelete.value) {
        router.delete(`/admin/participants/${participantToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                participantToDelete.value = null;
            },
            onError: (errors) => {
                console.error(
                    'Erreur lors de la suppression du participant.',
                    errors,
                );
            },
        });
    }
};

const editParticipant = (participant) => {
    router.visit(`/admin/participants/${participant.id}/edit`);
};
</script>

<template>
    <section class="mx-4 my-4 space-y-4">
        <h1 class="py-4 text-2xl font-bold">Participants</h1>
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th scope="col" class="border px-4 py-2 text-left">
                            Nom
                        </th>
                        <th scope="col" class="border px-4 py-2 text-left">
                            Prénom
                        </th>
                        <th scope="col" class="border px-4 py-2 text-left">
                            Email
                        </th>
                        <th scope="col" class="border px-4 py-2 text-left">
                            Téléphone
                        </th>
                        <th scope="col" class="border px-4 py-2 text-left">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody
                    class="divide-y divide-gray-100 border-t border-gray-100"
                >
                    <tr
                        v-for="participant in participants"
                        :key="participant.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="border px-4 py-2">{{ participant.nom }}</td>
                        <td class="border px-4 py-2">
                            {{ participant.prenom }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ participant.email }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ participant.telephone }}
                        </td>
                        <td
                            class="border px-4 py-2 text-right text-sm font-medium whitespace-nowrap"
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
                                        background-color: var(
                                            --background-footer
                                        );
                                        color: var(--secondary);
                                    "
                                >
                                    <DropdownMenuLabel>
                                        Actions pour {{ participant.nom }}
                                    </DropdownMenuLabel>
                                    <DropdownMenuItem
                                        @click="editParticipant(participant)"
                                    >
                                        Modifier
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="openDeleteDialog(participant)"
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
                    Êtes-vous sûr de vouloir supprimer ce participant ?
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
                    @click="deleteParticipant"
                    style="background-color: var(--button)"
                >
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
