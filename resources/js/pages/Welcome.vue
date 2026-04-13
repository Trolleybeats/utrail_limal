<script setup lang="ts">
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    canRegister?: boolean;
    projetActuel: {
        id: number;
        titre: string;
        description: string;
        photos: { id: number; url: string }[];
        photoPrincipale: { id: number; url: string } | null;
    } | null;
}>();
</script>

<template>
    <header class="relative h-[500px] w-full sm:h-[650px] md:h-screen">
        <video
            autoplay
            muted
            loop
            class="absolute top-0 left-0 h-full w-full object-cover"
        >
            <source src="/storage/utrail_limal.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
        <div class="absolute top-0 left-0 h-full w-full">
            <Nav></Nav>
        </div>
        <figure
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 transform"
        >
            <img
                src="/storage/UtrailLimal.png"
                alt="Utrail Limal Logo"
                class="w-32 sm:w-52 md:w-72"
            />
        </figure>
        <h1
            class="absolute top-[80%] left-1/2 w-full -translate-x-1/2 -translate-y-1/2 transform px-4 text-center text-lg font-bold text-[#F6F6F6] sm:text-2xl md:text-[32px]"
        >
            Prêts à relever un nouveau défi ?
        </h1>
        <Link
            href="/Inscription"
            class="absolute top-[88%] left-1/2 -translate-x-1/2 -translate-y-1/2 transform rounded bg-[#C42827] px-5 py-3 text-sm whitespace-nowrap text-[#F6F6F6] sm:text-lg md:text-[24px]"
        >
            Intégrer le projet 2026
        </Link>
    </header>
    <main>
        <section id="shortpres">
            <div class="mx-auto w-full max-w-[1182px] px-4 py-10 md:py-16">
                <h2
                    class="mb-8 text-center text-3xl font-bold text-[#B3A96F] sm:text-4xl md:text-[48px]"
                >
                    U-Trail Limal c'est quoi ?
                </h2>
                <p class="text-base text-[#1A1A1A] sm:text-lg md:text-[20px]">
                    Le trail, c’est bien plus qu’une simple course en pleine
                    nature.
                </p>
                <p
                    class="mt-4 text-base text-[#1A1A1A] sm:text-lg md:text-[20px]"
                >
                    C’est une discipline d’endurance qui allie course à pied et
                    exploration de terrains variés : sentiers escarpés,
                    montagnes, forêts, vallées, parfois même neige ou rochers.
                </p>
                <p
                    class="mt-4 text-base text-[#1A1A1A] sm:text-lg md:text-[20px]"
                >
                    Chaque parcours raconte une histoire différente, façonnée
                    par le relief, les conditions météo et des paysages souvent
                    spectaculaires.
                </p>
                <p
                    class="mt-4 text-base text-[#1A1A1A] sm:text-lg md:text-[20px]"
                >
                    Mais au-delà de la performance, le trail est avant tout une
                    aventure, à la fois physique et mentale. On y apprend à
                    gérer son effort, à écouter son corps, à s’adapter et
                    surtout à profiter pleinement de chaque instant, au cœur
                    d’une nature préservée.
                </p>
            </div>
        </section>
        <section id="sponsor" class="py-10 md:py-16">
            <div class="mx-auto w-full max-w-[1182px] px-4">
                <div class="mb-6 flex items-center justify-center gap-4">
                    <span class="block h-[3px] w-[100px] bg-black"></span>
                    <span
                        ><img
                            src="/storage/montagne.png"
                            alt="Mountain"
                            class="inline-block h-[40px] w-[40px] object-contain"
                    /></span>
                    <span class="block h-[3px] w-[100px] bg-black"></span>
                </div>
                <h2
                    class="mb-10 text-center text-2xl tracking-wide md:text-[26px]"
                >
                    Ils nous accompagnent sur le projet
                </h2>
                <div
                    class="flex flex-wrap items-center justify-center gap-10 md:gap-16"
                >
                    <figure>
                        <a
                            href="https://www.kine-cubitus.be/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Cubitus"
                        >
                            <img
                                src="/storage/cubitus.png"
                                alt="Centre Cubitus"
                                class="h-auto w-[150px] object-contain md:w-[225px]"
                            />
                        </a>
                    </figure>
                    <figure>
                        <a
                            href="https://www.trakks.be/"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Trakks"
                        >
                            <img
                                src="/storage/trakks.png"
                                alt="Trakks"
                                class="h-auto w-[150px] object-contain md:w-[224px]"
                            />
                        </a>
                    </figure>
                    <figure>
                        <a
                            href="https://www.nutri-bay.com/?gad_source=1&gad_campaignid=23160452095&gbraid=0AAAAADLj-_k5EqPqE0C4vuiRAyvL8GvNS&gclid=Cj0KCQjwv-LOBhCdARIsAM5hdKeTkcDJ5bwRUbwoJVAgM9mxowqHC7fhjeSWCXj7MfwqUc6PyoNGTXUaAsjVEALw_wcB"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Nutribay"
                        >
                            <img
                                src="/storage/nutribay.png"
                                alt="Nutribay"
                                class="h-auto w-[150px] object-contain md:w-[225px]"
                            />
                        </a>
                    </figure>
                </div>
            </div>
        </section>
        <section id="fondation" class="bg-[#D0C6AF]">
            <div class="grid grid-cols-1 md:grid-cols-[53fr_47fr]">
                <div
                    class="flex flex-col justify-center px-6 py-10 sm:px-10 md:py-16 md:pr-16 md:pl-[calc((100vw-1182px)/2)]"
                >
                    <h2
                        class="mb-6 font-['Bebas_Neue',sans-serif] text-2xl text-black sm:text-3xl md:text-[36px]"
                    >
                        Fondation du projet
                    </h2>
                    <div
                        class="space-y-4 text-base text-[#1A1A1A] sm:text-lg md:text-[20px]"
                    >
                        <p>
                            Fondé par
                            <span class="font-semibold">Loïc Mascré</span> en
                            <span class="font-semibold">2022</span>, ce projet
                            réunit
                            <span class="font-semibold"
                                >deux de ses passions</span
                            >
                            :
                            <span class="font-semibold"
                                >le trail et son métier de
                                kinésithérapeute</span
                            >, centré sur l'accompagnement, la performance et la
                            santé.
                        </p>
                        <p>
                            L'idée est de
                            <span class="font-semibold"
                                >former une équipe autour d'un objectif
                                commun</span
                            >, de partager l'effort, la progression et le
                            dépassement de soi.
                        </p>
                        <p>
                            Il ne s'agit pas simplement d'un programme
                            d'entraînement, mais d'une
                            <span class="font-semibold"
                                >véritable aventure humaine</span
                            >, encadrée par des coachs, préparateurs physiques
                            et kinés,
                            <span class="font-semibold"
                                >qui conduit chacun plus loin qu'il ne
                                l'imagine</span
                            >.
                        </p>
                    </div>
                    <Link
                        href="/Presentation"
                        class="mt-8 w-fit rounded-sm bg-[#C42827] px-8 py-4 text-sm font-semibold whitespace-nowrap text-[#F6F6F6] sm:text-lg md:text-[24px]"
                    >
                        Voir l'histoire du club
                    </Link>
                </div>
                <div class="min-h-[300px] md:min-h-[683px]">
                    <img
                        src="/storage/fondation.jpg"
                        alt="Fondation du projet"
                        class="h-full w-full object-cover"
                    />
                </div>
            </div>
        </section>
        <section
            id="projet"
            v-if="projetActuel"
            class="mx-auto w-full max-w-[1182px] px-4 py-10 md:py-16"
        >
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Projet de l'année {{ new Date().getFullYear() }}
            </h2>
            <div>
                <div>
                    <figure v-if="projetActuel.photoPrincipale">
                        <img
                            :src="projetActuel.photoPrincipale.url"
                            :alt="projetActuel.titre"
                            class="h-64 w-full rounded object-contain md:h-80"
                        />
                    </figure>
                    <figure
                        v-else-if="projetActuel.photos.length"
                        class="grid grid-cols-3 gap-2"
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
        </section>
    </main>
    <Footer></Footer>
</template>
