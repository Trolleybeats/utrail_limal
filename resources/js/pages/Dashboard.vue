<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';

const props = defineProps({
    participantsCount: {
        type: Number,
        required: true,
    },
    membresCount: {
        type: Number,
        required: true,
    },
});

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Vue d'ensemble",
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <div
        class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
    >
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div
                class="relative flex flex-col items-center justify-center gap-2 overflow-hidden rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            >
                <span class="text-4xl font-bold">{{
                    props.participantsCount
                }}</span>
                <span class="text-sm text-muted-foreground">Participants</span>
            </div>
            <div
                class="relative flex flex-col items-center justify-center gap-2 overflow-hidden rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            >
                <span class="text-4xl font-bold">{{ props.membresCount }}</span>
                <span class="text-sm text-muted-foreground">Membres</span>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
            >
                <PlaceholderPattern />
            </div>
        </div>
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
        >
            <PlaceholderPattern />
        </div>
    </div>
</template>
