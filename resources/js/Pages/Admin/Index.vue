<template>

    <Head title="Admin - Dashboard" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <Link href="/admin" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Administration
                        </Link>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tableau de bord</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </template>
    </HeaderAdmin>

    <!-- Stats Overview -->
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Paypal Payments -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:border-blue-100 transition-all">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Paiements Paypal</h3>
                    <div class="bg-blue-50 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-2xl font-bold text-gray-800">{{ formatCurrency(props.paypalPayment) }}</div>
                    <div class="flex items-center mt-2">
                        <span class="flex items-center text-green-600 text-xs font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            +2.5%
                        </span>
                        <span class="text-xs text-gray-400 ml-1">par rapport au mois dernier</span>
                    </div>
                </div>
            </div>
            <div class="h-1 w-full bg-blue-500"></div>
        </div>

        <!-- Orange Money -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:border-orange-100 transition-all">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Orange Money</h3>
                    <div class="bg-orange-50 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-2xl font-bold text-gray-800">{{ formatCurrency(props.orangePayment) }}</div>
                    <div class="flex items-center mt-2">
                        <span class="flex items-center text-green-600 text-xs font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            +4.2%
                        </span>
                        <span class="text-xs text-gray-400 ml-1">par rapport au mois dernier</span>
                    </div>
                </div>
            </div>
            <div class="h-1 w-full bg-orange-500"></div>
        </div>

        <!-- MTN Mobile Money -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:border-yellow-100 transition-all">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">MTN Mobile Money</h3>
                    <div class="bg-yellow-50 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-2xl font-bold text-gray-800">{{ formatCurrency(props.mtnPayment) }}</div>
                    <div class="flex items-center mt-2">
                        <span class="flex items-center text-green-600 text-xs font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            +1.8%
                        </span>
                        <span class="text-xs text-gray-400 ml-1">par rapport au mois dernier</span>
                    </div>
                </div>
            </div>
            <div class="h-1 w-full bg-yellow-500"></div>
        </div>

        <!-- Pièces Retrouvées -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:border-green-100 transition-all">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Pièces Retrouvées</h3>
                    <div class="bg-green-50 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="text-2xl font-bold text-gray-800">{{ props.totalCNI }}</div>
                    <div class="flex items-center mt-2">
                        <span class="flex items-center text-green-600 text-xs font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            +12
                        </span>
                        <span class="text-xs text-gray-400 ml-1">cette semaine</span>
                    </div>
                </div>
            </div>
            <div class="h-1 w-full bg-green-500"></div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="bg-white rounded-lg shadow-sm mb-8 border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">Performance des Transactions</h2>
                    <p class="text-sm text-gray-500">Vue d'ensemble des transactions par méthode de paiement</p>
                </div>
                <div class="flex items-center bg-gray-50 p-1 rounded-lg self-start">
                    <button @click="setChartPeriod('week')" 
                            :class="[chartPeriod === 'week' ? 'bg-blue-500 text-white' : 'bg-transparent text-gray-600 hover:bg-gray-100']"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        Semaine
                    </button>
                    <button @click="setChartPeriod('month')" 
                            :class="[chartPeriod === 'month' ? 'bg-blue-500 text-white' : 'bg-transparent text-gray-600 hover:bg-gray-100']"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        Mois
                    </button>
                    <button @click="setChartPeriod('year')" 
                            :class="[chartPeriod === 'year' ? 'bg-blue-500 text-white' : 'bg-transparent text-gray-600 hover:bg-gray-100']"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-colors">
                        Année
                    </button>
                </div>
            </div>
        </div>
        <div class="p-6">
            <canvas id="big-line-chart" height="400" class="w-full"></canvas>
        </div>
    </div>

    <!-- Recent Clients Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">Clients Récents</h2>
                    <p class="text-sm text-gray-500">Liste des derniers utilisateurs inscrits sur la plateforme</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Rechercher un client..." />
                    </div>
                    <button
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center space-x-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Ajouter un client</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 text-xs text-gray-700 uppercase">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Client
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Entreprise</th>
                        <th scope="col" class="px-6 py-3 font-medium">Ville
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">
                            Progrès
                        </th>
                        <th scope="col" class="px-6 py-3 font-medium">Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-right font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="client in props.clients" :key="client.id" class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 mr-4">
                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" :src="client.avatar" :alt="client.name">
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ client.name }}</div>
                                    <div class="text-xs text-gray-500">{{ client.email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ client.company }}</div>
                            <div class="text-xs text-gray-500">{{ client.role }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ client.city }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                                <div class="bg-blue-600 h-2.5 rounded-full" :style="{ width: client.progress + '%' }">
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">{{ client.progress }}% complété</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ formatDate(client.created_at) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2">
                                <button class="text-blue-600 hover:text-blue-900 p-1 rounded-md hover:bg-blue-50 transition-colors" title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button class="text-red-600 hover:text-red-900 p-1 rounded-md hover:bg-red-50 transition-colors" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex flex-col md:flex-row items-center justify-between p-4 gap-4">
                <div class="text-sm text-gray-700 bg-gray-50 rounded-md px-3 py-2">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">97</span> résultats
                </div>
                <nav class="inline-flex -space-x-px">
                    <button class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">
                        <span class="sr-only">Précédent</span>
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                    </button>
                    <button class="flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">1</button>
                    <button class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</button>
                    <button class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">3</button>
                    <button class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">
                        <span class="sr-only">Suivant</span>
                        <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin.vue";
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

const props = defineProps({
    errors: Object,
    paypalPayment: Number,
    orangePayment: Number,
    mtnPayment: Number,
    totalCNI: Number,
    clients: Array,
});

const chartPeriod = ref('month');
let transactionChart = null;

const chartData = {
    week: {
        labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        datasets: [
            {
                label: 'Paypal',
                data: [28, 32, 39, 53, 21, 19, 24],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'Orange Money',
                data: [38, 42, 35, 27, 43, 22, 36],
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'MTN Money',
                data: [24, 31, 25, 29, 32, 28, 29],
                borderColor: 'rgb(234, 179, 8)',
                backgroundColor: 'rgba(234, 179, 8, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }
        ]
    },
    month: {
        labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
        datasets: [
            {
                label: 'Paypal',
                data: [158, 142, 183, 164],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'Orange Money',
                data: [140, 167, 152, 183],
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'MTN Money',
                data: [118, 109, 123, 115],
                borderColor: 'rgb(234, 179, 8)',
                backgroundColor: 'rgba(234, 179, 8, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }
        ]
    },
    year: {
        labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
        datasets: [
            {
                label: 'Paypal',
                data: [650, 590, 800, 810, 560, 550, 400, 650, 590, 800, 810, 560],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'Orange Money',
                data: [530, 620, 580, 490, 530, 620, 490, 580, 620, 530, 490, 580],
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'MTN Money',
                data: [380, 420, 390, 400, 380, 420, 390, 400, 380, 420, 390, 400],
                borderColor: 'rgb(234, 179, 8)',
                backgroundColor: 'rgba(234, 179, 8, 0.1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }
        ]
    }
};

function setChartPeriod(period) {
    chartPeriod.value = period;
    updateChart();
}

function updateChart() {
    if (transactionChart) {
        transactionChart.data = chartData[chartPeriod.value];
        transactionChart.update();
    }
}

function formatCurrency(value) {
    return new Intl.NumberFormat('fr-CM', {
        style: 'currency',
        currency: 'XAF',
        minimumFractionDigits: 0,
    }).format(value);
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    }).format(date);
}

onMounted(() => {
    const ctx = document.getElementById('big-line-chart');
    transactionChart = new Chart(ctx, {
        type: 'line',
        data: chartData[chartPeriod.value],
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#4b5563',
                    bodyFont: {
                        size: 12
                    },
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    padding: 12,
                    boxPadding: 8,
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            return `${context.dataset.label}: ${formatCurrency(value)}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('fr-CM') + ' FCFA';
                        },
                        font: {
                            size: 10
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            elements: {
                point: {
                    radius: 3,
                    hoverRadius: 5
                }
            }
        }
    });
});
</script>

<script>
export default {
    layout: AdminLayout
}
</script>
