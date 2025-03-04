<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>

                <!-- Boutons de filtrage et tri (futures fonctionnalités) -->
                <div class="flex space-x-2" v-if="enableSortFilter">
                    <select v-model="sortBy"
                            class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="date">Date</option>
                        <option value="name">Nom</option>
                        <option value="type">Type</option>
                    </select>
                </div>
            </div>

            <!-- Message de succès -->
            <div v-if="successMessage" class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>{{ successMessage }}</span>
            </div>

            <!-- Options d'affichage et de tri -->
            <div v-if="documents && documents.length > 0" class="flex justify-end items-center mb-4 space-x-3">
                <!-- Selecteur de tri -->
                <div class="flex items-center gap-2">
                    <label for="sort-select" class="text-sm text-gray-600">Trier par:</label>
                    <select id="sort-select" v-model="sortBy"
                            class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="date">Date</option>
                        <option value="name">Nom</option>
                        <option value="type">Type</option>
                    </select>
                </div>

                <!-- Bouton d'affichage liste/grille -->
                <button @click="toggleDisplayType" class="text-sm text-gray-600 flex items-center hover:text-blue-600 transition-colors duration-300 p-1 rounded hover:bg-gray-100">
                    <svg v-if="displayType === 'list'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span>{{ displayType === 'list' ? 'Grille' : 'Liste' }}</span>
                </button>
            </div>

            <!-- Liste ou Grille de documents -->
            <div v-if="documents && documents.length > 0">
                <div v-if="displayType === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <document-card
                        v-for="doc in sortedDocuments"
                        :key="doc.id"
                        :document="doc"
                        @download="$emit('download', doc)"
                        @delete="$emit('delete', doc)"
                        class="h-full"
                    />
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Document
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Utilisation
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="doc in sortedDocuments" :key="doc.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ doc.original_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ doc.purpose }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ formatDate(doc.created_at) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button @click="$emit('download', doc)"
                                        class="text-blue-600 hover:text-blue-900 mr-4 inline-flex items-center transition duration-300 hover:scale-105 p-1 rounded-md hover:bg-blue-50 focus:outline-none focus:ring focus:ring-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>Télécharger</span>
                                </button>
                                <button @click="confirmDelete(doc)"
                                        class="text-red-600 hover:text-red-900 inline-flex items-center transition duration-300 hover:scale-105 p-1 rounded-md hover:bg-red-50 focus:outline-none focus:ring focus:ring-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Supprimer</span>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Message si aucun document -->
            <div v-else class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-gray-500">Aucun document protégé pour le moment</p>
                <p class="text-sm text-gray-400 mt-1">Utilisez le formulaire ci-dessus pour protéger vos documents</p>
            </div>

            <!-- Bouton pour basculer l'affichage (future fonctionnalité) -->
            <div v-if="documents && documents.length && enableDisplayToggle" class="mt-4 flex justify-end">
                <button @click="toggleDisplayType" class="text-sm text-gray-500 flex items-center hover:text-blue-600 transition-colors duration-300">
                    <svg v-if="displayType === 'list'" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span>{{ displayType === 'list' ? 'Afficher en grille' : 'Afficher en liste' }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import DocumentCard from './DocumentCard.vue';

// Props
const props = defineProps({
    documents: {
        type: Array,
        default: () => []
    },
    successMessage: {
        type: String,
        default: ''
    },
    title: {
        type: String,
        default: 'Mes documents protégés'
    },
    enableSortFilter: {
        type: Boolean,
        default: true
    },
    enableDisplayToggle: {
        type: Boolean,
        default: true
    }
});

// Emits
const emit = defineEmits(['download', 'delete']);

// Reactive state
const displayType = ref('grid'); // 'list' ou 'grid'
const sortBy = ref('date'); // 'date', 'name', ou 'type'

// Computed
const sortedDocuments = computed(() => {
    if (!props.documents || !props.documents.length) return [];

    return [...props.documents].sort((a, b) => {
        if (sortBy.value === 'date') {
            return new Date(b.created_at) - new Date(a.created_at);
        } else if (sortBy.value === 'name') {
            return a.original_name.localeCompare(b.original_name);
        } else if (sortBy.value === 'type') {
            const extA = a.original_name.split('.').pop().toLowerCase();
            const extB = b.original_name.split('.').pop().toLowerCase();
            return extA.localeCompare(extB);
        }
        return 0;
    });
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

const toggleDisplayType = () => {
    displayType.value = displayType.value === 'list' ? 'grid' : 'list';
};

const confirmDelete = (doc) => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer "${doc.original_name}" ?`)) {
        emit('delete', doc);
    }
};
</script>
