<script setup>
import HeaderPage from "@/Layouts/HeaderPage";
// import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import NavLink from "@/Components/NavLink";
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

    <main>
        <slot />
    </main>

</template>
