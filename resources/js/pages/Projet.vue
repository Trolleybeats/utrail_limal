<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    projetActuel: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <Head>
        <title>Trail de l'année – inscription</title>
        <meta
            name="description"
            content="Inscrivez-vous au trail annuel organisé par U-Trail Limal. Participez à notre événement trail en Brabant wallon, ouvert à tous les traileurs francophones."
        />
        <meta
            name="keywords"
            content="inscription trail, événement trail, trail annuel, participation trail, course nature, trail Brabant wallon, trail Limal"
        />
        <meta property="og:title" content="Trail de l'année – inscription" />
        <meta
            property="og:description"
            content="Inscrivez-vous au trail annuel organisé par U-Trail Limal. Participez à notre événement trail en Brabant wallon."
        />
        <meta property="og:url" content="https://utrail-limal.be/projet" />
    </Head>
    <!-- Hero header -->
    <header
        class="relative h-[280px] w-full sm:h-[380px] md:h-[520px] lg:h-screen"
    >
        <div class="absolute top-0 left-0 z-10 h-full w-full">
            <Nav></Nav>
        </div>
        <figure class="absolute top-0 left-0 h-full w-full">
            <img
                src="/storage/projet.jpg"
                alt="Projet U-Trail Limal"
                class="h-full w-full object-cover"
            />
        </figure>
    </header>
    <main id="main-content">
        <section class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Projet de l'année {{ new Date().getFullYear() }}
            </h2>

            <div v-if="projetActuel">
                <div>
                    <figure v-if="projetActuel.photoPrincipale">
                        <img
                            :src="projetActuel.photoPrincipale.url"
                            :alt="projetActuel.titre"
                            class="h-64 w-full rounded object-contain md:h-80"
                        />
                    </figure>
                    <figure
                        v-else-if="
                            projetActuel.photos && projetActuel.photos.length
                        "
                        :class="[
                            'grid gap-2',
                            projetActuel.photos.length === 1
                                ? 'grid-cols-1'
                                : projetActuel.photos.length === 2
                                  ? 'grid-cols-2'
                                  : 'grid-cols-3',
                        ]"
                    >
                        <img
                            v-for="photo in projetActuel.photos.slice(0, 4)"
                            :key="photo.id"
                            :src="photo.url"
                            :alt="projetActuel.titre"
                            class="h-64 w-full rounded object-contain"
                        />
                    </figure>
                    <div class="mt-12 w-full space-y-4">
                        <p
                            v-for="(
                                paragraph, index
                            ) in projetActuel.description
                                .split('\n')
                                .filter((p) => p.trim())"
                            :key="index"
                            class="w-full text-justify text-sm leading-relaxed text-gray-800 sm:text-base md:text-[20px]"
                        >
                            {{ paragraph }}
                        </p>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <Link
                            href="/Inscription"
                            class="inline-block rounded-sm bg-[#C42827] px-6 py-3 text-sm font-semibold text-[#F6F6F6] sm:text-2xl"
                        >
                            Rejoindre l'aventure
                        </Link>
                    </div>
                </div>
            </div>

            <p v-else class="text-center text-gray-500">
                Aucun projet en cours pour le moment.
            </p>
        </section>
    </main>
    <Footer></Footer>
</template>
