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
    echeanciers: {
        type: Array,
        required: true,
    },
});

const deleteDialog = ref(false);
const echeancierToDelete = ref(null);

function openDeleteDialog(echeancier) {
    echeancierToDelete.value = echeancier;
    deleteDialog.value = true;
}

const deleteEcheancier = () => {
    if (echeancierToDelete.value) {
        router.delete(`/admin/echeanciers/${echeancierToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                echeancierToDelete.value = null;
            },
            onError: (errors) => {
                console.error(
                    "Erreur lors de la suppression de l'échéancier.",
                    errors,
                );
            },
        });
    }
};

const editEcheancier = (echeancier) => {
    router.visit(`/admin/echeanciers/${echeancier.id}/edit`);
};

const createEcheancier = () => {
    router.visit('/admin/echeanciers/create');
};

const desactiverEcheancier = (echeancier) => {
    router.patch(
        `/admin/echeanciers/${echeancier.id}/actifs`,
        {},
        {
            preserveScroll: true,
        },
    );
};
</script>

<template>
    <section class="mx-2 my-2 space-y-4 sm:mx-4 sm:my-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Echéanciers</h1>
            <Button @click="createEcheancier" class="text-[#F6F6F6] sm:w-auto"
                >Créer un échéancier</Button
            >
        </div>
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">Label</th>
                        <th class="border px-4 py-2 text-left">
                            Nombre de versements
                        </th>
                        <th class="border px-4 py-2 text-left">Dates</th>
                        <th class="border px-4 py-2 text-left">Est actif</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="echeancier in echeanciers"
                        :key="echeancier.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="border px-4 py-2">{{ echeancier.label }}</td>
                        <td class="border px-4 py-2">
                            {{ echeancier.nombre_versements }}
                        </td>
                        <td class="border px-4 py-2">
                            <ul>
                                <li
                                    v-for="(date, index) in echeancier.dates"
                                    :key="index"
                                >
                                    {{ new Date(date).toLocaleDateString() }}
                                </li>
                            </ul>
                        </td>
                        <td class="border px-4 py-2">
                            <span
                                :class="{
                                    'text-green-600': echeancier.est_actif,
                                    'text-red-600': !echeancier.est_actif,
                                }"
                            >
                                {{ echeancier.est_actif ? 'Oui' : 'Non' }}
                            </span>
                        </td>
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
                                        background-color: var(
                                            --background-footer
                                        );
                                        color: var(--secondary);
                                    "
                                >
                                    <DropdownMenuLabel>
                                        Actions pour {{ echeancier.label }}
                                    </DropdownMenuLabel>
                                    <DropdownMenuItem
                                        @click="editEcheancier(echeancier)"
                                    >
                                        Modifier
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="openDeleteDialog(echeancier)"
                                    >
                                        Supprimer
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="
                                            desactiverEcheancier(echeancier)
                                        "
                                    >
                                        {{
                                            echeancier.est_actif
                                                ? 'Désactiver'
                                                : 'Activer'
                                        }}
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
                    Êtes-vous sûr de vouloir supprimer l'échéancier "{{
                        echeancierToDelete?.label
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
                    @click="deleteEcheancier"
                    style="background-color: var(--button)"
                >
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
