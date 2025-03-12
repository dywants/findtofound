<template>

    <Head title="Admin - Pièces Retrouvées" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center">
                    <Link :href="route('admin.index')" class="text-gray-400 hover:text-blue-500 text-sm flex items-center transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </Link>
                    <span class="text-gray-400 mx-2">/</span>
                    <span class="text-blue-500 text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Pièces Retrouvées
                    </span>
                </div>
                <div class="hidden md:flex items-center">
                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center">
                        <span class="mr-1 font-bold">+</span>
                        Nouvelle pièce
                    </button>
                </div>
            </div>
        </template>
    </HeaderAdmin>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Card 1: Total Pièces -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-blue-500 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pièces</p>
                        <p class="text-xl font-bold">{{ finds ? finds.length : 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Trouvées -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-green-500 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Trouvées</p>
                        <p class="text-xl font-bold">{{ finds ? finds.filter(find => find.approval_status === 1).length : 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: En attente -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-amber-500 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">En attente</p>
                        <p class="text-xl font-bold">{{ finds ? finds.filter(find => find.approval_status === 0).length : 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Card 4: Montant total -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-purple-500 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Montant total</p>
                        <p class="text-xl font-bold">{{ totalAmount }} EUR</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-3 mb-6">
            <!-- Recherche -->
            <div class="w-full md:w-1/2 lg:w-1/3 relative">
                <input type="text" v-model="search" placeholder="Rechercher par nom, ville, type..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-gray-600 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <!-- Filtre Status -->
                <div class="relative w-full md:w-auto">
                    <select v-model="statusFilter"
                        class="appearance-none border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 pr-8">
                        <option value="all">Tous les statuts</option>
                        <option value="1">Retrouvée</option>
                        <option value="0">En attente</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                
                <!-- Filtre Ville -->
                <div class="relative w-full md:w-auto">
                    <select v-model="cityFilter"
                        class="appearance-none border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-600 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 pr-8">
                        <option value="all">Toutes les villes</option>
                        <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                
                <!-- Bouton Filtrer -->
                <button
                    class="bg-blue-500 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-blue-600 transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filtrer
                </button>
            </div>
        </div>
        
        <!-- Quick Filters -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button @click="cityFilter = 'all'; statusFilter = 'all'"
                :class="{'bg-blue-100 text-blue-600': cityFilter === 'all' && statusFilter === 'all', 'bg-gray-100 text-gray-600': !(cityFilter === 'all' && statusFilter === 'all')}"
                class="px-3 py-1 rounded-md text-sm font-medium transition-colors hover:bg-gray-200">
                Tous
            </button>
            <button @click="statusFilter = '1'"
                :class="{'bg-green-100 text-green-600': statusFilter === '1', 'bg-gray-100 text-gray-600': statusFilter !== '1'}"
                class="px-3 py-1 rounded-md text-sm font-medium transition-colors hover:bg-gray-200">
                Retrouvées
            </button>
            <button @click="statusFilter = '0'"
                :class="{'bg-amber-100 text-amber-600': statusFilter === '0', 'bg-gray-100 text-gray-600': statusFilter !== '0'}"
                class="px-3 py-1 rounded-md text-sm font-medium transition-colors hover:bg-gray-200">
                En attente
            </button>
        </div>
        <!-- Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 mb-6">
            <div class="p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Liste des Pièces
                    </h2>
                    <div class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ filteredFinds.length }} résultats</div>
                </div>

                <!-- Table content -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Photo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Information</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Statut</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="find in paginatedFinds" :key="find.id"
                                class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3">
                                    <div class="h-12 w-12 cursor-pointer" @click="openImage(find.photos)">
                                        <img class="h-12 w-12 rounded-md object-cover border border-gray-200"
                                            :src="showImage(find.photos)" alt="Image de la pièce">
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 mb-1">{{ find.fullName }}</div>
                                    <div class="text-xs text-gray-500 flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ find.findCity }}, {{ find.ward }}
                                    </div>
                                    <div class="text-xs text-gray-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ find.piece.name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span
                                        :class="find.approval_status ? 'bg-green-100 text-green-600 border border-green-200' : 'bg-amber-100 text-amber-600 border border-amber-200'"
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-medium rounded-md">
                                        {{ find.approval_status ? 'Retrouvée' : 'En attente' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ formatDateFR(find.created_at) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <button @click="viewDetails(find)"
                                            class="text-blue-500 hover:text-blue-700 transition-colors duration-200 p-1 rounded-md hover:bg-blue-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button @click="confirmDelete(find)"
                                            class="text-red-500 hover:text-red-700 transition-colors duration-200 p-1 rounded-md hover:bg-red-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between border-t border-gray-200 px-4 py-3 gap-3">
                <div class="text-sm text-gray-500 bg-gray-50 px-2 py-1 rounded-md inline-flex">
                    {{ paginatedFinds.length }} sur {{ filteredFinds.length }} résultats
                </div>
                <div class="flex items-center space-x-1">
                    <button 
                        :class="currentPage === 1 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex items-center px-2 py-1 text-sm rounded-md transition-colors"
                        :disabled="currentPage === 1" 
                        @click="currentPage--">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Précédent
                    </button>
                    
                    <div class="hidden sm:flex space-x-1">
                        <button 
                            v-for="page in totalPages" 
                            :key="page" 
                            class="w-8 h-8 flex items-center justify-center text-sm rounded-md transition-colors"
                            :class="currentPage === page ? 'bg-blue-500 text-white' : 'text-gray-600 hover:bg-gray-100'"
                            @click="currentPage = page">
                            {{ page }}
                        </button>
                    </div>
                    
                    <div class="sm:hidden text-sm text-gray-500 px-2">
                        Page {{ currentPage }} sur {{ totalPages }}
                    </div>
                    
                    <button 
                        :class="currentPage === totalPages ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-100'"
                        class="flex items-center px-2 py-1 text-sm rounded-md transition-colors"
                        :disabled="currentPage === totalPages" 
                        @click="currentPage++">
                        Suivant
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div v-if="showImageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
        <div class="relative max-w-4xl w-full mx-auto" @click.stop>
            <div class="relative bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Modal header -->
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800">Image de la pièce</h3>
                    <button @click="showImageModal = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 flex items-center justify-center bg-gray-50">
                    <img :src="selectedImage" class="max-w-full max-h-[70vh] object-contain" alt="Image de la pièce">
                </div>
                <!-- Modal footer -->
                <div class="px-4 py-3 border-t border-gray-200 flex justify-end">
                    <button @click="showImageModal = false" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 text-sm font-medium transition-colors">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
        <!-- Overlay click to close -->
        <div class="absolute inset-0 z-[-1]" @click="showImageModal = false"></div>
    </div>
</template>
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import AdminLayout from "@/Layouts/AdminLayout";
import { ref, computed } from 'vue';

const props = defineProps({
    finds: {
        type: Array,
        default: () => []
    }
});

// État local
const search = ref('');
const statusFilter = ref('all');
const cityFilter = ref('all');
const currentPage = ref(1);
const itemsPerPage = 10;
const showImageModal = ref(false);
const selectedImage = ref('');

// Computed properties
const cities = computed(() => {
    if (!props.finds) return [];
    return [...new Set(props.finds.map(find => find.findCity))];
});

const totalAmount = computed(() => {
    if (!props.finds) return 0;
    return props.finds.reduce((sum, find) => sum + (parseInt(find.amount_check) || 0), 0);
});

const filteredFinds = computed(() => {
    if (!props.finds) return [];
    let filtered = props.finds;

    // Filtre de recherche
    if (search.value) {
        const searchLower = search.value.toLowerCase();
        filtered = filtered.filter(find =>
            find.fullName.toLowerCase().includes(searchLower) ||
            find.findCity.toLowerCase().includes(searchLower) ||
            find.ward.toLowerCase().includes(searchLower) ||
            find.piece.name.toLowerCase().includes(searchLower)
        );
    }

    // Filtre par statut
    if (statusFilter.value !== 'all') {
        filtered = filtered.filter(find =>
            find.approval_status === parseInt(statusFilter.value)
        );
    }

    // Filtre par ville
    if (cityFilter.value !== 'all') {
        filtered = filtered.filter(find =>
            find.findCity === cityFilter.value
        );
    }

    return filtered;
});

const totalPages = computed(() => {
    return Math.ceil(filteredFinds.value.length / itemsPerPage);
});

const paginatedFinds = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredFinds.value.slice(start, end);
});

// Méthodes
const showImage = (photos) => {
    try {
        // Vérifier si photos est déjà un tableau ou un objet
        if (!photos) {
            return '/storage/findImages/default-image.jpg'; // image par défaut
        }

        let photoArray;

        if (typeof photos === 'string') {
            // Tentative de parsing de la chaîne JSON
            try {
                photoArray = JSON.parse(photos);
            } catch (jsonError) {
                // Si c'est une chaîne simple (non-JSON), considérer comme un nom de fichier unique
                console.log('Format de photo simple:', photos);
                return `/storage/findImages/${photos}`;
            }
        } else if (Array.isArray(photos)) {
            // Si photos est déjà un tableau
            photoArray = photos;
        } else if (typeof photos === 'object') {
            // Si photos est déjà un objet
            photoArray = Object.values(photos);
        } else {
            // Cas par défaut
            return '/storage/findImages/default-image.jpg';
        }

        // S'assurer que photoArray est un tableau avec au moins un élément
        if (Array.isArray(photoArray) && photoArray.length > 0) {
            return `/storage/findImages/${photoArray[0]}`;
        } else {
            return '/storage/findImages/default-image.jpg';
        }
    } catch (e) {
        console.error('Erreur lors du traitement des photos:', e);
        return '/storage/findImages/default-image.jpg';
    }
};

const formatDateFR = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const openImage = (photo) => {
    try {
        // Vérifier si photo est null ou undefined
        if (!photo) {
            selectedImage.value = '/storage/findImages/default-image.jpg';
            showImageModal.value = true;
            return;
        }

        let photoArray;

        if (typeof photo === 'string') {
            // Tentative de parsing de la chaîne JSON
            try {
                photoArray = JSON.parse(photo);
            } catch (jsonError) {
                // Si c'est une chaîne simple (non-JSON), considérer comme un nom de fichier unique
                console.log('Format de photo simple:', photo);
                selectedImage.value = `/storage/findImages/${photo}`;
                showImageModal.value = true;
                return;
            }
        } else if (Array.isArray(photo)) {
            // Si photo est déjà un tableau
            photoArray = photo;
        } else if (typeof photo === 'object') {
            // Si photo est déjà un objet
            photoArray = Object.values(photo);
        } else {
            // Cas par défaut
            selectedImage.value = '/storage/findImages/default-image.jpg';
            showImageModal.value = true;
            return;
        }

        // S'assurer que photoArray est un tableau avec au moins un élément
        if (Array.isArray(photoArray) && photoArray.length > 0) {
            selectedImage.value = `/storage/findImages/${photoArray[0]}`;
        } else {
            selectedImage.value = '/storage/findImages/default-image.jpg';
        }

        showImageModal.value = true;
    } catch (e) {
        console.error('Erreur lors du traitement des photos:', e);
        selectedImage.value = '/storage/findImages/default-image.jpg';
        showImageModal.value = true;
    }
};

const viewDetails = (find) => {
    // Implémenter la logique pour voir les détails
    console.log('Voir les détails de:', find);
};

const confirmDelete = (find) => {
    // Implémenter la logique de suppression
    if (confirm('Êtes-vous sûr de vouloir supprimer cette pièce ?')) {
        console.log('Supprimer la pièce:', find);
    }
};
</script>

<script>
export default {
    layout: AdminLayout
}
</script>
