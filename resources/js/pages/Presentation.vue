<script setup>
import Nav from '@/components/site/Nav.vue';
import Footer from '@/components/site/Footer.vue';
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
        <div class="mx-auto w-full max-w-[1182px] px-4 py-8 md:py-14">
            <h2
                class="mb-6 text-center text-2xl font-bold text-[#B3A96F] sm:text-3xl md:mb-8 md:text-4xl lg:text-[48px]"
            >
                Nos projets réalisés
            </h2>
        </div>
    </main>
    <Footer />
</template>
