<script setup lang="ts">
import { ref, nextTick, onMounted, onUnmounted } from 'vue';

const mobileOpen = ref(false);
const hamburgerBtn = ref<HTMLButtonElement | null>(null);
const mobileMenuRef = ref<HTMLElement | null>(null);

async function openMenu() {
    mobileOpen.value = true;
    await nextTick();
    const first = mobileMenuRef.value?.querySelector<HTMLElement>(
        'a, button, [tabindex]',
    );
    first?.focus();
}

function closeMenu() {
    mobileOpen.value = false;
    hamburgerBtn.value?.focus();
}

function toggleMenu() {
    if (mobileOpen.value) {
        closeMenu();
    } else {
        openMenu();
    }
}

function handleMobileKeydown(e: KeyboardEvent) {
    if (e.key === 'Escape') {
        closeMenu();
        return;
    }
    if (e.key !== 'Tab') return;

    const focusable = [
        ...(mobileMenuRef.value?.querySelectorAll<HTMLElement>(
            'a, button, [tabindex]',
        ) ?? []),
    ];
    if (focusable.length === 0) return;

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (e.shiftKey) {
        if (document.activeElement === first) {
            e.preventDefault();
            last.focus();
        }
    } else {
        if (document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    }
}

function handleGlobalKeydown(e: KeyboardEvent) {
    if (e.key === 'Escape' && mobileOpen.value) {
        closeMenu();
    }
}

onMounted(() => document.addEventListener('keydown', handleGlobalKeydown));
onUnmounted(() => document.removeEventListener('keydown', handleGlobalKeydown));

defineExpose({ mobileOpen });
</script>
<template>
    <!-- Skip to main content link (visible on focus) -->
    <a
        href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:rounded focus:bg-white focus:px-4 focus:py-2 focus:text-[#C42827] focus:underline focus:shadow-lg"
    >
        Aller au contenu principal
    </a>

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
                aria-label="Navigation principale"
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
                ref="hamburgerBtn"
                @click="toggleMenu"
                class="ml-auto flex flex-col justify-center gap-[5px] rounded-md p-2 md:hidden"
                :aria-expanded="mobileOpen"
                aria-controls="mobile-menu"
                :aria-label="mobileOpen ? 'Fermer le menu' : 'Ouvrir le menu'"
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
            id="mobile-menu"
            ref="mobileMenuRef"
            aria-label="Navigation mobile"
            class="overflow-hidden bg-[#C42827] px-6 py-4 text-[#F6F6F6] md:hidden"
            @keydown="handleMobileKeydown"
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
