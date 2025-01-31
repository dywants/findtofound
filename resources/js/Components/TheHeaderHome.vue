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
                                <p class="text">Retrouvez rapidement vos documents grâce à notre communauté bienveillante. Des milliers de personnes s'entraident chaque jour sur notre plateforme.</p>
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
                                    <p class="item">Passeport • Carte d'identité • Acte de naissance • Permis de conduire • Diplôme</p>
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
                                <p class="text">Aidez quelqu'un à retrouver son document en quelques clics. Votre geste peut faire une grande différence dans la vie d'une personne.</p>
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
                                    <p class="item">Passeport • Carte d'identité • Acte de naissance • Permis de conduire • Diplôme</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full lg:w-5/6 lg:max-w-lg md:flex-1 bg-cover py-10">
                            <img class="object-cover object-center rounded-lg" alt="hero" src="images/toseachfind2.png">
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
    interval: 5000,
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
