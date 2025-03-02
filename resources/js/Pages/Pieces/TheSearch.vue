<template>

    <Head title="Recherche de pièces perdues" />

    <Layout>
        <div class="min-h-screen bg-gray-50">
            <HeaderPage>
                <template #headerPage>
                    <div class="bg-white shadow-sm border-b border-gray-200 px-4 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                                    Rechercher une pièce perdue
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Retrouvez facilement vos documents perdus
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </HeaderPage>

            <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                <!-- Search Section -->
                <div class="max-w-3xl mx-auto mb-10">
                    <form @submit.prevent class="relative" role="search" aria-label="Recherche de pièces perdues">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="search" @keyup.esc="reset()" @blur="reset()" v-model="searchInput" @input="debouncedSearch" id="search"
                                class="block w-full pl-12 pr-12 py-3 text-base border-0 ring-1 ring-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 bg-white placeholder-gray-500 shadow-sm"
                                placeholder="Rechercher par nom ou ville..." required
                                aria-label="Recherche" autocomplete="off" aria-controls="search-results">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <svg v-if="isSearching" class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <button v-if="term && !isSearching" @click="reset()" class="text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Results Section -->
                <div v-if="term" class="max-w-5xl mx-auto space-y-6" id="search-results" aria-live="polite">
                    <!-- Results Count and Filters -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                            <div>
                                <span class="text-gray-600">{{ filteredResults.length }} résultat{{ filteredResults.length > 1 ? 's' : '' }} pour : </span>
                                <span class="font-medium text-gray-900">{{ term }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="relative">
                                    <select v-model="activeFilter" class="appearance-none pl-3 pr-8 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Filtrer par date">
                                        <option value="">Tous</option>
                                        <option value="today">Aujourd'hui</option>
                                        <option value="week">Cette semaine</option>
                                        <option value="month">Ce mois</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="relative">
                                    <select v-model="sortBy" class="appearance-none pl-3 pr-8 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Trier par">
                                        <option value="relevance">Pertinence</option>
                                        <option value="dateDesc">Date (récent)</option>
                                        <option value="dateAsc">Date (ancien)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <button @click="toggleView" class="p-2 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" aria-label="Changer la vue" :aria-pressed="viewMode === 'grid'">
                                    <svg v-if="viewMode === 'list'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 14a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1v-5zm10 0a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1h-4a1 1 0 01-1-1v-5z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- List View -->                      
                    <div v-if="viewMode === 'list'" v-for="(result, index) in filteredResults" :key="index">
                        <Link :href="result.item.link" @mousedown.prevent :aria-label="'Voir les détails de ' + result.item.fullName">
                        <div
                            class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-100">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/3 relative">
                                    <img :alt="result.item.fullName" class="w-full h-64 md:h-full object-cover"
                                        loading="lazy" :src="showImage(result.item.photos)">
                                </div>
                                <div class="md:w-2/3 p-6 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ result.item.fullName }}
                                            </h3>
                                            <span class="text-sm text-gray-500">
                                                {{ result.item.created_at }}
                                            </span>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-center text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ result.item.findCity }}
                                            </div>
                                            <p class="text-gray-600 line-clamp-2">
                                                {{ result.item.details }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700">
                                            {{ result.item.amount_check.amount == 0 ? result.item.amount_piece.formatted
                                                :
                                                result.item.amount_check.formatted }}
                                        </span>
                                        <button
                                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100">
                                            Voir les détails
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </Link>
                    </div>

                    <!-- Grid View -->
                    <div v-if="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <Link v-for="(result, index) in filteredResults" :key="'grid-'+index" :href="result.item.link" @mousedown.prevent
                            class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-100 flex flex-col h-full" 
                            :aria-label="'Voir les détails de ' + result.item.fullName">
                            <div class="relative h-48">
                                <img :alt="result.item.fullName" class="w-full h-full object-cover" loading="lazy" :src="showImage(result.item.photos)">
                            </div>
                            <div class="p-4 flex-grow">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-bold text-gray-900 line-clamp-1">{{ result.item.fullName }}</h3>
                                </div>
                                <div class="text-sm text-gray-500 mb-2">{{ formatDate(result.item.created_at) }}</div>
                                <div class="flex items-center text-gray-600 text-sm mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ result.item.findCity }}
                                </div>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ result.item.details }}</p>
                            </div>
                            <div class="px-4 pb-4 mt-auto">
                                <div class="flex justify-between items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ result.item.amount_check.amount == 0 ? result.item.amount_piece.formatted : result.item.amount_check.formatted }}
                                    </span>
                                    <span class="text-sm text-blue-600 flex items-center">
                                        Voir
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </Link>
                    </div>

                    <!-- No Results Message -->
                    <div v-if="!filteredResults.length" class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01" />
                            </svg>
                            <p class="text-gray-600 mb-2">Aucune pièce trouvée{{ activeFilter ? ' avec le filtre actuel' : '' }} pour :</p>
                            <p class="text-lg font-semibold text-gray-900">{{ term }}</p>
                            <button v-if="activeFilter" @click="activeFilter = ''" class="mt-4 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition duration-200" aria-label="Réinitialiser les filtres">
                                Réinitialiser les filtres
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </Layout>
</template>

<script>
import Layout from "@/Layouts/Layout";
import HeaderPage from "@/Layouts/HeaderPage";
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { useSearch } from '@/Composables/useSearch';

export default {
    name: "TheSearch",
    components: { HeaderPage, Link, Layout },
    props: ['formatted', 'searchItems'],
    setup(props) {
        // Configurer le composable de recherche avec les options nécessaires pour Fuse.js
        const { 
            searchInput, 
            term, 
            isSearching, 
            activeFilter, 
            sortBy,
            viewMode,
            recentSearches,
            results,
            filteredResults,
            reset,
            debouncedSearch,
            toggleView,
            formatDate 
        } = useSearch(usePage().props.value.searchItems, {
            keys: ['fullName', 'findCity', 'details']
        });
        
        // Fonction pour afficher les images
        const showImage = (file) => {
            return "/storage/findImages/" + file;
        };
        
        return {
            searchInput,
            term,
            isSearching,
            activeFilter,
            sortBy,
            viewMode,
            recentSearches,
            results,
            filteredResults,
            reset,
            debouncedSearch,
            toggleView,
            formatDate,
            showImage
        };
    },

}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Focus styles améliorés pour l'accessibilité */
:focus-visible {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
}

/* Amélioration de la taille des zones cliquables pour mobile */
@media (max-width: 640px) {
    button, select, .hover\:shadow-md {
        min-height: 44px;
        min-width: 44px;
    }
    
    select, button {
        font-size: 16px; /* Évite le zoom sur iOS */
    }
}
</style>
