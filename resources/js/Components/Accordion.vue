<template>
    <div>
        <h2>
            <button
                @click="toggleAccordion"
                class="flex justify-between items-center py-5 w-full font-medium text-left text-gray-900 rounded-t-xl border-b border-gray-200 dark:border-gray-700 dark:text-white"
                :aria-expanded="isOpen"
                :aria-controls="`collapse${uid}`"
            >
                <slot name="title" />
                <svg
                    class="w-4 h-4 shrink-0 transition-all duration-200 transform"
                    :class="{'rotate-180': isOpen, 'rotate-0': !isOpen}"
                    fill="none"
                    stroke="currentColor"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 10"
                    aria-hidden="true"
                >
                    <path d="M15 1.2l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </h2>

        <div
            v-show="isOpen"
            :id="`collapse${uid}`"
            class="p-5"
        >
            <slot name="content" />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const uid = Math.random().toString(36).substring(7);
const isOpen = ref(false);

const toggleAccordion = () => {
    isOpen.value = !isOpen.value;
};
</script>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>
