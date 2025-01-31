<template>
    <div class="app">
        <TheNavAdmin />
        <Aside/>
        <main class="section main-section">
            <slot/>
        </main>
    </div>
</template>

<script setup>
import Aside from "./Admin/Aside.vue";
import TheNavAdmin from "./Admin/TheNavAdmin.vue";
import {ref} from "vue";

const showingNavigationDropdown = ref(false);
</script>

<style scoped>
.app {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
</style>
