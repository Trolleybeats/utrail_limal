<script setup lang="ts">
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import FormationCard from '@/components/site/FormationCard.vue';

interface Formation {
    id: number;
    titre: string;
    description?: string;
    date: string;
    photo?: string;
    niveau?: string;
}

const props = defineProps<{
    formations: Formation[];
}>();
</script>

<template>
    <!-- Hero header -->
    <header class="relative h-70 w-full sm:h-95 md:h-130 lg:h-screen">
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav />
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/formation.jpg"
                alt="Formation U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>

    <main>
        <section class="mx-auto w-full max-w-295.5 px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Formation U-Trail Limal
            </h2>
        </section>

        <section class="mx-auto w-full max-w-295.5 px-4 pb-14">
            <!-- Empty state -->
            <p v-if="!formations.length" class="text-center text-gray-500">
                Aucune formation disponible pour le moment.
            </p>

            <!-- Formations grid -->
            <div
                v-else
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
            >
                <FormationCard
                    v-for="formation in formations"
                    :key="formation.id"
                    :formation="formation"
                />
            </div>
        </section>
    </main>

    <Footer />
</template>
