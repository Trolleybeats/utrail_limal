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
        type: Object,
        required: true,
    },
    membres: {
        type: Array,
        required: true,
    },
});

const deleteDialog = ref(false);
const membreToDelete = ref(null);

function openDeleteDialog(membre) {
    membreToDelete.value = membre;
    deleteDialog.value = true;
}

const deleteMembre = () => {
    if (membreToDelete.value) {
        router.delete(`/admin/membres/${membreToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                membreToDelete.value = null;
            },
            onError: (errors) => {
                console.error(
                    'Erreur lors de la suppression du membre.',
                    errors,
                );
            },
        });
    }
};

const editMembre = (membre) => {
    router.visit(`/admin/membres/${membre.id}/edit`);
};

const dateFormat = (date) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('fr-FR', options);
};

const exportExcel = () => {
    window.location.href = '/admin/membres/export';
};
</script>

<template>
    <div class="container mx-auto px-2 py-4 sm:px-4 sm:py-8">
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h1 class="text-xl font-bold sm:text-2xl">Gestion des Membres</h1>
            <Button @click="exportExcel" variant="outline">
                Exporter Excel
            </Button>
        </div>
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Nom</th>
                        <th class="border px-4 py-2">Prénom</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Téléphone</th>
                        <th class="border px-4 py-2">Date de naissance</th>
                        <th class="border px-4 py-2">Course 1</th>
                        <th class="border px-4 py-2">Distance 1</th>
                        <th class="border px-4 py-2">Logement 1</th>
                        <th class="border px-4 py-2">Course 2</th>
                        <th class="border px-4 py-2">Distance 2</th>
                        <th class="border px-4 py-2">Logement 2</th>
                        <th class="border px-4 py-2">Taille tshirt</th>
                        <th class="border px-4 py-2">Paiement</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="membre in membres"
                        :key="membre.id"
                        class="hover:bg-gray-100"
                    >
                        <td class="border px-4 py-2">
                            {{ membre.participant_id }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.participant?.nom }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.participant?.prenom }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.participant?.email }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.participant?.telephone }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ dateFormat(membre.date_naissance) }}
                        </td>
                        <td class="border px-4 py-2">
                            {{
                                membre.participation_un === true ? 'Oui' : 'Non'
                            }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.distance_un }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.logement_un === true ? 'Oui' : 'Non' }}
                        </td>
                        <td class="border px-4 py-2">
                            {{
                                membre.participation_deux === true
                                    ? 'Oui'
                                    : 'Non'
                            }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.distance_deux }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.logement_deux === true ? 'Oui' : 'Non' }}
                        </td>
                        <td class="border px-4 py-2 uppercase">
                            {{ membre.tshirt_taille }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ membre.payment_status ? 'Payé' : 'Non payé' }}
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
                                        Actions pour {{ membre.participant_id }}
                                    </DropdownMenuLabel>
                                    <DropdownMenuItem
                                        @click="editMembre(membre)"
                                    >
                                        Modifier
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="openDeleteDialog(membre)"
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
    </div>
    <Dialog v-model="deleteDialog">
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Confirmer la suppression</DialogTitle>
                <DialogDescription>
                    Êtes-vous sûr de vouloir supprimer ce membre ? Cette action
                    est irréversible.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button variant="outline" @click="deleteDialog = false">
                    Annuler
                </Button>
                <Button
                    @click="deleteMembre"
                    style="background-color: var(--button)"
                >
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
