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
    tarifs: {
        type: Array,
        required: true,
    },
});

const deleteDialog = ref(false);
const tarifToDelete = ref(null);

function openDeleteDialog(tarif) {
    tarifToDelete.value = tarif;
    deleteDialog.value = true;
}

const deleteTarif = () => {
    if (tarifToDelete.value) {
        router.delete(`/admin/tarifs/${tarifToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                tarifToDelete.value = null;
            },
            onError: (errors) => {
                // Gérer les erreurs si nécessaire
                console.error(
                    'Erreur lors de la suppression du tarif.',
                    errors,
                );
            },
        });
    }
};

const createTarif = () => {
    router.visit('/admin/tarifs/create');
};

const editTarif = (tarif) => {
    router.visit(`/admin/tarifs/${tarif.id}/edit`);
};

const desactiverTarif = (tarif) => {
    router.patch(
        `/admin/tarifs/${tarif.id}/actifs`,
        {},
        {
            preserveScroll: true,
        },
    );
};
</script>

<template>
    <section class="mx-2 my-2 space-y-4 sm:mx-4 sm:my-4">
        <div
            class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h1 class="px-4 py-4 text-xl font-bold sm:text-2xl">Tarifs</h1>
            <Button @click="createTarif" class="text-[#F6F6F6] sm:w-auto"
                >Créer un tarif</Button
            >
        </div>
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Label</th>
                        <th class="px-4 py-2 text-left">Catégorie</th>
                        <th class="px-4 py-2 text-left">Prix</th>
                        <th class="px-4 py-2 text-left">Est actif</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="tarif in tarifs"
                        :key="tarif.id"
                        class="border-t hover:bg-gray-50"
                    >
                        <td class="px-4 py-2">{{ tarif.label }}</td>
                        <td class="px-4 py-2">{{ tarif.categorie }}</td>
                        <td class="px-4 py-2">{{ tarif.prix }} €</td>
                        <td class="px-4 py-2">
                            {{ tarif.est_actif ? 'Oui' : 'Non' }}
                        </td>
                        <td class="px-4 py-2">
                            <DropdownMenu>
                                <DropdownMenuTrigger as-child>
                                    <Button variant="outline" size="sm"
                                        >•••</Button
                                    >
                                </DropdownMenuTrigger>
                                <DropdownMenuContent
                                    style="
                                        background-color: var(
                                            --background-footer
                                        );
                                        color: var(--secondary);
                                    "
                                >
                                    <DropdownMenuItem @click="editTarif(tarif)">
                                        Modifier
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="openDeleteDialog(tarif)"
                                    >
                                        Supprimer
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="desactiverTarif(tarif)"
                                    >
                                        {{
                                            tarif.est_actif
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
            </DialogHeader>
            <DialogDescription>
                Êtes-vous sûr de vouloir supprimer ce tarif ? Cette action est
                irréversible.
            </DialogDescription>
            <DialogFooter>
                <Button
                    variant="outline"
                    @click="deleteDialog = false"
                    style="color: var(--primary)"
                >
                    Annuler
                </Button>
                <Button
                    style="background-color: var(--button)"
                    @click="deleteTarif"
                >
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
