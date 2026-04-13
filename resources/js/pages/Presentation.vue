<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';

const props = defineProps({
    projets: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <!-- Hero header -->
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/histoire.jpg"
                alt="Presentation U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>
    <main>
        <section class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Nos projets réalisés
            </h2>

            <div class="grid gap-y-16">
                <div
                    v-for="(projet, index) in projets"
                    :key="projet.id"
                    class="grid items-center gap-8 md:grid-cols-2"
                >
                    <!-- Si index pair : texte gauche / images droite -->
                    <template v-if="index % 2 === 0">
                        <div>
                            <h3
                                class="mb-3 text-right text-xl font-bold text-black uppercase"
                            >
                                {{ projet.titre }}
                            </h3>
                            <p
                                class="text-justify text-sm leading-relaxed text-gray-800"
                            >
                                {{ projet.description }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <img
                                v-for="photo in projet.photos"
                                :key="photo.id"
                                :src="photo.url"
                                :alt="projet.titre"
                                class="h-40 w-full rounded object-contain"
                            />
                        </div>
                    </template>

                    <!-- Si index impair : images gauche / texte droite -->
                    <template v-else>
                        <div class="grid grid-cols-2 gap-2">
                            <img
                                v-for="photo in projet.photos"
                                :key="photo.id"
                                :src="photo.url"
                                :alt="projet.titre"
                                class="h-40 w-full rounded object-contain"
                            />
                        </div>

                        <div>
                            <h3
                                class="mb-3 text-left text-xl font-bold text-black uppercase"
                            >
                                {{ projet.titre }}
                            </h3>
                            <p
                                class="text-justify text-sm leading-relaxed text-gray-800"
                            >
                                {{ projet.description }}
                            </p>
                        </div>
                    </template>
                </div>
            </div>
        </section>
    </main>
    <Footer />
</template>
