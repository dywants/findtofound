<script setup>
import { computed } from 'vue';

const props = defineProps({
    errors: {
        type: Object,
        default: () => ({})
    }
});

const hasErrors = computed(() => Object.keys(props.errors || {}).length > 0);
</script>

<template>
    <div v-if="hasErrors" class="border p-4 border-gray-50 shadow rounded-md">
        <div class="font-medium text-red-600">Whoops! Something went wrong.</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in props.errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>
