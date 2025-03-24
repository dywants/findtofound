<template>
    <Layout>
        <Head title="Mes objets trouvés" />
        
        <!-- En-tête de page -->
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-6">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Mes objets trouvés
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Liste de tous les objets que vous avez déclarés avoir trouvés
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <Link 
                        :href="route('find.register')" 
                        class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Déclarer un nouvel objet
                    </Link>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <!-- Filtre et recherche -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="relative flex-1 max-w-lg">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" v-model="search" id="table-search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                            placeholder="Rechercher par nom, type, etc.">
                    </div>
                    <div class="mt-3 sm:mt-0 sm:ml-4 flex items-center space-x-3">
                        <div>
                            <select v-model="statusFilter" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-md">
                                <option value="">Tous les statuts</option>
                                <option value="0">En attente</option>
                                <option value="1">Trouvé</option>
                            </select>
                        </div>
                        <button @click="resetFilters" 
                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Réinitialiser
                        </button>
                    </div>
                </div>
            </div>
            <!-- Tableau des objets trouvés -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom sur la pièce
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type de pièce
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Photo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Récompense
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="liste in filteredListing" :key="liste.id" class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ liste.fullName }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ liste.piece.name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Gestion de plusieurs photos stockées au format JSON -->
                                    <div v-if="getPhotos(liste.photos).length > 0" class="relative group">
                                        <div class="w-16 h-16 sm:w-20 sm:h-20 overflow-hidden rounded-md shadow-sm border border-gray-200 transition-all duration-300 transform group-hover:scale-105">
                                            <img :src="showImage() + getPhotos(liste.photos)[0]" class="w-full h-full object-cover" :alt="liste.fullName" />
                                        </div>
                                        <span v-if="getPhotos(liste.photos).length > 1" 
                                              class="absolute -top-2 -right-2 bg-primary-600 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                            +{{ getPhotos(liste.photos).length - 1 }}
                                        </span>
                                    </div>
                                    <!-- Aucune image -->
                                    <div v-else class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-md flex items-center justify-center border border-gray-200">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span v-if="liste.approval_status == 0" 
                                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        En attente
                                    </span>
                                    <span v-else 
                                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Trouvée
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ liste.amount_check ? formatCurrency(liste.amount_check) : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        {{ formatDateFR(liste.created_at) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex space-x-2 justify-end">
                                        <Link 
                                            :href="route('find.show', liste.id)" 
                                            class="text-primary-600 hover:text-primary-900 flex items-center"
                                        >
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Voir
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Message si aucun résultat -->
                            <tr v-if="filteredListing.length === 0">
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div class="text-gray-500">Aucun objet trouvé ne correspond à vos critères</div>
                                        <button @click="resetFilters" class="mt-4 text-primary-600 hover:text-primary-900 text-sm font-medium">
                                            Réinitialiser les filtres
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Affichage de <span class="font-medium">{{ filteredListing.length }}</span> objets
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "@/Layouts/Layout";
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref, watch, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";

let props = defineProps({
    listing: Object,
    filters: Object
});

let search = ref(props.filters.search || '');
let statusFilter = ref('');

// Filtrer les résultats en fonction de la recherche et du statut
const filteredListing = computed(() => {
    if (!props.listing) return [];
    
    return props.listing.filter(item => {
        const matchesSearch = !search.value || 
            item.fullName.toLowerCase().includes(search.value.toLowerCase()) ||
            (item.piece && item.piece.name.toLowerCase().includes(search.value.toLowerCase()));
            
        const matchesStatus = !statusFilter.value || 
            item.approval_status.toString() === statusFilter.value;
            
        return matchesSearch && matchesStatus;
    });
});

// Réinitialiser les filtres
function resetFilters() {
    search.value = '';
    statusFilter.value = '';
}

// Pour le référencement côté serveur
watch(search, value => {
    Inertia.get('/dashboard/liste-piece-trouvee', { search: value }, {
        preserveState: true,
        replace: true
    })
})

/**
 * Obtenir le chemin d'accès aux images
 * @returns {string} Le chemin de base vers les images
 */
function showImage() {
    return "/storage/findImages/";
}

/**
 * Formater une date en format français
 * @param {string} date - La date à formater
 * @returns {string} La date formatée
 */
function formatDateFR(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' }
    return new Date(date).toLocaleDateString('fr-FR', options)
}

/**
 * Formater un montant en devise
 * @param {number|string} amount - Le montant à formater
 * @returns {string} Le montant formaté avec le symbole de devise
 */
function formatCurrency(amount) {
    if (!amount) return '0 FCFA';
    
    // Si c'est déjà une chaîne formatée, la retourner
    if (typeof amount === 'string' && amount.includes('FCFA')) {
        return amount;
    }
    
    // Sinon, formater le montant
    const formattedAmount = parseFloat(amount).toLocaleString('fr-FR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
    
    return `${formattedAmount} FCFA`;
}

/**
 * Parse les photos stockées au format JSON
 * @param {string|array} photos - Les photos stockées sous forme de chaîne JSON ou tableau
 * @returns {array} - Un tableau des noms de fichiers des photos
 */
function getPhotos(photos) {
    // Si c'est déjà un tableau, le retourner
    if (Array.isArray(photos)) {
        return photos;
    }
    
    // Si c'est une chaîne vide ou null, retourner un tableau vide
    if (!photos) {
        return [];
    }
    
    try {
        // Essayer de parser la chaîne JSON
        const parsedPhotos = JSON.parse(photos);
        return Array.isArray(parsedPhotos) ? parsedPhotos : [photos];
    } catch (error) {
        // Si ce n'est pas du JSON valide, considérer comme une seule photo
        return [photos];
    }
}
</script>

<style scoped></style>
