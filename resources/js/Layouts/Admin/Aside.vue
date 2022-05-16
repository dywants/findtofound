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
                                 :href="route('admin.index')">
                        <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
                        <span class="menu-item-label">Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link class="text-white font-medium text-[16px] cursor-pointer"
                                 :href="route('admin.users')">
                        <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
                        <span class="menu-item-label">Users</span>
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
