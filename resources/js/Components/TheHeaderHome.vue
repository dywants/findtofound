<template>
    <section class="text-blueGray-700 bg-tahiti-dark">
        <div class="container py-4 mx-auto">
            <Splide options="options">
                <SplideSlide>
                    <div class="flex flex-col items-center md:flex-row lg:px-28 relative">
                        <div class="flex flex-col items-start w-full pt-0 mb-16 text-left lg:flex-grow md:flex-1 xl:mr-20 md:pr-8 md:mb-0">
                            <div class="px-8 md:px-0 mx-auto" >
                                <p class="text">Retrouvez vos pièces grâce aux autres</p>
                                <h1 class="mb-8 mt-4 text-2xl font-black tracking-tighter text-white md:text-5xl title-font">Une pièce <span class="text-tahiti-primary">égarées</span> </h1>
                                <p class="text">Lorem ipsum dolor sit amet consectetur. Luctus laoreet pretium est eget nunc.
                                    Eget eget bibendum eget mus. Non posuere luctus sed pharetra nisi quis. Egestas dolor quam pellentesque.</p>
                                <!--                <p class="mb-8 text-base leading-relaxed text-left text-blueGray-600"> N'oublier pas que vous pourriez etre dans la même situation!. </p>-->
                                <div class="flex flex-wrap gap-4 mt-8 text-center">
                                    <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium text-tahiti-dark cursor-pointer rounded shadow bg-tahiti-primary sm:w-auto hover:bg-tahiti-primary hover:opacity-75 focus:outline-none focus:ring"
                                             :href="route('find.register')">
                                        Enregistrer une pièce trouvée
                                    </NavLink>

                                    <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium bg-transparent border-white cursor-pointer rounded shadow text-white sm:w-auto focus:outline-none focus:ring"
                                             :href="route('found.search')">
                                        Rechercher ma pièce perdue
                                    </NavLink>
                                </div>
                            </div>
                            <div class="bottom-0 left-0 absolute">
                                <p class="text mb-4 hidden md:block">Elements pris en charge</p>
                                <div class="items-elements md:hidden overflow-hidden bg-[#2E2E2E]">
                                    <p class="item">passport --- carte d'identité --- acte de naissance ---</p>
                                </div>
                                <div class="items-elements bg-items hidden md:block">
                                    <p class="item">sport --- carte d'identité --- acte de naissance --- permis de conduire ---Dip</p>
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
                        <div class="flex flex-col items-start w-full pt-0 mb-16 text-left lg:flex-grow md:flex-1 xl:mr-20 md:pr-8 md:mb-0">
                            <div class="px-8 md:px-0 mx-auto">
                                <p class="text">Aidez les autres à retrouver leurs pièces</p>
                                <h1 class="mb-8 mt-4 text-2xl font-black tracking-tighter text-white md:text-5xl title-font">Une pièce <span class="text-tahiti-primary">égarées</span> </h1>
                                <p class="text">Lorem ipsum dolor sit amet consectetur. Luctus laoreet pretium est eget nunc.
                                    Eget eget bibendum eget mus. Non posuere luctus sed pharetra nisi quis. Egestas dolor quam pellentesque.</p>
                                <!--                <p class="mb-8 text-base leading-relaxed text-left text-blueGray-600"> N'oublier pas que vous pourriez etre dans la même situation!. </p>-->
                                <div class="flex flex-wrap gap-4 mt-8 text-center">
                                    <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium text-tahiti-dark cursor-pointer rounded shadow bg-tahiti-primary sm:w-auto hover:bg-tahiti-primary hover:opacity-75 focus:outline-none focus:ring"
                                             :href="route('find.register')">
                                        Enregistrer une pièce trouvée
                                    </NavLink>

                                    <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium bg-transparent border-white cursor-pointer rounded shadow text-white sm:w-auto focus:outline-none focus:ring"
                                             :href="route('found.search')">
                                        Rechercher ma pièce perdue
                                    </NavLink>
                                </div>
                            </div>
                            <div class="bottom-0 left-0 absolute">
                                <p class="text mb-4">Elements pris en charge</p>
                                <div class="items-elements">
                                    <p class="item">sport --- carte d'identité --- acte de naissance --- permis de conduire ---Dip</p>
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

<script>
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';
import { defineComponent } from 'vue';
import NavLink from "@/Components/NavLink";
export default defineComponent( {
    components: {NavLink, Splide, SplideSlide},
    setup() {
        const options = {
            rewind: true,
            gap   : '1rem',
        };

        return { options };
    },
})
</script>

<style scoped>
.text{
    font-style: normal;
    font-weight: 500;
    font-size: 20px;
    line-height: 27px;
    color: #FFFFFF;
}

.items-elements{
    backdrop-filter: blur(2px);
    border-radius: 0px 8px 0px 0px;
    padding: 10px 0 ;
    position: relative;
}

.bg-items{
    background: rgba(238, 238, 238, 0.05);
}

.items-elements:after{
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
