<template>
    <aside class="aside is-placed-left is-expanded">
        <div class="aside-tools">
            <h1 class="aside-title">
                FindTofound
            </h1>
        </div>
        <div class="menu is-menu-main">
            <p class="menu-label">General</p>
            <ul class="menu-list">
                <li class="active">
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                                 :href="route('admin.index')" :active="route().current('admin.index')">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </span>
                        <span class="menu-item-label">Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                          :href="route('admin.allFind')" :active="route().current('admin.allFind')">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <span class="menu-item-label">Tous les Finds</span>
                    </Link>
                </li>
                <li>
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                          :href="route('admin.payment')" :active="route().current('admin.payment')">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                             </svg>
                        </span>
                        <span class="menu-item-label">Paiement</span>
                    </Link>
                </li>
                <li>
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                                 :href="route('admin.users')" :active="route().current('admin.users')">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                        <span class="menu-item-label">Users</span>
                    </Link>
                </li>
                <li>
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                          :href="route('admin.payment.finder')" :active="route().current('admin.payment.finder')">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                        <span class="menu-item-label">Paiement finder</span>
                    </Link>
                </li>
                <li>
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                          :href="route('piece.index')" :active="route().current('piece.index')">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
</svg>
                        </span>
                        <span class="menu-item-label">Pieces</span>
                    </Link>
                </li>
                <li>
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                          :href="route('faq.index')" :active="route().current('faq.index')">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </span>
                        <span class="menu-item-label">Faqs</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<style scoped>

</style>
