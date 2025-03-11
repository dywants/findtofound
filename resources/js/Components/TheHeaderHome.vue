<template>
    <section class="text-blueGray-700 bg-tahiti-dark">
        <div class="container py-4 mx-auto">
            <Splide :options="splideOptions">
                <SplideSlide>
                    <div class="flex flex-col items-center md:flex-row lg:px-28 relative">
                        <div
                            class="flex flex-col items-start w-full pt-0 mb-16 text-left lg:flex-grow md:flex-1 xl:mr-20 md:pr-8 md:mb-0">
                            <div class="px-8 md:px-0 mx-auto">
                                <p class="text">La solution pour retrouver vos documents perdus</p>
                                <h1
                                    class="mb-8 mt-4 text-2xl font-black tracking-tighter text-white md:text-5xl title-font">
                                    Document <span class="text-tahiti-primary">perdu ?</span></h1>
                                <p class="text">Retrouvez rapidement vos documents grâce à notre communauté
                                    bienveillante. Des milliers de personnes s'entraident chaque jour sur notre
                                    plateforme.</p>
                                <div class="flex flex-wrap gap-4 mt-8 text-center">
                                    <NavLink
                                        class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium text-tahiti-dark cursor-pointer rounded shadow bg-tahiti-primary sm:w-auto hover:bg-tahiti-primary hover:opacity-75 focus:outline-none focus:ring"
                                        :href="route('find.register')">
                                        J'ai trouvé un document
                                    </NavLink>

                                    <NavLink
                                        class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium bg-transparent border-white cursor-pointer rounded shadow text-white sm:w-auto focus:outline-none focus:ring"
                                        :href="route('found.search')">
                                        Je recherche un document
                                    </NavLink>
                                </div>
                            </div>
                            <div class="bottom-0 left-0 absolute">
                                <p class="text mb-4">Documents pris en charge</p>
                                <div class="items-elements">
                                    <p class="item">Passeport • Carte d'identité • Acte de naissance • Permis de
                                        conduire • Diplôme</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-5/6 lg:max-w-lg md:flex-1 bg-cover py-10">
                            <img class="object-cover object-center rounded-lg" alt="hero" src="images/toseachfind.png">
                        </div>
                    </div>
                </SplideSlide>
                <SplideSlide>
                    <div class="flex flex-col items-center md:flex-row lg:px-28 relative">
                        <div
                            class="flex flex-col items-start w-full pt-0 mb-16 text-left lg:flex-grow md:flex-1 xl:mr-20 md:pr-8 md:mb-0">
                            <div class="px-8 md:px-0 mx-auto">
                                <p class="text">Ensemble, facilitons la restitution des documents perdus</p>
                                <h1
                                    class="mb-8 mt-4 text-2xl font-black tracking-tighter text-white md:text-5xl title-font">
                                    Document <span class="text-tahiti-primary">trouvé ?</span></h1>
                                <p class="text">Aidez quelqu'un à retrouver son document en quelques clics. Votre geste
                                    peut faire une grande différence dans la vie d'une personne.</p>
                                <div class="flex flex-wrap gap-4 mt-8 text-center">
                                    <NavLink
                                        class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium text-tahiti-dark cursor-pointer rounded shadow bg-tahiti-primary sm:w-auto hover:bg-tahiti-primary hover:opacity-75 focus:outline-none focus:ring"
                                        :href="route('find.register')">
                                        J'ai trouvé un document
                                    </NavLink>

                                    <NavLink
                                        class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium bg-transparent border-white cursor-pointer rounded shadow text-white sm:w-auto focus:outline-none focus:ring"
                                        :href="route('found.search')">
                                        Je recherche un document
                                    </NavLink>
                                </div>
                            </div>
                            <div class="bottom-0 left-0 absolute">
                                <p class="text mb-4">Documents pris en charge</p>
                                <div class="items-elements">
                                    <p class="item">Passeport • Carte d'identité • Acte de naissance • Permis de
                                        conduire • Diplôme</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-5/6 lg:max-w-lg md:flex-1 bg-cover py-10">
                            <img class="object-cover object-center rounded-lg" alt="hero" src="images/toseachfind2.png">
                        </div>
                    </div>
                </SplideSlide>
                <SplideSlide>
                    <div class="flex flex-col items-center md:flex-row lg:px-28 relative py-16">
                        <div
                            class="flex flex-col items-start w-full pt-0 mb-16 text-left lg:flex-grow md:flex-1 xl:mr-20 md:pr-8 md:mb-0 ">
                            <div class="px-8 md:px-0 mx-auto space-y-6">
                                <!-- Badge Nouveau -->
                                <div
                                    class="inline-flex items-center px-3 py-1.5 rounded-full bg-tahiti-primary/20 text-tahiti-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium">Nouveau</span>
                                </div>

                                <!-- Texte d'introduction -->
                                <div class="space-y-4 mt-4">
                                    <p class="text text-tahiti-primary/90 font-semibold">Protégez vos documents contre
                                        la perte ou le vol</p>
                                    <h1
                                        class="text-2xl font-black tracking-tighter text-white md:text-5xl title-font leading-tight">
                                        Protection par <span class="text-tahiti-primary">filigrane</span>
                                    </h1>
                                    <p class="text leading-relaxed">Sécurisez vos documents importants grâce à notre
                                        technologie de filigrane numérique. Rendez vos documents facilement
                                        identifiables en cas de perte, sans altérer leur apparence.</p>
                                </div>

                                <!-- Points clés -->
                                <div
                                    class="flex flex-col space-y-4 mt-4 bg-tahiti-dark/30 p-4 rounded-lg backdrop-blur-sm">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-6 w-6 text-tahiti-primary bg-tahiti-primary/10 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="ml-3 text-sm md:text-base text-white font-medium">Filigrane
                                            invisible préservant l'aspect du document</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-6 w-6 text-tahiti-primary bg-tahiti-primary/10 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="ml-3 text-sm md:text-base text-white font-medium">Identifiant
                                            unique pour chaque document</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-6 w-6 text-tahiti-primary bg-tahiti-primary/10 rounded-full p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="ml-3 text-sm md:text-base text-white font-medium">Récupération
                                            simplifiée en cas de perte</span>
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="flex flex-wrap gap-4 mt-16 pt-2">
                                    <NavLink
                                        class="block w-full px-6 py-3 text-sm font-medium text-tahiti-dark cursor-pointer rounded-lg shadow-lg bg-tahiti-primary sm:w-auto hover:bg-tahiti-primary hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-tahiti-primary focus:ring-offset-2 transition-all duration-200 transform hover:scale-105"
                                        :href="route('found.search')">
                                        <span class="flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Protéger mes documents
                                        </span>
                                    </NavLink>

                                    <NavLink
                                        class="block w-full px-6 py-3 text-sm font-medium bg-transparent border border-white cursor-pointer rounded-lg shadow text-white sm:w-auto hover:bg-white/10 focus:outline-none focus:ring transition-all duration-200"
                                        href="#">
                                        <span class="flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            En savoir plus
                                        </span>
                                    </NavLink>
                                </div>
                            </div>
                        </div>

                        <!-- Partie image -->
                        <div class="w-full lg:w-5/6 lg:max-w-lg md:flex-1 bg-cover py-10 relative md:ml-6">
                            <div
                                class="absolute inset-0 bg-gradient-to-tr from-tahiti-primary/20 to-transparent rounded-lg">
                            </div>
                            <div class="relative overflow-hidden rounded-lg shadow-2xl">
                                <!-- Badge -->
                                <div
                                    class="absolute -top-2 -right-2 bg-tahiti-primary text-white text-xs px-3 py-1.5 rounded-full shadow-lg transform rotate-6 z-10">
                                    <span class="font-bold">Technologie sécurisée</span>
                                </div>

                                <!-- Image -->
                                <img class="object-cover object-center w-full h-auto rounded-lg"
                                    alt="Protection par filigrane" src="images/pieces.png">

                                <!-- Overlay filigrane -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="absolute inset-0 bg-tahiti-dark opacity-30 rounded-lg"></div>
                                    <div
                                        class="relative bg-tahiti-dark/70 px-5 py-3 rounded-lg backdrop-blur-sm transform -rotate-3 shadow-lg border border-tahiti-primary/30">
                                        <p class="text-tahiti-primary font-bold text-xl tracking-wider">PROTÉGÉ</p>
                                        <p class="text-white text-xs mt-1">Filigrane DocuTrace #12345</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </SplideSlide>
            </Splide>
        </div>
    </section>
</template>

<script setup>
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';
import NavLink from "@/Components/NavLink";

const splideOptions = {
    type: 'loop',
    perPage: 1,
    autoplay: true,
    interval: 3500,
    arrows: false,
    pagination: false
};
</script>

<style scoped>
.text {
    font-style: normal;
    font-weight: 500;
    font-size: 20px;
    line-height: 27px;
    color: #FFFFFF;
}

.items-elements {
    backdrop-filter: blur(2px);
    border-radius: 0px 8px 0px 0px;
    padding: 10px 0;
    position: relative;
}

.bg-items {
    background: rgba(238, 238, 238, 0.05);
}

.items-elements:after {
    position: absolute;
    left: 5.73%;
    right: 6.32%;
    top: 53%;
    bottom: 47%;
    border: 1px dashed #B1B1B1;
}

.item {
    font-style: normal;
    font-weight: 400;
    font-size: 17px;
    line-height: 31px;
    color: #B1B1B1;
}
</style>
