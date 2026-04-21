<script setup>
import { watch } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    fieldPrefix: {
        type: String,
        required: true,
    },
    tarifsDistance: {
        type: Object,
        default: () => ({}),
    },
    tarifsLogement: {
        type: Object,
        default: null,
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
});

const participation = defineModel('participation');
const distance = defineModel('distance');
const logement = defineModel('logement');

watch(participation, (val) => {
    if (val === 0) {
        distance.value = 'non';
        logement.value = 0;
    }
});
</script>

<template>
    <h3 class="mb-4 text-xl font-semibold md:mb-6 md:text-[36px]">
        {{ title }}
    </h3>

    <!-- Participation -->
    <div class="mb-6 flex flex-col gap-4">
        <label
            :for="`participation_${fieldPrefix}`"
            class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
        >
            Participation (si vous ne participez pas, cliquez sur non aux autres
            questions de la {{ title }}) &nbsp;<span class="text-[#c42827]"
                >*</span
            >
        </label>
        <select
            v-model="participation"
            :id="`participation_${fieldPrefix}`"
            :name="`participation_${fieldPrefix}`"
            required
            class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
        >
            <option value="" disabled>Choisissez une option</option>
            <option :value="1">Oui</option>
            <option :value="0">Non</option>
        </select>
        <p
            v-if="errors[`participation_${fieldPrefix}`]"
            class="text-sm text-[#c42827]"
        >
            {{ errors[`participation_${fieldPrefix}`] }}
        </p>
    </div>

    <!-- Distance -->
    <div class="mb-6 flex flex-col gap-4">
        <label
            :for="`distance_${fieldPrefix}`"
            class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
        >
            Distance&nbsp;<span class="text-[#c42827]">*</span>
        </label>
        <select
            v-model="distance"
            :id="`distance_${fieldPrefix}`"
            :name="`distance_${fieldPrefix}`"
            required
            class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
        >
            <option value="" disabled>Choisissez une option</option>
            <option
                v-for="(prix, label) in tarifsDistance"
                :key="label"
                :value="label"
            >
                {{ label }} ({{ Number(prix).toFixed(2) }} €)
            </option>
            <option value="non">Non</option>
        </select>
        <p
            v-if="errors[`distance_${fieldPrefix}`]"
            class="text-sm text-[#c42827]"
        >
            {{ errors[`distance_${fieldPrefix}`] }}
        </p>
    </div>

    <!-- Logement -->
    <div class="mb-6 flex flex-col gap-4">
        <label
            :for="`logement_${fieldPrefix}`"
            class="flex items-center text-[18px] font-medium text-[#586166] md:text-[20px]"
        >
            Logement&nbsp;<span class="text-[#c42827]">*</span>
        </label>
        <select
            v-model="logement"
            :id="`logement_${fieldPrefix}`"
            :name="`logement_${fieldPrefix}`"
            required
            class="h-[54px] w-full rounded-[6px] border border-transparent bg-white px-4 text-[16px] text-black focus:border-[#b3a96f] focus:outline-none"
        >
            <option value="" disabled>Choisissez une option</option>
            <option :value="1">
                Oui
                <template v-if="tarifsLogement">
                    ({{ Number(tarifsLogement.prix).toFixed(2) }} €)
                </template>
            </option>
            <option :value="0">Non</option>
        </select>
        <p
            v-if="errors[`logement_${fieldPrefix}`]"
            class="text-sm text-[#c42827]"
        >
            {{ errors[`logement_${fieldPrefix}`] }}
        </p>
    </div>
</template>
