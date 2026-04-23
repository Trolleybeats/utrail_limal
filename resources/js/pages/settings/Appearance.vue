<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppearanceTabs from '@/components/AppearanceTabs.vue';
import Heading from '@/components/Heading.vue';
import { edit } from '@/routes/appearance';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: "Paramêtres d'apparence",
                href: edit(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Paramêtres d'apparence" />

    <h1 class="sr-only">Paramêtres d'apparence</h1>

    <div class="space-y-6">
        <Heading
            variant="small"
            title="Paramêtres d'apparence"
            description="Mettez à jour les paramètres d'apparence de votre compte"
        />
        <AppearanceTabs />
    </div>
</template>
