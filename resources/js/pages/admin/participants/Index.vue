<script setup>
import { ref, onMounted } from 'vue';
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
const dernierEnvoi = ref(null);

onMounted(() => {
    const saved = localStorage.getItem('dernierEnvoiMailAll');
    if (saved) dernierEnvoi.value = saved;
});
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

const envoimail = (participant) => {
    if (participant) {
        router.post(`/admin/participants/${participant.id}/send-mail`);
    }
};

const envoimailAll = () => {
    const now = new Date().toISOString();
    localStorage.setItem('dernierEnvoiMailAll', now);
    dernierEnvoi.value = now;
    router.post('/admin/participants/send-mail-all');
};

const exportExcel = () => {
    window.location.href = '/admin/participants/export';
};

const dateEnvoi = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <section class="mx-2 my-2 space-y-4 sm:mx-4 sm:my-4">
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h1 class="text-xl font-bold sm:text-2xl">Participants</h1>
            <Button @click="exportExcel" variant="outline">
                Exporter Excel
            </Button>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <Button @click="envoimailAll" style="color: var(--secondary)"
                >Envoyer le mail à tous</Button
            >
            <p class="text-sm text-gray-500 sm:ml-4">
                Dernier envoi :
                {{ dernierEnvoi ? dateEnvoi(dernierEnvoi) : 'Aucun envoi' }}
            </p>
        </div>
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full table-auto">
                <thead>
                    <tr>
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
                            Mail envoyé le
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
                        <td class="border px-4 py-2">
                            {{
                                participant.mail_envoye_le
                                    ? dateEnvoi(participant.mail_envoye_le)
                                    : dernierEnvoi &&
                                        new Date(participant.created_at) >
                                            new Date(dernierEnvoi)
                                      ? 'Inscrit après envoi'
                                      : 'Jamais envoyé'
                            }}
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
                                    <DropdownMenuItem
                                        @click="envoimail(participant)"
                                    >
                                        Envoyer le Mail
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
