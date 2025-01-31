<template>

    <Head title="Admin - Dashboard" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <div class="flex items-center space-x-2 text-gray-500">
                <span>Admin</span>
                <span>/</span>
                <span class="text-gray-900 font-medium">Dashboard</span>
            </div>
        </template>
    </HeaderAdmin>

    <!-- Stats Overview -->
    <div class="grid gap-6 grid-cols-1 md:grid-cols-4 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-6 transition-transform hover:scale-105">
            <div class="flex flex-col p-6">
                <div class="text-sm text-gray-600">Paypal Payments</div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-semibold text-gray-900">{{ props.paypalPayment }} FCFA</div>
                        <p class="text-xs text-green-600 mt-2">+2.5% from last month</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transition-transform hover:scale-105">
            <div class="flex flex-col p-6">
                <div class="text-sm text-gray-600">Orange Money</div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-semibold text-gray-900">{{ props.orangePayment }} FCFA</div>
                        <p class="text-xs text-green-600 mt-2">+4.2% from last month</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transition-transform hover:scale-105">
            <div class="flex flex-col p-6">
                <div class="text-sm text-gray-600">MTN Mobile Money</div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-semibold text-gray-900">{{ props.mtnPayment }} FCFA</div>
                        <p class="text-xs text-green-600 mt-2">+1.8% from last month</p>
                    </div>
                    <div class="bg-yellow-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transition-transform hover:scale-105">
            <div class="flex flex-col p-6">
                <div class="text-sm text-gray-600">Pieces Retrouvées</div>
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-semibold text-gray-900">{{ props.totalCNI }}</div>
                        <p class="text-xs text-green-600 mt-2">+12 cette semaine</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="bg-white rounded-lg shadow-sm mb-8">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Performance</h2>
                <div class="flex items-center space-x-2">
                    <button
                        class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">Semaine</button>
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded-md hover:bg-blue-600">Mois</button>
                    <button
                        class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">Année</button>
                </div>
            </div>
        </div>
        <div class="p-6">
            <canvas id="big-line-chart" height="400" class="w-full"></canvas>
        </div>
    </div>

    <!-- Recent Clients Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Clients Récents</h2>
                <button
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajouter un client</span>
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Entreprise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ville
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Progrès
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="client in props.clients" :key="client.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" :src="client.avatar" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ client.name }}</div>
                                    <div class="text-sm text-gray-500">{{ client.email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ client.company }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ client.city }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-500 h-2.5 rounded-full" :style="{ width: client.progress + '%' }">
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 mt-1">{{ client.progress }}%</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ client.created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="text-red-600 hover:text-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing 1 to 10 of 97 results
                </div>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">Previous</button>
                    <button class="px-3 py-1 text-sm bg-blue-500 text-white rounded-md">1</button>
                    <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">2</button>
                    <button class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">3</button>
                    <button
                        class="px-3 py-1 text-sm bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200">Next</button>
                </div>
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

onMounted(() => {
    const ctx = document.getElementById('big-line-chart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Transactions 2024',
                data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56],
                fill: false,
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
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
