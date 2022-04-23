<template>
    <header class="bg-white shadow" v-if="$slots.headerPage">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <slot name="headerPage"/>
        </div>
    </header>
</template>

<script setup>
</script>

<style scoped>

</style>
