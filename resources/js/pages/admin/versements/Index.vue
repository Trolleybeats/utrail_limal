<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';

const props = defineProps({
    membres: {
        type: Array,
        required: true,
    },
});

const flash = usePage().props.flash;

const sendLienVersement = (versement) => {
    router.post(
        `/admin/versements/${versement.id}/send-lien`,
        {},
        {
            preserveScroll: true,
        },
    );
};

const formatMontant = (euros) => {
    return Number(euros).toLocaleString('fr-FR', {
        style: 'currency',
        currency: 'EUR',
    });
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    });
};

const statutLabel = (statut) => {
    const labels = {
        pending: 'En attente',
        succeeded: 'Payé',
        failed: 'Échoué',
    };
    return labels[statut] ?? statut;
};

const statutClass = (statut) => {
    if (statut === 'succeeded') return 'text-green-600 font-semibold';
    if (statut === 'failed') return 'text-red-500 font-semibold';
    return 'text-yellow-600 font-semibold';
};
</script>

<template>
    <section class="mx-2 my-2 space-y-6 sm:mx-4 sm:my-4">
        <div
            class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <h1 class="text-xl font-bold sm:text-2xl">Versements par membre</h1>
        </div>

        <div
            v-if="flash?.success"
            class="rounded border border-green-300 bg-green-50 px-4 py-3 text-green-700"
        >
            {{ flash.success }}
        </div>

        <div v-if="membres.length === 0" class="text-gray-500">
            Aucun membre avec versements.
        </div>

        <div
            v-for="membre in membres"
            :key="membre.id"
            class="overflow-x-auto rounded-lg border"
        >
            <div class="border-b bg-gray-50 px-4 py-3">
                <span class="font-semibold">
                    {{ membre.participant?.nom }}
                    {{ membre.participant?.prenom }}
                </span>
                <span class="ml-3 text-sm text-gray-500">
                    {{ membre.participant?.email }}
                </span>
                <span class="ml-3 text-sm text-gray-400">
                    — Total :
                    {{
                        formatMontant(
                            membre.versements.reduce(
                                (s, v) => s + v.montant,
                                0,
                            ),
                        )
                    }}
                </span>
            </div>

            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th scope="col" class="border px-4 py-2 text-left">
                            #
                        </th>
                        <th scope="col" class="border px-4 py-2 text-left">
                            Montant
                        </th>
                        <th scope="col" class="border px-4 py-2 text-left">
                            Échéance
                        </th>
                        <th scope="col" class="border px-4 py-2 text-left">
                            Statut
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
                        v-for="versement in membre.versements"
                        :key="versement.id"
                        class="hover:bg-gray-50"
                    >
                        <td class="border px-4 py-2">
                            {{ versement.numero_versement }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ formatMontant(versement.montant) }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ formatDate(versement.date_echeance) }}
                        </td>
                        <td
                            class="border px-4 py-2"
                            :class="statutClass(versement.statut)"
                        >
                            {{ statutLabel(versement.statut) }}
                        </td>
                        <td
                            class="border px-4 py-2 text-right text-sm font-medium whitespace-nowrap"
                            @click.stop
                        >
                            <DropdownMenu>
                                <DropdownMenuTrigger>
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
                                    <DropdownMenuLabel>
                                        Versement n°{{
                                            versement.numero_versement
                                        }}
                                    </DropdownMenuLabel>
                                    <DropdownMenuItem
                                        :disabled="
                                            versement.statut === 'succeeded'
                                        "
                                        @click="sendLienVersement(versement)"
                                    >
                                        Envoyer lien de paiement
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
