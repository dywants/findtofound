<template>
    <Head title="Recherche de pièces perdues" />
    
    <div class="min-h-screen bg-gray-50">
        <HeaderPage>
            <template #headerPage>
                <div class="bg-white shadow-sm border-b border-gray-200 px-4 py-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                                Rechercher une pièce perdue
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Retrouvez facilement vos documents perdus
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </HeaderPage>

        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <!-- Search Section -->
            <div class="max-w-3xl mx-auto mb-10">
                <form @submit.prevent class="relative">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input
                            type="search"
                            @keyup.esc="reset()"
                            @blur="reset()"
                            v-model="term"
                            id="search"
                            class="block w-full pl-12 pr-12 py-3 text-base border-0 ring-1 ring-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 bg-white placeholder-gray-500 shadow-sm"
                            placeholder="Rechercher par nom ou ville..."
                            required
                        >
                        <button
                            v-if="term"
                            @click="reset()"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div v-if="term" class="max-w-5xl mx-auto space-y-6">
                <div v-for="(result, index) in results" :key="index">
                    <Link :href="result.item.link" @mousedown.prevent>
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-100">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-1/3 relative">
                                    <img
                                        :alt="result.item.fullName"
                                        class="w-full h-64 md:h-full object-cover"
                                        loading="lazy"
                                        :src="showImage(result.item.photos)"
                                    >
                                </div>
                                <div class="md:w-2/3 p-6 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ result.item.fullName }}
                                            </h3>
                                            <span class="text-sm text-gray-500">
                                                {{ result.item.created_at }}
                                            </span>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-center text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ result.item.findCity }}
                                            </div>
                                            <p class="text-gray-600 line-clamp-2">
                                                {{ result.item.details }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700">
                                            {{ result.item.amount_check.amount == 0 ? result.item.amount_piece.formatted : result.item.amount_check.formatted }}
                                        </span>
                                        <button class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100">
                                            Voir les détails
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
                
                <div v-if="!results.length" class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <div class="flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01M12 12h.01" />
                        </svg>
                        <p class="text-gray-600 mb-2">Aucune pièce trouvée pour :</p>
                        <p class="text-lg font-semibold text-gray-900">{{ term }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderPage from "@/Layouts/HeaderPage";
import { Link, usePage } from '@inertiajs/inertia-vue3';
import Fuse from 'fuse.js';

export default {
    name: "TheSearch",
    components: { HeaderPage, Link },
    props: ['formatted', 'searchItems'],
    data() {
        return {
            term: null,
            fuse: null,
            urlImage: '',
        }
    },
    computed: {
        results() {
            return this.term ? this.fuse.search(this.term).slice(0, 8) : [];
        },
    },
    created() {
        this.fuse = new Fuse(this.$page.props.searchItems, {
            keys: ['fullName', 'findCity'],
            threshold: 0.3,
            distance: 100
        })
    },
    methods: {
        reset() {
            this.term = null;
        },
        showImage(file) {
            return "/storage/findImages/" + file
        },
    },
}
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
