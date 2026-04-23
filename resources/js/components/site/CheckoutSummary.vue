<script setup>
defineProps({
    membre: {
        type: Object,
        required: true,
    },
    versement: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <div class="mb-8 rounded-[6px] bg-white px-6 py-4">
        <p class="text-[18px] font-medium text-[#586166] md:text-[20px]">
            Inscription pour :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.participant.prenom }}
                {{ membre.participant.nom }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            Course n°1 :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.participation_un ? 'Oui' : 'Non' }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            Distance :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.distance_un ? membre.distance_un : 'Aucune' }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            Logement :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.logement_un ? 'Oui' : 'Non' }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            Course n°2 :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.participation_deux ? 'Oui' : 'Non' }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            Distance :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.distance_deux ? membre.distance_deux : 'Aucune' }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            Logement :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.logement_deux ? 'Oui' : 'Non' }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            T-shirt:
            <span class="font-semibold text-[#B3A96F] uppercase">
                {{ membre.tshirt_taille }}
            </span>
        </p>
        <p class="mt-2 text-[16px] text-[#586166]">
            Montant total :
            <span class="font-semibold text-[#B3A96F]">
                {{ membre.montant_total.toFixed(2) }} €
            </span>
        </p>

        <!-- Versement info (single-versement mode from admin link) -->
        <p v-if="versement" class="mt-2 text-[16px] text-[#586166]">
            Versement n°{{ versement.numero_versement }} —
            <span class="font-semibold text-[#B3A96F]">
                {{ versement.montant.toFixed(2) }} €
            </span>
            (échéance {{ versement.date_echeance }})
        </p>
    </div>
</template>
