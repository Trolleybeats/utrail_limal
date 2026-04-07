<script setup lang="ts">
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
</script>

<template>
    <header class="relative h-[920px] w-full">
        <video
            autoplay
            muted
            loop
            class="absolute top-0 left-0 h-[920px] w-full object-cover"
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
                class="w-72"
            />
        </figure>
        <h1
            class="absolute top-[75%] left-1/2 -translate-x-1/2 -translate-y-1/2 transform text-center text-[32px] font-bold text-[#F6F6F6]"
        >
            Prêts à relever un nouveau défi ?
        </h1>
        <button
            class="absolute top-[82%] left-1/2 h-[58px] w-[305px] -translate-x-1/2 -translate-y-1/2 transform rounded bg-[#C42827] px-4 py-2 text-[24px] text-[#F6F6F6]"
        >
            Intégrer le projet 2026
        </button>
    </header>
    <main>
        <section id="shortpres">
            <div class="mx-auto w-[1182px] py-16">
                <h2
                    class="mb-8 text-center text-[48px] font-bold text-[#B3A96F]"
                >
                    U-Trail Limal c'est quoi ?
                </h2>
                <p class="text-[20px] text-[#1A1A1A]">
                    Le trail, c’est bien plus qu’une simple course en pleine
                    nature.
                </p>
                <p class="mt-4 text-[20px] text-[#1A1A1A]">
                    C’est une discipline d’endurance qui allie course à pied et
                    exploration de terrains variés : sentiers escarpés,
                    montagnes, forêts, vallées, parfois même neige ou rochers.
                </p>
                <p class="mt-4 text-[20px] text-[#1A1AA]">
                    Chaque parcours raconte une histoire différente, façonnée
                    par le relief, les conditions météo et des paysages souvent
                    spectaculaires.
                </p>
                <p class="mt-4 text-[20px] text-[#1A1A1A]">
                    Mais au-delà de la performance, le trail est avant tout une
                    aventure, à la fois physique et mentale. On y apprend à
                    gérer son effort, à écouter son corps, à s’adapter et
                    surtout à profiter pleinement de chaque instant, au cœur
                    d’une nature préservée.
                </p>
            </div>
        </section>
        <section id="sponsor"></section>
        <section id="fondation"></section>
        <!-- <section id="projet">Faire un components pour ajout via CMS</section> -->
    </main>
    <Footer></Footer>
</template>
