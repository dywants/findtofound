<template>
    <section>
        <div class="max-w-screen-xl mx-auto"
            :class="{
                'p-0': showingNavigationDropdown,
                'p-4': !showingNavigationDropdown,
                'border-b border-gray-200': $page.url === '/'
            }">
            <nav class="border-gray-200 py-2.5 bg-tahiti-dark"
                :class="{'px-0': showingNavigationDropdown, 'px-2': !showingNavigationDropdown}">
                <div class="container flex flex-wrap justify-between items-center mx-auto">
                    <TheLogo />
                    <div class="flex items-center md:order-2">
                        <template v-if="$page.props.auth.user">
                            <div class="flex items-center">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <BreezeDropdown align="right" width="48">
                                        <template #trigger>
                                             <span class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                    <!-- Photo de profil -->
                                                    <div class="flex items-center">
                                                        <div class="h-8 w-8 rounded-full overflow-hidden border-2 border-white mr-2 flex-shrink-0">
                                                            <img v-if="$page.props.auth.user.profile && $page.props.auth.user.profile.full_photo_url" 
                                                                :src="$page.props.auth.user.profile.full_photo_url" 
                                                                class="h-full w-full object-cover" 
                                                                alt="Photo de profil">
                                                            <div v-else class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        {{ $page.props.auth.user.name }}
                                                    </div>

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <BreezeDropdownLink v-if="$page.props.is_admin" :href="route('admin.index')"
                                                as="button">
                                                Admin
                                            </BreezeDropdownLink>
                                            <BreezeDropdownLink :href="route('dashboard')" as="button">
                                                Dashboard
                                            </BreezeDropdownLink>
                                            <BreezeDropdownLink :href="route('user.profile')" as="button">
                                                Profile
                                            </BreezeDropdownLink>
                                            <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                                Déconnexion
                                            </BreezeDropdownLink>
                                        </template>
                                    </BreezeDropdown>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="items-center justify-end flex-1 hidden space-x-4 ml-4 sm:flex">
                                <NavLink
                                    class="px-5 pt-2 pb-1.5 text-sm font-medium bg-tahiti-primary text-tahiti-dark rounded-lg hover:text-white"
                                    href="/login">Se connecter</NavLink>
                            </div>
                        </template>

                        <!-- Hamburger -->
                        <div class="flex items-center md:hidden">
                            <button @click="toggleNavigation"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1">
                        <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
                            <li>
                                <NavLink href="/" aria-current="page" :active="$page.url === '/'">Accueil
                                </NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('find.intro')" :active="$page.url === route('find.intro') || $page.url === route('find.register')">
                                    Enregister pièce</NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('found.search')" :active="$page.url === route('found.search')">
                                    Rechercher pièce</NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('documents.home')" :active="$page.url.startsWith('/documents')">
                                    DocuTrace</NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('contact')" :active="$page.url === route('contact')">Contact</NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('faqs')" :active="$page.url === route('faqs')">Faqs</NavLink>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block shadow-sm w-full py-6': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                    class="md:hidden">
                    <div>
                        <ul class="space-y-6 text-center w-full block">
                            <li>
                                <NavLink href="/" aria-current="page" :active="$page.url === '/'">Accueil
                                </NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('find.intro')" :active="$page.url === route('find.intro') || $page.url === route('find.register')">
                                    Enregister pièce</NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('found.search')" :active="$page.url === route('found.search')">
                                    Rechercher pièce</NavLink>
                            </li>
                            <li>
                                <NavLink :href="route('documents.home')" :active="$page.url.startsWith('/documents')">
                                    DocuTrace</NavLink>
                            </li>
                            <li>
                                <NavLink href="/blog">Blog</NavLink>
                            </li>
                            <li v-if="!$page.props.auth.user">
                                <NavLink
                                    class="px-5 pt-2 pb-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:text-white"
                                    href="/login">Se connecter</NavLink>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <header v-if="$page.url === '/'">
            <TheHeaderHome />
        </header>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import TheLogo from '@/Components/TheLogo.vue';
import TheHeaderHome from '@/Components/TheHeaderHome.vue';

const showingNavigationDropdown = ref(false);

const toggleNavigation = () => {
    showingNavigationDropdown.value = !showingNavigationDropdown.value;
};

const page = usePage();
</script>

<style scoped>
.router-link-active {
    @apply text-blue-700;
}
</style>
