<template>
    <nav id="navbar-main" class="navbar is-fixed-top">
        <div class="navbar-brand">
            <a class="navbar-item mobile-aside-button">
                <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
            </a>
            <div class="navbar-item">
                <div class="control"><input placeholder="Search everywhere..." class="input"></div>
            </div>
        </div>

        <div class="navbar-menu" id="navbar-menu">
            <div class="navbar-end">
                <div class="navbar-item dropdown has-divider has-user-avatar">
                    <BreezeDropdown>
                        <template #trigger>
                            <a class="navbar-link">
                                <div class="user-avatar">
                                    <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent($page.props.auth?.user?.name || 'User')}&background=0D8ABC&color=fff`" 
                                         :alt="$page.props.auth?.user?.name || 'User'"
                                         class="rounded-full w-8 h-8">
                                </div>
                                <div class="is-user-name">
                                    <span v-if="$page.props.auth && $page.props.auth.user">
                                        {{ $page.props.auth.user.name }}
                                    </span>
                                </div>
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </a>
                        </template>

                        <div class="navbar-dropdown">
                            <Link :href="route('home')" class="navbar-item">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </span>
                                <span>Site</span>
                            </Link>
                            <a class="navbar-item">
                                <span class="icon"><i class="mdi mdi-settings"></i></span>
                                <span>Settings</span>
                            </a>
                            <a class="navbar-item">
                                <span class="icon"><i class="mdi mdi-email"></i></span>
                                <span>Messages</span>
                            </a>
                            <hr class="navbar-divider">
                            <Link :href="route('logout')" method="post" as="button" class="navbar-item">
                                <span class="icon"><i class="mdi mdi-logout"></i></span>
                                <span>Log Out</span>
                            </Link>
                        </div>
                    </BreezeDropdown>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import BreezeDropdown from '../../Components/Dropdown.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<style scoped>
.navbar-dropdown {
    @apply py-2;
}

.navbar-item {
    @apply flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100;
}

.navbar-divider {
    @apply my-1 border-t border-gray-100;
}
</style>
