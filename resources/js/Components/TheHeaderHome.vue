<template>
    <section class="text-blueGray-700 bg-white">
        <div class="container flex flex-col items-center px-5 py-8 mx-auto  md:flex-row lg:px-28">
            <div class="flex flex-col items-start w-full pt-0 mb-16 text-left  lg:flex-grow md:w-1/2 xl:mr-20 md:pr-24 md:mb-0">
                <h1 class="mb-8 text-2xl font-black tracking-tighter text-black  md:text-5xl title-font">Retrouvez vos pièces grâce aux autres</h1>
                <p class="mb-8 text-base leading-relaxed text-left text-blueGray-600"> N'oublier pas que vous pourriez etre dans la même situation!. </p>
                <div class="flex flex-wrap gap-4 mt-8 text-center">
                    <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium text-white cursor-pointer rounded shadow bg-blue-600 sm:w-auto active:bg-blue-500 hover:bg-blue-700 hover:text-white focus:outline-none focus:ring"
                       :href="route('find.register')">
                        Enregister une pièce
                    </NavLink>

                    <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium bg-white cursor-pointer rounded shadow text-blue-600 sm:w-auto hover:text-blue-700 active:text-blue-500 focus:outline-none focus:ring"
                       :href="route('found.search')">
                        Rechercher une pièce
                    </NavLink>
                </div>
            </div>
            <div class="w-full lg:w-5/6 lg:max-w-lg md:w-1/2">
                <img class="object-cover object-center rounded-lg" alt="hero" src="images/hero.svg">
            </div>
        </div>
    </section>
</template>

<script>
import NavLink from "@/Components/NavLink";
export default {
    name: "TheHeaderHome",
    components: {NavLink}
}
</script>

<style scoped>

</style>
