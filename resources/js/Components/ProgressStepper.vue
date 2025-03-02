<template>
    <div class="flex items-center space-x-4">
        <div v-for="(step, index) in steps" :key="index" class="flex items-center">
            <!-- Indicateur d'étape avec animation et icône -->
            <div 
                class="w-10 h-10 rounded-full flex items-center justify-center transform transition-all duration-300 shadow-md"
                :class="{
                    'bg-blue-600 text-white scale-110': currentStep >= step.number,
                    'bg-gray-200 text-gray-600': currentStep < step.number
                }"
            >
                <!-- Icône ou numéro selon l'étape -->
                <template v-if="currentStep > step.number">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </template>
                <template v-else-if="currentStep === step.number">
                    <span class="flex items-center justify-center">
                        <span>{{ step.number }}</span>
                        <!-- Animation pulse pour l'étape active -->
                        <span v-if="currentStep === step.number" class="absolute w-10 h-10 rounded-full animate-ping bg-blue-400 opacity-50"></span>
                    </span>
                </template>
                <template v-else>
                    <span>{{ step.number }}</span>
                </template>
            </div>
            
            <!-- Label d'étape avec transitions -->
            <div class="ml-2">
                <p 
                    class="text-sm font-medium transition-all duration-300" 
                    :class="{
                        'text-blue-600 font-semibold': currentStep === step.number,
                        'text-gray-900': currentStep > step.number,
                        'text-gray-500': currentStep < step.number
                    }"
                >
                    {{ step.label }}
                    <!-- Indicateur sous le texte pour montrer l'étape active -->
                    <span 
                        v-if="currentStep === step.number" 
                        class="block h-0.5 bg-blue-600 mt-0.5 transform transition-all duration-300"
                    ></span>
                </p>
            </div>
            
            <!-- Ligne de connexion avec animation -->
            <div 
                v-if="index < steps.length - 1" 
                class="relative w-16 h-0.5 ml-4 transition-all duration-500" 
            >
                <!-- Arrière-plan de la ligne -->
                <div class="absolute inset-0 bg-gray-200"></div>
                <!-- Ligne de progression avec animation -->
                <div 
                    class="absolute inset-0 bg-blue-600 transition-all duration-500"
                    :style="{
                        transform: currentStep > step.number ? 'scaleX(1)' : 'scaleX(0)',
                        transformOrigin: 'left'
                    }"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    steps: {
        type: Array,
        required: true,
        // Format attendu: [{ number: 1, label: 'Étape 1' }, ...]
    },
    currentStep: {
        type: Number,
        required: true
    }
});
</script>
