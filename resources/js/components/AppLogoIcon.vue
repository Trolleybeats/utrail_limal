<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <figure>
        <img
            src="/storage/Logo.png"
            alt="U-Trail Limal Logo"
            class="size-10 fill-current text-white dark:text-black"
            :class="className"
        />
    </figure>
</template>
