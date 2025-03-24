<script setup>
import Layout from "@/Layouts/Layout";
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from "@/Components/Button.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";

// Récupération des données de la page
const page = usePage();
const props = page.props;

// Informations utilisateur
const user = computed(() => {
    return props.auth.user;
});

// Stats de l'utilisateur (dynamiques depuis le backend)
const stats = computed(() => {
    return props.stats || {};
});

// Détermination du rôle de l'utilisateur depuis les données du backend
const userRole = computed(() => {
    return props.userRole || (user.value.role_id === 2 ? 'finder' : 'founder');
});

// Shortcuts computed properties pour faciliter les vérifications
const isFinder = computed(() => userRole.value === 'finder');
const isFounder = computed(() => userRole.value === 'founder');

// Configuration du fil d'Ariane
const breadcrumbItems = [
    { name: 'Tableau de bord', href: null }
];

// Actions rapides basées sur le rôle de l'utilisateur
const quickActions = computed(() => {
    if (isFinder.value) {
        return [
            {
                title: 'Déclarer une pièce',
                description: 'Enregistrez rapidement une nouvelle pièce trouvée',
                icon: 'document-add',
                color: 'bg-blue-600',
                href: route('find.list')
            },
            {
                title: 'Consulter mes déclarations',
                description: 'Voir le statut de toutes vos pièces déclarées',
                icon: 'collection',
                color: 'bg-purple-600',
                href: route('find.list')
            }
        ];
    } else {
        return [
            {
                title: 'Rechercher ma pièce',
                description: 'Lancez une recherche pour retrouver votre document',
                icon: 'search',
                color: 'bg-blue-600',
                href: route('found.search')
            },
            {
                title: 'Suivi de pièces',
                description: 'Consultez l\'état de vos recherches en cours',
                icon: 'eye',
                color: 'bg-purple-600',
                href: route('found.item')
            }
        ];
    }
});

// Statistiques à afficher selon le rôle (données dynamiques)
const userStats = computed(() => {
    if (isFinder.value) {
        return [
            { title: 'Pièces déclarées', value: stats.value.declarations || 0, icon: 'document-text', color: 'blue' },
            { title: 'En attente', value: stats.value.pendingDeclarations || 0, icon: 'clock', color: 'amber' },
            { title: 'Correspondances', value: stats.value.totalMatches || 0, icon: 'check-circle', color: 'green' },
            { title: 'Récompenses reçues', value: stats.value.rewardsPaid || '0 €', icon: 'cash', color: 'emerald' }
        ];
    } else {
        return [
            { title: 'Pièces retrouvées', value: stats.value.piecesFound || 0, icon: 'collection', color: 'green' },
            { title: 'En attente', value: stats.value.pendingReturns || 0, icon: 'clock', color: 'amber' },
            { title: 'Recherches effectuées', value: stats.value.totalSearches || 0, icon: 'search', color: 'blue' },
            { title: 'Récompenses versées', value: stats.value.rewardsReceived || '0 €', icon: 'cash', color: 'emerald' }
        ];
    }
});

const redirectToMyPiece = () => {
    window.location.href = route('found.item');
    // ou si vous utilisez Inertia:
    // router.visit(route('found.item'));
}
</script>

<template>

    <Head title="Dashboard" />

    <Layout>
        <div class="py-6 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Fil d'Ariane -->
                <div class="mb-6">
                    <Breadcrumb :items="breadcrumbItems" />
                </div>

                <!-- Header avec nom d'utilisateur et rôle -->
                <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tableau de bord</h1>
                        <p class="mt-1 text-gray-600">Bienvenue, {{ user.name }} • <span class="text-blue-600">{{
                            isFinder ? 'Compte Trouveur' : 'Compte Propriétaire' }}</span></p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <Link :href="route('user.profile')"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil
                        </Link>
                    </div>
                </div>

                <!-- Carte d'aperçu principal avec stats et CTA -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                    <div class="p-6 sm:p-8 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-6 md:mb-0">
                                <h2 class="text-2xl font-bold mb-2">
                                    {{ isFinder ? 'Gérez vos pièces trouvées' : 'Retrouvez vos documents perdus' }}
                                </h2>
                                <p class="text-blue-100 max-w-lg">
                                    <span v-if="isFinder">Suivez le statut de vos déclarations et restez informé des correspondances avec les propriétaires.</span>
                                    <span v-else>Lancez des recherches efficaces et retrouvez vos documents importants.</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <Button :href="isFinder ? route('find.list') : route('found.search')"
                                    class="bg-white text-indigo-700 hover:bg-blue-50 shadow-md">
                                    {{ isFinder ? 'Déclarer une pièce' : 'Chercher une pièce' }}
                                </Button>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques -->
                    <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-gray-200">
                        <div v-for="(stat, index) in userStats" :key="index" class="p-6 text-center">
                            <p class="text-sm font-medium text-gray-500">{{ stat.title }}</p>
                            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ stat.value }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Colonne principale avec actions -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Actions rapides -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Actions rapides</h3>
                            </div>
                            <div class="grid grid-cols-1 divide-y divide-gray-200">
                                <div v-for="(action, index) in quickActions" :key="index"
                                    class="p-6 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div :class="[action.color, 'rounded-lg p-3 text-white']">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path v-if="action.icon === 'document-add'" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    <path v-else-if="action.icon === 'collection'"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    <path v-else-if="action.icon === 'search'" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    <path v-else-if="action.icon === 'eye'" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="text-lg font-medium text-gray-900">{{ action.title }}</h4>
                                            <p class="mt-1 text-gray-600">{{ action.description }}</p>
                                            <div class="mt-3">
                                                <Link :href="action.href"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Accéder
                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne latérale -->
                    <div class="space-y-8">
                        <!-- Profil utilisateur -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                                        {{ user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ user.name }}</h3>
                                        <p class="text-sm text-gray-500">{{ user.email }}</p>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium mt-2"
                                            :class="isFinder ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
                                            {{ isFinder ? 'Trouveur' : 'Propriétaire' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aide et support -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Aide et support</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <a href="#"
                                        class="flex items-center text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                                        <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Guide d'utilisation
                                    </a>
                                    <a href="/contact"
                                        class="flex items-center text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                                        <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        Contacter le support
                                    </a>
                                    <a href="#"
                                        class="flex items-center text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                                        <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                        FAQ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
/* Styles spécifiques au dashboard */
</style>
