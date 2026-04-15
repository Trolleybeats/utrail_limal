<script setup lang="ts">
import { Bookmark, Share2 } from 'lucide-vue-next';

interface Formation {
    id: number;
    titre: string;
    description?: string;
    date: string;
    photo?: string;
    niveau?: string;
}

defineProps<{ formation: Formation }>();

const MONTHS_FR = [
    'JAN',
    'FÉV',
    'MAR',
    'AVR',
    'MAI',
    'JUN',
    'JUL',
    'AOÛ',
    'SEP',
    'OCT',
    'NOV',
    'DÉC',
];

function formatDay(dateStr: string): string {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return String(d.getDate()).padStart(2, '0');
}

function formatMonth(dateStr: string): string {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return MONTHS_FR[d.getMonth()];
}
</script>

<template>
    <article
        class="flex flex-col overflow-hidden rounded-xl bg-white shadow-[0px_0px_1px_0px_rgba(40,41,61,0.04),0px_2px_4px_0px_rgba(96,97,112,0.16)]"
    >
        <!-- Image + Date badge -->
        <div class="relative h-44.5 shrink-0">
            <img
                v-if="formation.photo"
                :src="`/storage/${formation.photo}`"
                :alt="formation.titre"
                class="h-full w-full object-cover"
            />
            <div v-else class="h-full w-full bg-[#006EFF]" />

            <!-- Date badge -->
            <div
                v-if="formation.date"
                class="absolute right-4 -bottom-7 flex h-14 w-14 flex-col items-center justify-center rounded-xl bg-white shadow-[0px_0px_1px_0px_rgba(40,41,61,0.04),0px_2px_4px_0px_rgba(96,97,112,0.16)]"
            >
                <span class="font-title text-[24px] leading-7 text-[#121212]">
                    {{ formatDay(formation.date) }}
                </span>
                <span
                    class="font-sans text-[13px] leading-4.5 tracking-[0.2px] text-[#121212]"
                >
                    {{ formatMonth(formation.date) }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="flex flex-1 flex-col px-5 pt-10 pb-4">
            <!-- Level + Title -->
            <div class="flex flex-col gap-1">
                <p
                    class="font-sans text-[14px] leading-5.5 tracking-[0.2px] text-[#959393]"
                >
                    {{ formation.niveau }}
                </p>
                <h3 class="font-title text-[20px] leading-6 text-[#121212]">
                    {{ formation.titre }}
                </h3>
            </div>

            <!-- Action buttons -->
            <div class="mt-4 flex items-center gap-3">
                <button
                    type="button"
                    aria-label="Enregistrer"
                    class="flex h-8 w-8 items-center justify-center rounded-full border border-[#E0E0E0] bg-white text-[#121212] transition hover:bg-gray-50"
                >
                    <Bookmark class="h-3.5 w-3.5" :stroke-width="1.5" />
                </button>
                <button
                    type="button"
                    aria-label="Partager"
                    class="flex h-8 w-8 items-center justify-center rounded-full border border-[#E0E0E0] bg-white text-[#121212] transition hover:bg-gray-50"
                >
                    <Share2 class="h-3.5 w-3.5" :stroke-width="1.5" />
                </button>
            </div>
        </div>
    </article>
</template>
