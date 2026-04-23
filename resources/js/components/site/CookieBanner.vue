<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';

const visible = ref(false);

onMounted(() => {
    if (!localStorage.getItem('cookie_consent')) {
        visible.value = true;
    }
});

function accept() {
    localStorage.setItem('cookie_consent', 'accepted');
    visible.value = false;
}

function decline() {
    localStorage.setItem('cookie_consent', 'declined');
    visible.value = false;
}
</script>

<template>
    <Transition name="slide-up">
        <div
            v-if="visible"
            class="fixed right-0 bottom-0 left-0 z-50 bg-[#1e1e1e] text-[#f6f6f6] shadow-lg"
        >
            <div
                class="mx-auto flex max-w-[1182px] flex-col items-start gap-4 px-4 py-4 md:flex-row md:items-center md:justify-between"
            >
                <p class="text-sm">
                    Ce site utilise des cookies pour améliorer votre expérience.
                    En continuant à naviguer, vous acceptez leur utilisation.
                    <Link
                        href="/confidentialite"
                        class="underline hover:text-[#C42827]"
                    >
                        En savoir plus
                    </Link>
                </p>
                <div class="flex shrink-0 gap-3">
                    <button
                        @click="decline"
                        class="rounded border border-[#f6f6f6] px-4 py-2 text-sm hover:bg-white/10"
                    >
                        Refuser
                    </button>
                    <button
                        @click="accept"
                        class="rounded bg-[#C42827] px-4 py-2 text-sm text-white hover:bg-red-700"
                    >
                        Accepter
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.slide-up-enter-active,
.slide-up-leave-active {
    transition: transform 0.3s ease;
}
.slide-up-enter-from,
.slide-up-leave-to {
    transform: translateY(100%);
}
</style>
