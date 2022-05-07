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
                 <NavLink :href="route('find.list')">Liste de pièce</NavLink>
             </nav>
         </template>
     </HeaderPage>

    <main>
        <slot />
    </main>

</template>
