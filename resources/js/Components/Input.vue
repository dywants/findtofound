<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
    <input class="px-4 w-full border-2 py-2 rounded-md text-sm outline-none" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>
