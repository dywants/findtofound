<template>
    <Dashboard>
        <Head title="Liste des pièces retrouvées" />
        <div class="max-w-screen-xl p-4 mx-auto mt-8">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="p-4">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" v-model="search" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5 " placeholder="Recherche pièce">
                    </div>
                </div>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nom sur la pièce
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Type de pièce
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Photo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            status de la pièce
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Montant de la recompense
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="liste in listing" :key="liste.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ liste.fullName }}
                        </th>
                        <td class="px-6 py-4">
                            {{ liste.piece.name}}
                        </td>
                        <td class="px-6 py-4">
                            <img :src="showImage() + liste.photos"
                                 class="w-28 h-28 object-cover" :alt=liste.fullName />
                        </td>
                        <td class="px-6 py-4">
                           <span class="px-1.5 py-1 bg-gray-400 rounded-sm text-white"> {{ liste.approval_status == 0 ? 'Pas retrouvée' : 'Trouvée'  }}</span>
                        </td>
                        <td class="text-center">
                            {{ liste.amount_check }}
                        </td>
                        <td class="px-6 py-4">
                            {{ formatDateFR(liste.created_at) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Dashboard>

</template>

<script setup>
import Dashboard from '@/Pages/Dashboard'
import { Head } from '@inertiajs/inertia-vue3';
import {ref, watch} from "vue";
import {Inertia} from "@inertiajs/inertia";

let props = defineProps({
    listing: Object,
    filters: Object
});

let search = ref(props.filters.search);

watch( search, value => {
    Inertia.get('/dashboard/liste-piece-trouvee', {search: value} ,  {
        preserveState: true,
        replace: true
    })
})

function showImage() {
    return "/storage/findImages/";
}

function formatDateFR(date) {
    const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
    return new Date(date).toLocaleDateString('fr-FR', options)
}

// export default {
//     name: "TheListingFind",
//     components: { Dashboard, Head},
//     props: ['listing'],
//
//     methods: {
//         showImage() {
//             return "/storage/findImages/";
//         },
//         formatDateFR(date) {
//             const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
//             return new Date(date).toLocaleDateString('fr-FR', options)
//         },
//     },
// }
</script>

<style scoped>

</style>
