<template>
    <Head title="Pièce retrouvée"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Recherchez votre pièce perdues
            </h2>
        </template>
    </HeaderPage>
    <div class="max-w-screen-xl p-4 mx-auto mt-8">

        <nav class="flex py-3 px-5 text-gray-700 bg-gray-50 rounded-lg border border-gray-200 " aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <Link :href="route('home')" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Accueil
                    </Link>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <Link :href="route('found.search')" class="ml-1 text-sm font-medium text-gray-700 hover:text-gray-900 md:ml-2 dark:text-gray-400 dark:hover:text-white">Rechercher une pièce</Link>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500">{{ fullName }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="container mx-auto md:py-12 py-9 px-4">
                <div class="mt-3 md:mt-4 lg:mt-0 flex flex-col lg:flex-row items-strech justify-center lg:space-x-8">
                    <div class="md:w-1/2 bg-gray-50 border shadow-lg p-4">
                        <Splide :options="{ rewind: true }">
                            <SplideSlide>
                                <img :alt=fullName :src="showImage(currentImg)" class="object-cover">
                            </SplideSlide>
                        </Splide>
                        <div class="splide__arrows" />
                    </div>
                    <div class="lg:w-1/2 flex flex-col justify-center mt-7 md:mt-8 lg:mt-0 pb-8 lg:pb-0">
                        <h1 class="text-3xl lg:text-4xl font-semibold text-gray-800 dark:text-white">{{ fullName }}</h1>
                        <p class="text-base leading-normal text-gray-600 dark:text-white mt-2">{{ findCity }}</p>
                        <p class="text-base leading-normal text-gray-600 dark:text-white mt-2">{{ details }}</p>
                        <p class="text-3xl font-medium text-gray-600 dark:text-white mt-8 md:mt-10"></p>
                        <div
                            class="flex items-center flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 lg:space-x-8 mt-4 md:mt-16">
                            <Link :href="route('found.info', {thefind: id})"
                                class="w-full md:w-3/5 text-base text-center rounded-md font-medium leading-none text-white uppercase py-6 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 bg-green-600 hover:bg-green-700 text-white ">
                                Valider votre trouvalle
                            </Link>
                        </div>
                        <div class="mt-6">
                            <span
                                class="text-xl underline text-gray-800 capitalize hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
                                {{ amount_check.amount == 0 ? amount_piece.formatted : amount_check.formatted}}
                            </span>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
import HeaderPage from "@/Layouts/HeaderPage";
import {Link, usePage} from '@inertiajs/inertia-vue3';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';

export default {
    name: "TheShowFind",
    components: {Link, HeaderPage, Splide, SplideSlide,},
    props: ['fullName', 'findCity','details', 'amount_check', 'id', 'photos', 'amount_piece'],
    data() {
        return {
            images: this.photos,
            currentIndex: 0,
        }
    },

    computed: {
        currentImg() {
            return this.images[Math.abs(this.currentIndex) % this.images.length];
        }
    },
    methods: {
        showImage(file) {
            return "/storage/findImages/" + file;
        },

        next() {
            this.currentIndex += 1
        },
        prev() {
            this.currentIndex -= 1
        }
    },
    setup(){
        const photos = usePage().props.value.photos;

        return {
            photos
        }
    }
}
</script>

<style scoped>
.splide__arrow {
    background: #1a202c !important;
}
</style>
