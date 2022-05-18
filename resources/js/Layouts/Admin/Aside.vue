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
