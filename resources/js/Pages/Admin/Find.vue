<template>

    <Head title="Admin - Pièces Retrouvées" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul class="flex space-x-2 text-sm">
                <li>
                    <Link :href="route('admin.index')" class="text-gray-500 hover:text-blue-600">Dashboard</Link>
                </li>
                <li class="text-gray-500">/</li>
                <li class="text-blue-600">Pièces Retrouvées</li>
            </ul>
        </template>
    </HeaderAdmin>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="bg-blue-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total Pièces</h3>
                    <p class="text-2xl font-bold">{{ finds.length }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="bg-green-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Retrouvées</h3>
                    <p class="text-2xl font-bold">{{ finds.filter(f => f.approval_status === 1).length }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="bg-yellow-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">En Attente</h3>
                    <p class="text-2xl font-bold">{{ finds.filter(f => f.approval_status === 0).length }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="bg-purple-50 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Montant Total</h3>
                    <p class="text-2xl font-bold">{{ totalAmount }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" v-model="search" placeholder="Rechercher..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <select v-model="statusFilter"
                        class="border rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                        <option value="all">Tous les statuts</option>
                        <option value="1">Retrouvée</option>
                        <option value="0">En attente</option>
                    </select>
                    <select v-model="cityFilter"
                        class="border rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                        <option value="all">Toutes les villes</option>
                        <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Pièces</h2>
                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Exporter
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Propriétaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ville
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quartier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Photo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trouveur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="find in filteredFinds" :key="find.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ find.fullName }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ find.findCity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ find.ward }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img :src="showImage(find.photos)" alt=""
                                    class="w-16 h-16 rounded-lg object-cover cursor-pointer hover:scale-150 transition-transform"
                                    @click="openImage(find.photos)">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span :class="[
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    find.approval_status === 1
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800'
                                ]">
                                    {{ find.approval_status === 1 ? 'Retrouvée' : 'En attente' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ find.piece.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ find.user.name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ find.amount_check }} FCFA</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ formatDateFR(find.created_at) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <Link :href="route('admin.find.show', find.id)"
                                    class="text-blue-600 hover:text-blue-900">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="ml-1">Détails</span>
                                </span>
                                </Link>

                                <Link :href="route('admin.find.edit', find.id)"
                                    class="text-indigo-600 hover:text-indigo-900">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span class="ml-1">Modifier</span>
                                </span>
                                </Link>

                                <button @click="confirmDelete(find)" class="text-red-600 hover:text-red-900">
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span class="ml-1">Supprimer</span>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-gray-500">
                    Affichage de {{ filteredFinds.length }} résultats
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200"
                        :disabled="currentPage === 1" @click="currentPage--">
                        Précédent
                    </button>
                    <button v-for="page in totalPages" :key="page" class="px-3 py-1 text-sm rounded-md"
                        :class="currentPage === page ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        @click="currentPage = page">
                        {{ page }}
                    </button>
                    <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200"
                        :disabled="currentPage === totalPages" @click="currentPage++">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div v-if="showImageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click="showImageModal = false">
        <img :src="selectedImage" class="max-w-3xl max-h-[80vh] rounded-lg" alt="">
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import AdminLayout from "@/Layouts/AdminLayout";
import { ref, computed } from 'vue';

const props = defineProps({
    finds: Array
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
    return [...new Set(props.finds.map(find => find.findCity))];
});

const totalAmount = computed(() => {
    return props.finds.reduce((sum, find) => sum + (parseInt(find.amount_check) || 0), 0);
});

const filteredFinds = computed(() => {
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
        // Parse la chaîne JSON
        const photoArray = JSON.parse(photos);
        // Retourne le chemin de la première image avec le bon dossier
        return `/storage/findImages/${photoArray[0]}`;
    } catch (e) {
        console.error('Erreur lors du parsing des photos:', e);
        return ''; // ou une image par défaut
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
        const photoArray = JSON.parse(photo);
        selectedImage.value = `/storage/findImages/${photoArray[0]}`;
        showImageModal.value = true;
    } catch (e) {
        console.error('Erreur lors du parsing des photos:', e);
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