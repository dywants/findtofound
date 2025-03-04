<template>
    <div>
        <label :for="props.id" class="block text-sm font-medium text-gray-700">
            {{ props.label }}
        </label>
        <div
            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors duration-300"
            :class="{ 'border-blue-500 bg-blue-50': isDragging }"
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="onDrop"
        >
            <div class="space-y-1 text-center w-full">
                <template v-if="selectedFile && selectedFile.value && previewUrl">
                    <!-- Prévisualisation pour les images -->
                    <div v-if="isImage" class="mb-4 max-h-60 overflow-hidden rounded-md border border-gray-200 bg-white">
                        <img :src="previewUrl" alt="Prévisualisation" class="mx-auto max-h-60 object-contain" />
                    </div>
                    <!-- Prévisualisation pour les PDFs -->
                    <div v-else-if="isPdf" class="mb-4 relative rounded-md border border-gray-200 p-2 bg-white">
                        <div class="bg-gray-50 p-4 rounded flex items-center justify-center">
                            <svg class="h-16 w-16 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M0 0h24v24H0z" fill="none"/>
                                <path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm12 6V9c0-.55-.45-1-1-1h-2v5h2c.55 0 1-.45 1-1zm-2-3h1v3h-1V9z"/>
                            </svg>
                        </div>
                        <div class="text-center mt-2">
                            <p class="text-sm font-medium text-gray-900">Document PDF</p>
                            <a :href="previewUrl" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
                                Ouvrir dans un nouvel onglet
                            </a>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                         viewBox="0 0 48 48" aria-hidden="true">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </template>
                <div class="flex flex-col sm:flex-row text-sm text-gray-600 justify-center">
                    <label
                        :for="props.id"
                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500"
                    >
                        <span>{{ selectedFile && selectedFile.value ? 'Changer de fichier' : 'Téléverser un fichier' }}</span>
                        <input
                            :id="props.id"
                            type="file"
                            class="sr-only"
                            @change="onChange"
                            :accept="props.accept"
                            :aria-describedby="`${props.id}-info`"
                        >
                    </label>
                    <p v-if="isDragging" class="pl-1 sm:mt-0">ou déposez le fichier ici</p>
                    <p v-else-if="!selectedFile || !selectedFile.value" class="pl-1 sm:mt-0">ou glissez-déposez</p>
                </div>
                <p :id="`${props.id}-info`" class="text-xs text-gray-500 text-center sm:text-left">
                    {{ props.formatInfo }}
                </p>
                <div v-if="selectedFile && selectedFile.value" class="mt-3 text-sm bg-blue-50 border border-blue-200 rounded-md p-2 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium text-blue-700">{{ selectedFile.value.name }}</span>
                    </div>
                    <button @click="clearSelection" class="p-1 hover:bg-blue-100 rounded-full transition-colors duration-200" title="Supprimer le fichier">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 hover:text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="props.error" class="text-red-500 text-sm mt-1">
            {{ props.error }}
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed, onBeforeUnmount } from 'vue';

// Props
const props = defineProps({
    id: {
        type: String,
        default: 'document-upload'
    },
    label: {
        type: String,
        default: 'Document à protéger'
    },
    accept: {
        type: String,
        default: '.pdf,.jpg,.jpeg,.png'
    },
    formatInfo: {
        type: String,
        default: 'PDF, PNG, JPG jusqu\'à 10MB'
    },
    error: {
        type: String,
        default: ''
    },
    modelValue: {
        type: [File, null],
        default: null
    }
});

// Emits
const emit = defineEmits(['update:modelValue', 'file-selected']);

// Reactive state
const isDragging = ref(false);
const selectedFile = ref(null);
const previewUrl = ref(null);

// Computed properties for file types
const isImage = computed(() => {
    if (!selectedFile.value) return false;
    return /\.(jpg|jpeg|png|gif|webp)$/i.test(selectedFile.value.name);
});

const isPdf = computed(() => {
    if (!selectedFile.value) return false;
    return /\.pdf$/i.test(selectedFile.value.name);
});

// Créer une URL pour la prévisualisation du fichier
const createPreviewUrl = (file) => {
    if (!file) return;

    // Si un prévisualisation précédente existe, on la révoque
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
    }

    // Création de l'URL pour prévisualiser l'image ou le PDF
    previewUrl.value = URL.createObjectURL(file);
};

// Initialiser selectedFile avec modelValue si présent
if (props.modelValue) {
    selectedFile.value = props.modelValue;
    createPreviewUrl(props.modelValue);
}

// Watch for prop changes
watch(() => props.modelValue, (newValue) => {
    selectedFile.value = newValue;
    if (newValue) {
        createPreviewUrl(newValue);
    } else {
        // Si on supprime le fichier, on révoque l'URL
        if (previewUrl.value) {
            URL.revokeObjectURL(previewUrl.value);
            previewUrl.value = null;
        }
    }
});

// Methods
const onChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        selectedFile.value = file;
        createPreviewUrl(file);
        emit('update:modelValue', file);
        emit('file-selected', file);
    }
};

const onDrop = (event) => {
    isDragging.value = false;
    const file = event.dataTransfer.files[0];
    if (file) {
        selectedFile.value = file;
        createPreviewUrl(file);
        emit('update:modelValue', file);
        emit('file-selected', file);
    }
};

const clearSelection = () => {
    // Révoquer l'URL de prévisualisation
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
        previewUrl.value = null;
    }

    selectedFile.value = null;
    emit('update:modelValue', null);

    // Reset le champ input
    if (document.querySelector(`#${props.id}`)) {
        document.querySelector(`#${props.id}`).value = '';
    }
};

// Nettoyer l'URL de prévisualisation lorsque le composant est détruit
onBeforeUnmount(() => {
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
    }
});
</script>

<style scoped>
.dragging {
    border-color: theme('colors.blue.500');
    background-color: theme('colors.blue.50');
}
</style>
