<script setup>
import HeaderPage from "@/Layouts/HeaderPage.vue";
import { Head, Link } from '@inertiajs/vue3';
import NavLink from "@/Components/NavLink.vue";
</script>

<template>
    <Head title="Dashboard" />

     <HeaderPage>
         <template #headerPage>
             <nav class="flex space-x-4">
                 <Link :href="route('dashboard')" class="font-semibold text-xl text-gray-800 leading-tight">
                     Dashboard
                 </Link>
                 <NavLink v-if="$page.props.auth.user.role_id == 2" :href="route('find.list')" :active="route().current('find.list')">Liste de pièce</NavLink>
                 <NavLink v-if="$page.props.auth.user.role_id == 1" :href="route('found.item')" :active="route().current('found.item')">Ma pièce retrouvée</NavLink>
             </nav>
         </template>
     </HeaderPage>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</template>
