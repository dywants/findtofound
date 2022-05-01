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

        <div class="2xl:container 2xl:mx-auto md:py-12 lg:px-20 md:px-6 py-9 px-4">
            <div id="viewerBox" class="lg:p-10 md:p-6 p-4 bg-white dark:bg-gray-900">
                <div class="mt-3 md:mt-4 lg:mt-0 flex flex-col lg:flex-row items-strech justify-center lg:space-x-8">
                    <div
                        class="lg:w-1/2 flex justify-between items-strech bg-gray-50  px-2 py-20 md:py-6 md:px-6 lg:py-24">
                        <div class="flex items-center">
                            <button onclick="goPrev()" aria-label="slide back"
                                    class="focus:outline-none focus:ring-2 focus:ring-gray-800 hover:bg-gray-100">
                                <svg class="w-10 h-10 lg:w-16 lg:h-16" viewBox="0 0 64 64" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M40 16L24 32L40 48" stroke="#1F2937" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
<!--                        <div class="slider">-->
<!--                            <div class="slide-ana lg:relative">-->
                                <div class="w-full h-full">
                                    <img :src="showImage() + photos"
                                        class="w-full h-full object-cover" :alt=fullName />
                                </div>
<!--                            </div>-->
<!--                        </div>-->
                        <div class="flex items-center">
                            <button onclick="goNext()" aria-label="slide forward"
                                    class="focus:outline-none focus:ring-2 focus:ring-gray-800 hover:bg-gray-100">
                                <svg class="w-10 h-10 lg:w-16 lg:h-16" viewBox="0 0 64 64" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24 16L40 32L24 48" stroke="#1F2937" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
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
                                {{ amount_check.formatted }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';
let slides = document.querySelectorAll(".slide-ana>div");
let slideSayisi = slides.length;
let prev = document.getElementById("prev");
let next = document.getElementById("next");
for (let index = 0; index < slides.length; index++) {
    const element = slides[index];
    element.style.transform = "translateX(" + 100 * index + "%)";
}
let loop = 0 + 1000 * slideSayisi;

function goNext() {
    loop++;
    for (let index = 0; index < slides.length; index++) {
        const element = slides[index];
        element.style.transform =
            "translateX(" + 100 * (index - (loop % slideSayisi)) + "%)";
    }
}

function goPrev() {
    loop--;
    for (let index = 0; index < slides.length; index++) {
        const element = slides[index];
        element.style.transform =
            "translateX(" + 100 * (index - (loop % slideSayisi)) + "%)";
    }
}

function openView() {
    document.getElementById("viewerButton").classList.add("hidden");
    document.getElementById("viewerBox").classList.remove("hidden");
}
function closeView() {
    document.getElementById("viewerBox").classList.add("hidden");
    document.getElementById("viewerButton").classList.remove("hidden");
}

export default {
    name: "TheShowFind",
    components: {Link, HeaderPage},
    props: ['fullName', 'findCity','details', 'amount_check', 'id', 'photos'],
    methods: {
        showImage() {
            return "/storage/findImages/";
        },
    },
}
</script>

<style scoped>
.slider {
    width: 200px;
    height: 400px;
    position: relative;
    overflow: hidden;
}

.slide-ana {
    height: 360px;
}

.slide-ana > div {
    width: 100%;
    height: 100%;
    position: absolute;
    transition: all 0.7s;
}

@media (min-width: 200px) and (max-width: 639px) {
    .slider {
        height: 300px;
        width: 170px;
    }
}
</style>
