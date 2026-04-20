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
    projets: {
        type: Array,
        required: true,
    },
});

// Copie locale pour la réorganisation
const liste = ref([...props.projets]);

const deleteDialog = ref(false);
const projetToDelete = ref(null);

function openDeleteDialog(projet) {
    projetToDelete.value = projet;
    deleteDialog.value = true;
}

const deleteProjet = () => {
    if (projetToDelete.value) {
        router.delete(`/admin/projets/${projetToDelete.value.id}`, {
            onSuccess: () => {
                deleteDialog.value = false;
                projetToDelete.value = null;
            },
            onError: (errors) => {
                console.error(
                    'Erreur lors de la suppression du projet.',
                    errors,
                );
            },
        });
    }
};

const editProjet = (projet) => {
    router.visit(`/admin/projets/${projet.id}/edit`);
};

const createProjet = () => {
    router.visit('/admin/projets/create');
};

function moveUp(index) {
    if (index === 0) return;
    const arr = [...liste.value];
    [arr[index - 1], arr[index]] = [arr[index], arr[index - 1]];
    liste.value = arr;
    saveOrder();
}

function moveDown(index) {
    if (index === liste.value.length - 1) return;
    const arr = [...liste.value];
    [arr[index + 1], arr[index]] = [arr[index], arr[index + 1]];
    liste.value = arr;
    saveOrder();
}

function saveOrder() {
    router.post(
        '/admin/projets/reorder',
        { ordre: liste.value.map((p) => p.id) },
        { preserveScroll: true },
    );
}
</script>

<template>
    <section class="mx-2 my-2 space-y-4 sm:mx-4 sm:my-4">
        <div
            class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h1 class="py-4 text-xl font-bold sm:text-2xl">Projets</h1>
            <Button @click="createProjet" class="text-[#F6F6F6] sm:w-auto"
                >Créer un projet</Button
            >
        </div>
        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th class="border px-4 py-2 text-left">Ordre</th>
                        <th class="border px-4 py-2 text-left">
                            Nom du projet
                        </th>
                        <th class="border px-4 py-2 text-left">Description</th>
                        <th class="border px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(projet, index) in liste"
                        :key="projet.id"
                        @click="editProjet(projet)"
                        class="cursor-pointer hover:bg-gray-50"
                    >
                        <td
                            class="border px-4 py-2 whitespace-nowrap"
                            @click.stop
                        >
                            <div class="flex items-center gap-1">
                                <button
                                    type="button"
                                    :disabled="index === 0"
                                    @click="moveUp(index)"
                                    class="rounded p-1 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                    title="Monter"
                                >
                                    ▲
                                </button>
                                <span
                                    class="w-6 text-center text-sm text-gray-600"
                                    >{{ index + 1 }}</span
                                >
                                <button
                                    type="button"
                                    :disabled="index === liste.length - 1"
                                    @click="moveDown(index)"
                                    class="rounded p-1 text-gray-500 hover:bg-gray-200 disabled:opacity-30"
                                    title="Descendre"
                                >
                                    ▼
                                </button>
                            </div>
                        </td>
                        <td class="border px-4 py-2">{{ projet.titre }}</td>
                        <td class="border px-4 py-2">
                            {{ projet.description }}
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
                                        Actions pour {{ projet.titre }}
                                    </DropdownMenuLabel>
                                    <DropdownMenuItem
                                        @click="editProjet(projet)"
                                    >
                                        Modifier
                                    </DropdownMenuItem>
                                    <DropdownMenuItem
                                        @click="openDeleteDialog(projet)"
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
                    Êtes-vous sûr de vouloir supprimer le projet "{{
                        projetToDelete?.titre
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
                    @click="deleteProjet"
                    style="background-color: var(--button)"
                >
                    Supprimer
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
