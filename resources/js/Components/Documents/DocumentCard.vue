<template>
    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-all duration-300 group hover:border-blue-200">
        <!-- Badge de type de fichier (en absolu) -->
        <div class="absolute top-2 right-2 z-10">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium shadow-sm"
                  :class="{
                    'bg-blue-100 text-blue-800': getFileType(props.document.original_name) === 'PDF',
                    'bg-green-100 text-green-800': isImage,
                    'bg-purple-100 text-purple-800': !isImage && getFileType(props.document.original_name) !== 'PDF'
                  }">
                {{ getFileType(props.document.original_name) }}
            </span>
        </div>

        <!-- Miniature du document -->
        <div class="h-40 bg-gray-100 relative overflow-hidden border-b border-gray-200 flex items-center justify-center">
            <!-- Image pour les fichiers images -->
            <img v-if="isImage && thumbnailUrl"
                 :src="thumbnailUrl"
                 :alt="props.document.original_name"
                 class="h-full w-full object-contain" />

            <!-- Aperçu pour les PDF -->
            <div v-else-if="getFileType(props.document.original_name) === 'PDF'" class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-red-500 mb-1" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M128 0c-17.6 0-32 14.4-32 32v448c0 17.6 14.4 32 32 32h320c17.6 0 32-14.4 32-32V128L352 0H128z"/>
                    <path fill="#FFF" d="M384 128h96L352 0v96c0 17.6 14.4 32 32 32z"/>
                    <path fill="#FFF" d="M271.5 272h-23c-5.5 0-10-4.5-10-10s4.5-10 10-10h43c5.5 0 10-4.5 10-10s-4.5-10-10-10h-43c-16.5 0-30 13.5-30 30s13.5 30 30 30h23c5.5 0 10 4.5 10 10s-4.5 10-10 10h-43c-5.5 0-10 4.5-10 10s4.5 10 10 10h43c16.5 0 30-13.5 30-30s-13.5-30-30-30z"/>
                </svg>
                <p class="text-xs text-gray-700 font-medium">{{ props.document.original_name }}</p>
            </div>

            <!-- Icône générique pour les autres types de fichiers -->
            <div v-else class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-blue-500 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-xs text-gray-700 font-medium">{{ props.document.original_name }}</p>
            </div>
        </div>

        <!-- En-tête du document -->
        <div class="relative p-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-sky-50 group-hover:from-blue-100 group-hover:to-sky-100 transition-colors duration-300">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-medium text-gray-900 truncate" :title="props.document.original_name">
                    {{ props.document.original_name }}
                </h3>
            </div>

            <div class="mt-1 flex items-center text-xs text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ formatDate(props.document.created_at) }}</span>
            </div>
        </div>

        <!-- Corps avec informations sur le document -->
        <div class="p-4 pt-3">
            <!-- But du document -->
            <div class="mb-3">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-blue-500 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-gray-700">
                        {{ props.document.purpose }}
                    </p>
                </div>
            </div>

            <!-- Filigrane -->
            <div class="mb-4">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-blue-500 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-xs text-gray-600 italic">
                        Filigrane: "{{ props.document.watermark_text }}"
                    </p>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-4 flex items-center justify-between pt-2 border-t border-gray-100">
                <button @click="emit('download', props.document)"
                        class="text-blue-600 hover:text-blue-900 inline-flex items-center transition duration-300 hover:scale-105 px-2 py-1 rounded-md hover:bg-blue-50 focus:outline-none focus:ring focus:ring-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span class="text-xs font-medium">Télécharger</span>
                </button>

                <button @click="confirmDelete"
                        class="text-red-600 hover:text-red-900 inline-flex items-center transition duration-300 hover:scale-105 px-2 py-1 rounded-md hover:bg-red-50 focus:outline-none focus:ring focus:ring-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span class="text-xs font-medium">Supprimer</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

// Props
const props = defineProps({
    document: {
        type: Object,
        required: true
    }
});

// Emits
const emit = defineEmits(['download', 'delete']);

// État réactif
const thumbnailUrl = ref(null);

// Computed properties
const isImage = computed(() => {
    if (!props.document.original_name) return false;

    const extension = props.document.original_name.split('.').pop().toLowerCase();
    return ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'].includes(extension);
});

// Methods
const formatDate = (date) => {
    if (!date) return '';

    // Format the date in French locale
    return new Date(date).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getFileType = (filename) => {
    if (!filename) return 'Fichier';

    const extension = filename.split('.').pop().toLowerCase();

    switch (extension) {
        case 'pdf':
            return 'PDF';
        case 'jpg':
        case 'jpeg':
            return 'JPEG';
        case 'png':
            return 'PNG';
        case 'gif':
            return 'GIF';
        case 'webp':
            return 'WebP';
        case 'doc':
        case 'docx':
            return 'Word';
        case 'xls':
        case 'xlsx':
            return 'Excel';
        case 'ppt':
        case 'pptx':
            return 'PowerPoint';
        default:
            return 'Fichier';
    }
};

const confirmDelete = () => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer "${props.document.original_name}" ?`)) {
        emit('delete', props.document);
    }
};

// Générer l'URL de la miniature pour les images
const generateThumbnail = () => {
    if (isImage.value && props.document.download_url) {
        // Utiliser l'URL de téléchargement directement pour l'aperçu
        thumbnailUrl.value = props.document.download_url;
    }
};

// Lifecycle hooks
onMounted(() => {
    generateThumbnail();
});

onBeforeUnmount(() => {
    // Nettoyer les URL d'objets si nécessaire
    if (thumbnailUrl.value && thumbnailUrl.value.startsWith('blob:')) {
        URL.revokeObjectURL(thumbnailUrl.value);
    }
});
</script>

<style scoped>
/* Ajout d'une transition douce sur les images */
img {
    transition: transform 0.3s ease;
}

/* Effet de zoom léger au survol */
.group:hover img {
    transform: scale(1.05);
}
</style>
