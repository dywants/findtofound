<template>
    <Head title="Recherche pièce"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Recherchez votre pièce perdues
            </h2>
        </template>
    </HeaderPage>

    <div class="max-w-screen-xl p-4 mx-auto mt-8">

        <form>
            <div class="flex">
                <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-gray-300">Your Email</label>
                <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">All categories <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg></button>
                <div id="dropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(570px, 294px);">
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                        <li>
                            <button type="button" class="inline-flex py-2 px-4 w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mockups</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex py-2 px-4 w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Templates</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex py-2 px-4 w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Design</button>
                        </li>
                        <li>
                            <button type="button" class="inline-flex py-2 px-4 w-full hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Logos</button>
                        </li>
                    </ul>
                </div>
                <div class="relative w-full">
                    <input type="search"
                           @keyup.esc="reset()"
                           @blur="reset()"
                           v-model="term"
                           id="search"
                           class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Recherche pièce..." required="">
                    <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium
                    text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4
                    focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    <button v-if="term" @click="reset()" class="absolute top-0 right-10 p-3 text-orange-500 hover:text-orange-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </form>

        <div v-if="term" class="z-10 my-10 w-full flex flex-col rounded-b-lg bg-white space-y-3">
            <div v-for="(result, index) in results" :key="index">
                <Link :href="result.item.link"  @mousedown.prevent>
                    <div class="flex bg-white border border-gray-300 shadow-lg rounded-md overflow-hidden items-center justify-start cursor-pointer hover:bg-orange-50">
                        <div class="relative w-32 h-auto flex-shrink-0">
                            <div class="pl-4 w-full h-full flex items-center justify-center">
                                <img :alt=result.item.fullName
                                     class="w-full h-full object-cover object-center transition duration-50"
                                     loading="lazy" :src=result.item.photos>
                            </div>
                        </div>

                        <div class="p-4 space-y-4 w-full">
                            <div class="flex justify-between items-center">
                                <h4 class="text-lg leading-6 font-semibold font-sans text-left text-skin-inverted group-hover:text-skin-primary">{{ result.item.fullName }}</h4>
                                <span>{{ result.item.created_at }}</span>
                            </div>
                            <p class="text-sm text-gray-500 line-clamp-2">{{ result.item.findCity }}</p>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2 leading-4">{{ result.item.details }}</p>
                            <div class="text-right">
                                  <span class="text-sm text-gray-500 mt-4 line-clamp-2 px-1.5
                            py-1 border border-gray-600 rounded-md mt-6 bg-gray-200">{{ result.item.amount_check.formatted }}</span>
                            </div>
                        </div>
                    </div>
                </Link >
            </div>
            <div v-if="!results.length" class="p-4 w-full rounded-b-lg shadow my-0 text-sm">
                Pas de pièce trouvée pour: <strong>{{ term }}.</strong>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';
import Fuse from 'fuse.js';

export default {
    name: "TheSearch",
    components: {HeaderPage,Link},
    props: ['formatted'],
    data() {
        return {
            term: null,
            fuse: null
        }
    },
    computed: {
        results() {
            return this.term ? this.fuse.search(this.term).slice(0, 8) : [];
        }
    },
    created() {
        this.fuse = new Fuse(this.$page.props.searchItems, {
            keys: ['fullName', 'findCity']
        })
    },
    methods: {
        reset() {
            this.term = null;
        }
    }
}
</script>

<style scoped>

</style>
