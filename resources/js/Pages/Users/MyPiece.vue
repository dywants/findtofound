<template>
    <Dashboard>
        <Head title="Ma pièce retrouvée" />
        <div class="max-w-screen-xl p-4 mx-auto mt-8">
            <!-- component -->
                <div class="container m-auto px-6 md:px-12 lg:px-20">
                    <div v-if="status === 'COMPLETED'" class="m-auto -space-y-4 items-center justify-center md:flex md:space-y-0 md:-space-x-4 xl:w-10/12">
                        <div class="relative z-10 -mx-4 group md:w-6/12 md:mx-0 lg:w-5/12">
                            <div aria-hidden="true" class="absolute top-0 w-full h-full rounded-2xl bg-white shadow-xl transition duration-500 group-hover:scale-105 lg:group-hover:scale-110"></div>
                            <div class="relative p-6 space-y-6 lg:p-8">
                                <h3 class="text-3xl text-gray-700 font-semibold text-center">{{ piece.thefind.fullName }}</h3>
                                <div>
                                    <div class="relative flex justify-around">
                                        <div class="flex items-end">
                                            <img :src="showImage() + piece.thefind.photos"
                                                 class="w-44 h-44 object-cover" :alt=piece.thefind.fullName />
                                        </div>
                                    </div>
                                </div>
                                <p class="text-[17px] font-black">Information sur le lieu de la trouvaille</p>
                                <ul role="list" class="w-max space-y-4 pb-6 m-auto text-gray-600">
                                    <li class="space-x-2">
                                        <span class="text-purple-500 font-semibold">Ville:</span>
                                        <span>{{ piece.thefind.findCity }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span class="text-purple-500 font-semibold">Quartier:</span>
                                        <span>{{ piece.thefind.ward }}</span>
                                    </li>
                                    <li v-if="piece.thefind.details" class="space-y-2 block">
                                        <p>{{ piece.thefind.details }}</p>
                                    </li>
                                </ul>

                                <form method="post" @submit.prevent="submitted">
                                    <button v-if="piece.thefind.approval_status == 0" type="submit" title="Submit" class="block w-full py-3 px-6 text-center text-white rounded-xl transition bg-purple-600 hover:bg-purple-700 active:bg-purple-800 focus:bg-indigo-600">
                                        J'ai recuperer ma pièce
                                    </button>
                                    <button v-else disabled class="block w-full py-3 px-6 text-center text-white rounded-xl transition bg-gray-600 ">
                                        Pièce retrouvée et recuperer
                                    </button>
                                </form>

                            </div>
                        </div>

                        <div class="relative group md:w-6/12 lg:w-7/12">
                            <div aria-hidden="true" class="absolute top-0 w-full h-full rounded-2xl bg-white shadow-lg transition duration-500 group-hover:scale-105"></div>
                            <div class="relative p-6 pt-16 md:p-8 md:pl-12 md:rounded-r-2xl lg:pl-20 lg:p-16">
                                <h3 class="text-[26px] font-semibold">Information sur le finder</h3>
                                <ul role="list" class="space-y-4 py-6 text-gray-600">
                                    <li class="space-x-2">
                                        <span class="text-purple-500 font-semibold">Nom:</span>
                                        <span>{{ piece.thefind.user.name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span class="text-purple-500 font-semibold">Telephone</span>
                                        <span>{{ piece.thefind.user.profile.phone_number }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span class="text-purple-500 font-semibold">Ville de residence</span>
                                        <span>{{ piece.thefind.user.profile.city }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-xl">
                        <p>Bien vouloir effectué le pairment afin d'acceder a ces informations</p>
                    </div>
                </div>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Pages/Dashboard'
import { Head } from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";
import { usePage } from '@inertiajs/inertia-vue3'
import {reactive} from 'vue';

let props = defineProps({
    piece: Object,
    status:Object,
});

const form = reactive({
    _token: usePage().props.value.csrf_token,
    _method: "PUT"
});

const thefindId = props.piece.thefind.id

function submitted(){
    Inertia.post(route('find.update', {'thefind': thefindId}), form, {
        forceFormData: true
    })
}

function showImage() {
    return "/storage/findImages/";
}

</script>

<style scoped>

</style>
