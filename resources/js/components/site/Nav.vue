<script setup>
import { ref } from 'vue';
const mobileOpen = ref(false);
</script>
<template>
    <!-- Mobile: full-width red background wrapper -->
    <div :class="mobileOpen ? 'bg-[#C42827]' : ''" class="md:bg-transparent">
        <div
            class="mx-auto flex h-[80px] w-full max-w-[1182px] items-center gap-0 px-4 md:h-[200px]"
        >
            <figure class="shrink-0 px-2 md:px-4">
                <a href="/">
                    <img
                        src="/storage/UtrailLimal.png"
                        alt="Utrail Limal Logo"
                        class="h-[60px] w-[60px] object-contain md:h-[139px] md:w-[139px]"
                    />
                </a>
            </figure>
            <!-- Desktop nav -->
            <nav
                class="hidden flex-1 items-center rounded-[4px] bg-[#C42827] px-6 text-[#F6F6F6] md:flex"
                style="height: 40px"
            >
                <ul
                    class="flex flex-row items-center gap-6 text-[16px] font-normal lg:gap-12 lg:text-[20px]"
                >
                    <li>
                        <a href="/" class="whitespace-nowrap hover:underline"
                            >Accueil</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Presentation"
                            class="whitespace-nowrap hover:underline"
                            >Histoire du club</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Equipe"
                            class="whitespace-nowrap hover:underline"
                            >L'équipe</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Projet"
                            class="whitespace-nowrap hover:underline"
                            >Projet de l'année</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Formation"
                            class="whitespace-nowrap hover:underline"
                            >U-Trail formation</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Contact"
                            class="whitespace-nowrap hover:underline"
                            >Contact</a
                        >
                    </li>
                </ul>
            </nav>
            <!-- Hamburger button (mobile) -->
            <button
                @click="mobileOpen = !mobileOpen"
                class="ml-auto flex flex-col justify-center gap-[5px] rounded-md p-2 md:hidden"
                aria-label="Menu"
            >
                <span class="block h-[2px] w-6 bg-[#F6F6F6]"></span>
                <span class="block h-[2px] w-6 bg-[#F6F6F6]"></span>
                <span class="block h-[2px] w-6 bg-[#F6F6F6]"></span>
            </button>
        </div>
    </div>
    <!-- Mobile dropdown menu -->
    <Transition name="slide-left">
        <nav
            v-if="mobileOpen"
            class="overflow-hidden bg-[#C42827] px-6 py-4 text-[#F6F6F6] md:hidden"
        >
            <ul class="flex flex-col gap-4 text-[18px] font-normal">
                <li>
                    <a href="/" class="hover:underline">Présentation</a>
                </li>
                <li>
                    <a href="/Presentation" class="hover:underline"
                        >Histoire du club</a
                    >
                </li>
                <li>
                    <a href="/Equipe" class="hover:underline">L'équipe</a>
                </li>
                <li>
                    <a href="/Projet" class="hover:underline"
                        >Projet de l'année</a
                    >
                </li>
                <li>
                    <a href="/Formation" class="hover:underline"
                        >U-Trail formation</a
                    >
                </li>
                <li>
                    <a href="/Contact" class="hover:underline">Contact</a>
                </li>
            </ul>
        </nav>
    </Transition>
</template>

<style scoped>
.slide-left-enter-active,
.slide-left-leave-active {
    transition: transform 0.3s ease;
}
.slide-left-enter-from,
.slide-left-leave-to {
    transform: translateX(100%);
}
</style>
