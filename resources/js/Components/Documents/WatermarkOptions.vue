<template>
    <div class="mt-4">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-medium text-gray-700">Options avancées</h3>
            <button
                type="button"
                @click="toggleOptions"
                class="text-sm text-blue-600 hover:text-blue-800 flex items-center"
            >
                <span v-if="showOptions">Masquer</span>
                <span v-else>Afficher</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 ml-1"
                    :class="{ 'transform rotate-180': showOptions }"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <div v-if="showOptions" class="bg-gray-50 rounded-lg p-4 border border-gray-200 space-y-4 animate-fade-in">
            <!-- Opacité du filigrane -->
            <div>
                <label for="opacity" class="block text-sm font-medium text-gray-700 mb-1">
                    Opacité du filigrane: {{ opacity * 100 }}%
                </label>
                <input
                    type="range"
                    id="opacity"
                    v-model="opacity"
                    min="0.1"
                    max="1"
                    step="0.05"
                    class="w-full h-2 bg-blue-100 rounded-lg appearance-none cursor-pointer"
                />
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>10%</span>
                    <span>50%</span>
                    <span>100%</span>
                </div>
            </div>

            <!-- Angle de rotation -->
            <div>
                <label for="rotation" class="block text-sm font-medium text-gray-700 mb-1">
                    Angle de rotation: {{ rotation }}°
                </label>
                <input
                    type="range"
                    id="rotation"
                    v-model="rotation"
                    min="0"
                    max="360"
                    step="5"
                    class="w-full h-2 bg-blue-100 rounded-lg appearance-none cursor-pointer"
                />
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>0°</span>
                    <span>180°</span>
                    <span>360°</span>
                </div>
            </div>

            <!-- Taille du texte -->
            <div>
                <label for="fontSize" class="block text-sm font-medium text-gray-700 mb-1">
                    Taille du texte
                </label>
                <select
                    id="fontSize"
                    v-model="fontSize"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    <option value="auto">Automatique (recommandé)</option>
                    <option value="small">Petit</option>
                    <option value="medium">Moyen</option>
                    <option value="large">Grand</option>
                    <option value="xlarge">Très grand</option>
                </select>
            </div>

            <!-- Répétition du filigrane -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="repetition"
                    v-model="repetition"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label for="repetition" class="ml-2 block text-sm text-gray-700">
                    Répéter le filigrane sur tout le document
                </label>
            </div>

            <!-- Position du filigrane (si pas de répétition) -->
            <div v-if="!repetition">
                <label for="position" class="block text-sm font-medium text-gray-700 mb-1">
                    Position du filigrane
                </label>
                <div class="grid grid-cols-3 gap-2 mt-1">
                    <button
                        type="button"
                        @click="position = 'top-left'"
                        :class="[
                            'p-2 border rounded flex items-center justify-center',
                            position === 'top-left'
                                ? 'bg-blue-100 border-blue-500 text-blue-700'
                                : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                        ]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 1v10h10V4H4z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M5 5h2v2H5V5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        @click="position = 'top-right'"
                        :class="[
                            'p-2 border rounded flex items-center justify-center',
                            position === 'top-right'
                                ? 'bg-blue-100 border-blue-500 text-blue-700'
                                : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                        ]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 1v10h10V4H4z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M13 5h2v2h-2V5z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        @click="position = 'center'"
                        :class="[
                            'p-2 border rounded flex items-center justify-center',
                            position === 'center'
                                ? 'bg-blue-100 border-blue-500 text-blue-700'
                                : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                        ]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 1v10h10V4H4z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        @click="position = 'bottom-left'"
                        :class="[
                            'p-2 border rounded flex items-center justify-center',
                            position === 'bottom-left'
                                ? 'bg-blue-100 border-blue-500 text-blue-700'
                                : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                        ]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 1v10h10V4H4z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M5 13h2v2H5v-2z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        @click="position = 'bottom-right'"
                        :class="[
                            'p-2 border rounded flex items-center justify-center',
                            position === 'bottom-right'
                                ? 'bg-blue-100 border-blue-500 text-blue-700'
                                : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                        ]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm1 1v10h10V4H4z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M13 13h2v2h-2v-2z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Prévisualisation du filigrane -->
            <div class="relative mt-4 h-32 border border-gray-300 rounded-md bg-white overflow-hidden">
                <div
                    class="absolute inset-0 flex items-center justify-center text-gray-500"
                    :style="{
                        opacity: opacity,
                        transform: `rotate(${rotation}deg)`,
                        fontSize: getFontSize()
                    }"
                >
                    <span class="font-bold">{{ modelValue }}</span>
                </div>
                <div class="absolute inset-0 bg-white opacity-5"></div>
                <div class="absolute bottom-2 right-2 text-xs text-gray-500">Aperçu</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true
    }
});

const emit = defineEmits(['update:options']);

// État local
const showOptions = ref(false);
const opacity = ref(0.2);
const rotation = ref(45);
const fontSize = ref('auto');
const repetition = ref(true);
const position = ref('center');

// Calcul de la taille de police pour la prévisualisation
const getFontSize = () => {
    switch (fontSize.value) {
        case 'small': return '12px';
        case 'medium': return '18px';
        case 'large': return '24px';
        case 'xlarge': return '32px';
        default: return '18px'; // auto pour la prévisualisation
    }
};

// Pour basculer l'affichage des options
const toggleOptions = () => {
    showOptions.value = !showOptions.value;
};

// Mettre à jour les options quand elles changent
watch([opacity, rotation, fontSize, repetition, position], () => {
    const options = {
        opacity: opacity.value,
        rotation: parseInt(rotation.value),
        fontSize: fontSize.value,
        repetition: repetition.value,
        position: position.value
    };

    emit('update:options', options);
}, { deep: true });
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Style pour les sliders */
input[type="range"] {
    -webkit-appearance: none;
    height: 6px;
    background: #e2e8f0;
    border-radius: 5px;
    background-image: linear-gradient(#3b82f6, #3b82f6);
    background-repeat: no-repeat;
}

input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    box-shadow: 0 0 2px 0 #555;
}

input[type="range"]::-moz-range-thumb {
    height: 16px;
    width: 16px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    box-shadow: 0 0 2px 0 #555;
    border: none;
}

/* Style pour les checkbox */
input[type="checkbox"] {
    cursor: pointer;
}
</style>
