<template>
    <aside class="aside is-placed-left is-expanded bg-gray-800 min-h-screen">
        <div class="aside-tools p-4 border-b border-gray-700">
            <h1 class="aside-title text-2xl font-bold text-white">
                DocuTrace
            </h1>
        </div>
        <div class="menu is-menu-main p-4">
            <!-- Dashboard Section -->
            <div class="mb-6">
                <Link
                    class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"
                    :class="{ 'bg-gray-700 text-white': $page.url.startsWith('/admin') }" :href="route('admin.index')">
                <span class="icon mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </span>
                <span>Dashboard</span>
                </Link>
            </div>

            <!-- Gestion Section -->
            <div class="mb-6">
                <p class="menu-label text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Gestion</p>
                <div class="space-y-1">
                    <Link
                        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        :class="{ 'bg-gray-700 text-white': $page.url.startsWith('/admin/allFind') }"
                        :href="route('admin.allFind')">
                    <span class="icon mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <span>Pièces Retrouvées</span>
                    </Link>

                    <Link
                        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        :class="{ 'bg-gray-700 text-white': $page.url.startsWith('/admin/users') }"
                        :href="route('admin.users')">
                    <span class="icon mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                    <span>Utilisateurs</span>
                    </Link>

                    <Link
                        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        :class="{ 'bg-gray-700 text-white': $page.url.startsWith('/piece/index') }"
                        :href="route('piece.index')">
                    <span class="icon mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </span>
                    <span>Pieces</span>
                    </Link>
                </div>
            </div>

            <!-- Finance Section -->
            <div class="mb-6">
                <p class="menu-label text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Finance</p>
                <div class="space-y-1">
                    <Link
                        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        :class="{ 'bg-gray-700 text-white': $page.url.startsWith('/admin/payment') }"
                        :href="route('admin.payment')">
                    <span class="icon mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </span>
                    <span>Paiements</span>
                    </Link>

                    <Link
                        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        :class="{ 'bg-gray-700 text-white': $page.url.startsWith('/admin/payment/finder') }"
                        :href="route('admin.payment.finder')">
                    <span class="icon mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                    <span>Paiements Finder</span>
                    </Link>
                </div>
            </div>

            <!-- Support Section -->
            <div class="mb-6">
                <p class="menu-label text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-4">Support</p>
                <div class="space-y-1">
                    <Link
                        class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors duration-200"
                        :class="{ 'bg-gray-700 text-white': $page.url.startsWith('/faq/index') }"
                        :href="route('faq.index')">
                    <span class="icon mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <span>FAQ</span>
                    </Link>
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
</script>

<style scoped>
.aside {
    width: 250px;
}
</style>
