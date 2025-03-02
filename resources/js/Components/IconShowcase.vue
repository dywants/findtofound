<template>
    <div class="icon-showcase">
        <h2 class="heading-3 mb-6">Système d'icônes</h2>
        
        <section class="mb-8 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <h3 class="heading-4 mb-4">Icônes outline</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                <div v-for="name in iconNames" :key="`outline-${name}`" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <Icon :name="name" size="24" class="mb-2" />
                    <span class="text-xs text-gray-600">{{ name }}</span>
                </div>
            </div>
        </section>
        
        <section class="mb-8 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <h3 class="heading-4 mb-4">Icônes solid</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                <div v-for="name in iconNames" :key="`solid-${name}`" class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <Icon :name="name" size="24" solid class="mb-2" />
                    <span class="text-xs text-gray-600">{{ name }}</span>
                </div>
            </div>
        </section>
        
        <section class="mb-8 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <h3 class="heading-4 mb-4">Variations de taille</h3>
            <div class="flex flex-wrap items-end justify-center gap-6">
                <div v-for="size in [16, 24, 32, 48]" :key="`size-${size}`" class="flex flex-col items-center">
                    <Icon name="document" :size="size" class="mb-2" />
                    <span class="text-xs text-gray-600">{{ size }}px</span>
                </div>
            </div>
        </section>
        
        <section class="mb-8 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <h3 class="heading-4 mb-4">Variations de couleur</h3>
            <div class="flex flex-wrap justify-center gap-6">
                <div v-for="color in colors" :key="`color-${color.name}`" class="flex flex-col items-center">
                    <Icon name="bell" size="24" :customClass="`text-${color.class}`" class="mb-2" />
                    <span class="text-xs text-gray-600">{{ color.name }}</span>
                </div>
            </div>
        </section>
        
        <section class="mb-8 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <h3 class="heading-4 mb-4">Animations</h3>
            <div class="flex flex-wrap justify-center gap-6">
                <div class="flex flex-col items-center">
                    <Icon name="search" size="24" customClass="spin" class="mb-2" />
                    <span class="text-xs text-gray-600">Rotation</span>
                </div>
                <div class="flex flex-col items-center">
                    <Icon name="map-pin" size="24" customClass="pulse" class="mb-2" />
                    <span class="text-xs text-gray-600">Pulse</span>
                </div>
            </div>
        </section>
        
        <section class="mb-8 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <h3 class="heading-4 mb-4">Utilisation dans des boutons</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="button primary with-icon icon-left">
                    <Icon name="document" size="20" />
                    Nouveau document
                </button>
                <button class="button secondary with-icon icon-right">
                    Rechercher
                    <Icon name="search" size="20" />
                </button>
                <button class="button accent with-icon circle">
                    <Icon name="bell" size="20" />
                </button>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Icon from './Icon.vue';
import { iconNames } from '../Icons/index.js';

const colors = ref([
    { name: 'Primary', class: 'primary-600' },
    { name: 'Secondary', class: 'secondary-600' },
    { name: 'Accent', class: 'accent-600' },
    { name: 'Success', class: 'success-500' },
    { name: 'Warning', class: 'warning-500' },
    { name: 'Error', class: 'error-500' },
]);
</script>

<style scoped>
.icon-showcase section {
    border: 1px solid #e5e7eb;
}
</style>
