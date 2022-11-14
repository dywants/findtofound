<template>

    <Head title="Recherche pièce" />
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Recherchez votre pièce perdues
            </h2>
        </template>
    </HeaderPage>

    <div class="container max-w-5xl p-4 mx-auto mt-8">

        <form>
            <div class="relative w-full">
                <input type="search" @keyup.esc="reset()" @blur="reset()" v-model="term" id="search"
                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Entrez votre nom " required="">
                <button type="submit"
                    class="absolute top-0 right-0 p-2.5 text-sm font-medium
                    text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4
                    focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <button v-if="term" @click="reset()"
                    class="absolute top-0 right-10 p-3 text-orange-500 hover:text-orange-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </form>

        <div v-if="term" class="z-10 my-10 w-full flex flex-col rounded-b-lg bg-white space-y-3">
            <div v-for="(result, index) in results" :key="index">
                <Link :href="result.item.link" @mousedown.prevent>
                <div class="mx-auto flex flex-wrap cursor-pointer hover:bg-orange-50 mb-2 p-4 rounded-sm border">
                    <div class="border md:w-1/2">
                        <img :alt=result.item.fullName class=" w-full object-contain transition duration-50 rounded-md"
                            loading="lazy" :src="showImage(result.item.photos)">
                    </div>

                    <div class="md:w-1/2 border w-full md:pl-10 md:py-6 mt-6 md:mt-0 p-4">
                        <h2 class="text-gray-900 text-3xl title-font font-medium mb-1" style="cursor: auto;">{{
                                result.item.fullName
                        }}</h2>
                        <span>{{ result.item.created_at }}</span>
                        <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ result.item.findCity }}</p>
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ result.item.details }}</p>
                        <div class="text-right">
                            <span class="text-sm text-gray-500 mt-4 line-clamp-2 px-1.5
                            py-1 border border-gray-600 rounded-md mt-6 bg-gray-200">{{ result.item.amount_check.amount
                                    == 0 ? result.item.amount_piece.formatted : result.item.amount_check.formatted
                            }}</span>
                        </div>
                    </div>
                </div>
                </Link>
            </div>
            <div v-if="!results.length" class="p-4 w-full rounded-b-lg shadow my-0 text-sm">
                Pas de pièce trouvée pour: <strong>{{ term }}.</strong>
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
            keys: ['fullName', 'findCity']
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
.space-y-4 {
    padding: 25px;
}
</style>
