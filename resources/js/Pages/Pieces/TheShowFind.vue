<template>

    <Head :title="fullName" />

    <Layout>
        <div class="min-h-screen bg-gray-50">
            <HeaderPage>
                <template #headerPage>
                    <div class="bg-white shadow-sm border-b border-gray-200 px-4 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                                    Détails de la pièce retrouvée
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Consultez les informations détaillées de cette pièce
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </HeaderPage>

            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                <!-- Fil d'Ariane -->
                <nav class="flex mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <Link :href="route('home')"
                                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Accueil
                            </Link>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <Link :href="route('found.search')"
                                    class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                Rechercher une pièce
                                </Link>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ fullName }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Contenu Principal -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Section Image -->
                        <div class="lg:w-1/2">
                            <div class="relative h-full">
                                <Splide :options="{
                                    rewind: true,
                                    arrows: true,
                                    pagination: true,
                                    height: '500px'
                                }">
                                    <SplideSlide>
                                        <img :alt="fullName" :src="showImage(photos)"
                                            class="w-full h-full object-cover">
                                    </SplideSlide>
                                </Splide>
                            </div>
                        </div>

                        <!-- Section Informations -->
                        <div class="lg:w-1/2 p-8">
                            <div class="space-y-6">
                                <!-- En-tête -->
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900">
                                        {{ fullName }}
                                    </h1>
                                    <div class="mt-4 flex items-center space-x-2 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ findCity }}</span>
                                    </div>
                                </div>

                                <!-- Détails -->
                                <div class="prose prose-blue max-w-none">
                                    <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                                    <p class="mt-2 text-gray-600">{{ details }}</p>
                                </div>

                                <!-- Montant -->
                                <div class="border-t border-gray-200 pt-6">
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-medium text-gray-900">Montant de la récompense</span>
                                        <span
                                            class="inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold bg-green-50 text-green-700">
                                            {{ amount_check.amount == 0 ? amount_piece.formatted :
                                                amount_check.formatted }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Action -->
                                <div class="mt-8">
                                    <Link :href="route('found.info', { thefind: id })"
                                        class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent rounded-lg text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Valider cette trouvaille
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>

</template>

<script>
import Layout from "@/Layouts/Layout";
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';

export default {
    name: "TheShowFind",
    components: {
        HeaderPage,
        Link,
        Splide,
        SplideSlide,
        Layout
    },
    props: {
        id: Number,
        fullName: String,
        findCity: String,
        details: String,
        amount_piece: Object,
        amount_check: Object,
        photos: {
            type: String,
            required: true
        }
    },
    methods: {
        showImage(file) {
            if (!file) return '';
            return "/storage/findImages/" + file;
        }
    }
}
</script>

<style>
.splide__arrow {
    background: rgba(37, 99, 235, 0.9) !important;
    opacity: 1 !important;
}

.splide__arrow svg {
    fill: #ffffff !important;
}

.splide__pagination__page.is-active {
    background: rgb(37, 99, 235) !important;
}
</style>
