<script setup lang="ts">
import { ref, nextTick, onMounted, onUnmounted, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const currentUrl = computed(() => page.url.split('?')[0]);
function isCurrentPage(path: string): boolean {
    return currentUrl.value === path;
}

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

    <!-- Header bar -->
    <div class="md:bg-transparent">
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
                        <a
                            href="/"
                            :aria-current="
                                isCurrentPage('/') ? 'page' : undefined
                            "
                            class="whitespace-nowrap hover:underline"
                            >Accueil</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Presentation"
                            :aria-current="
                                isCurrentPage('/Presentation')
                                    ? 'page'
                                    : undefined
                            "
                            class="whitespace-nowrap hover:underline"
                            >Histoire du club</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Equipe"
                            :aria-current="
                                isCurrentPage('/Equipe') ? 'page' : undefined
                            "
                            class="whitespace-nowrap hover:underline"
                            >L'équipe</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Projet"
                            :aria-current="
                                isCurrentPage('/Projet') ? 'page' : undefined
                            "
                            class="whitespace-nowrap hover:underline"
                            >Projet de l'année</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Formation"
                            :aria-current="
                                isCurrentPage('/Formation') ? 'page' : undefined
                            "
                            class="whitespace-nowrap hover:underline"
                            >U-Trail formation</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Contact"
                            :aria-current="
                                isCurrentPage('/Contact') ? 'page' : undefined
                            "
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
                aria-label="Ouvrir le menu"
            >
                <span class="block h-[2px] w-6 bg-[#F6F6F6]"></span>
                <span class="block h-[2px] w-6 bg-[#F6F6F6]"></span>
                <span class="block h-[2px] w-6 bg-[#F6F6F6]"></span>
            </button>
        </div>
    </div>

    <!-- Mobile panel : figure + nav glissant depuis la droite -->
    <Transition name="slide-from-right">
        <div
            v-if="mobileOpen"
            id="mobile-menu"
            ref="mobileMenuRef"
            class="fixed inset-0 z-50 flex flex-col bg-[#C42827] text-[#F6F6F6] md:hidden"
            @keydown="handleMobileKeydown"
        >
            <!-- Ligne du haut : logo + bouton fermer -->
            <div
                class="mx-auto flex h-[80px] w-full max-w-[1182px] items-center px-4"
            >
                <figure class="shrink-0 px-2">
                    <a href="/">
                        <img
                            src="/storage/UtrailLimal.png"
                            alt="Utrail Limal Logo"
                            class="h-[60px] w-[60px] object-contain"
                        />
                    </a>
                </figure>
                <button
                    @click="closeMenu"
                    class="ml-auto rounded-md p-2"
                    aria-label="Fermer le menu"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <!-- Liens de navigation -->
            <nav aria-label="Navigation mobile" class="px-6 py-4">
                <ul class="flex flex-col gap-4 text-[18px] font-normal">
                    <li>
                        <a
                            href="/"
                            :aria-current="
                                isCurrentPage('/') ? 'page' : undefined
                            "
                            class="hover:underline"
                            >Accueil</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Presentation"
                            :aria-current="
                                isCurrentPage('/Presentation')
                                    ? 'page'
                                    : undefined
                            "
                            class="hover:underline"
                            >Histoire du club</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Equipe"
                            :aria-current="
                                isCurrentPage('/Equipe') ? 'page' : undefined
                            "
                            class="hover:underline"
                            >L'équipe</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Projet"
                            :aria-current="
                                isCurrentPage('/Projet') ? 'page' : undefined
                            "
                            class="hover:underline"
                            >Projet de l'année</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Formation"
                            :aria-current="
                                isCurrentPage('/Formation') ? 'page' : undefined
                            "
                            class="hover:underline"
                            >U-Trail formation</a
                        >
                    </li>
                    <li>
                        <a
                            href="/Contact"
                            :aria-current="
                                isCurrentPage('/Contact') ? 'page' : undefined
                            "
                            class="hover:underline"
                            >Contact</a
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </Transition>
</template>

<style scoped>
a[aria-current='page'] {
    font-weight: 600;
    text-decoration: underline;
}
.slide-from-right-enter-active,
.slide-from-right-leave-active {
    transition: transform 0.35s ease;
}
.slide-from-right-enter-from,
.slide-from-right-leave-to {
    transform: translateX(100%);
}
</style>
