<template>
    <Head >
        <title>Accueil</title>
        <meta type="description" content="Plate-forme de recherche de pièce officiel ">
    </Head>
    <!-- component -->
    <div class="container m-auto px-6 space-y-8 text-gray-500 md:px-12">
            <div class="flex flex-wrap gap-8 items-center py-10">
                <div class="w-full md:flex-1">
                   <p class="text-tahiti-primary text-sm">----- Nous avons besoin l'un l'autre.</p>
                    <h2 class="font-extrabold text-3xl leading-7 my-4">Plus rien ne se perd si nous mettons tous la main</h2>
                    <p>
                        <span class="text-semibold">Tosearch<span class="text-tahiti-primary">Find</span> </span> est une plateforme d’entraide. Tout le monde peux changer la vie d’une autre personne, pas besoin d’être un super heros.
                    </p>
                    <p class="mt-1">
                        Il suffit juste de faire un petit geste de solidarité: Signalez une pièce retrouvée.
                        Une pièce trouvée? Enregistrez-la et sauver une vie.
                        Une pièce égarée? Retrouvez-la maintenant.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8 text-center">
                        <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium text-tahiti-dark cursor-pointer rounded shadow bg-tahiti-primary sm:w-auto hover:bg-tahiti-primary hover:opacity-75 focus:outline-none focus:ring"
                                 :href="route('find.register')">
                            Enregistrer une pièce trouvée
                        </NavLink>

                        <NavLink class="block w-full px-5 pt-2.5 pb-2 text-sm font-medium bg-transparent border-black cursor-pointer rounded shadow text-black sm:w-auto focus:outline-none focus:ring"
                                 :href="route('found.search')">
                            Rechercher ma pièce perdue
                        </NavLink>
                    </div>
                </div>
                <div class="w-full md:flex-1">
                    <img class="object-cover object-center rounded-lg" alt="hero" src="images/pieces.png">
                </div>
            </div>
    </div>
    
    <div class="py-16 bg-gray-50 overflow-hidden bg-[#1FBDEB21]">
        <div class="container m-auto px-6 space-y-8 text-gray-500 md:px-12">
            <div>
                <span class="text-gray-600 text-lg font-semibold">Information utile</span>
                <h2 class="mt-4 text-2xl text-gray-900 font-bold md:text-4xl">Comment ça marche?</h2>
            </div>
            <div class="mt-16 grid gap-4 overflow-hidden sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <div class="card relative group bg-white rounded-md transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/bro.png" class="w-full h-[210px] object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-semibold transition group-hover:text-[#1FBDEB]">Enregistrer une pièce</h5>
                            <p class="text-sm text-gray-600">Lorsque vous trouvez une pièce, enregistrer la sur <em class="font-medium text-[17px]">findtofound</em> via notre formulaire en cliquant sur
                                <span class="text-[17px] font-semibold">Enregistrer pièce</span></p>
                        </div>
                        <a href="#" class="flex justify-between items-center group-hover:text-[#1FBDEB]">
                            <span class="text-sm font-medium">A vous de jouer!</span>
                            <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                        </a>
                    </div>
                </div>
                <div class="card relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/search.png" class="w-full h-[210px] object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-semibold transition group-hover:text-[#1FBDEB]">Rechercher une pièce</h5>
                            <p class="text-sm text-gray-600">Si vous etes a la recherche de votre pièce perdues, vous pouvez la retrouver
                                via notre formulaire de recherche en cliquant sur <span class="text-[17px] font-semibold">Recherche pièce</span></p>
                        </div>
                        <a href="#" class="flex justify-between items-center group-hover:text-[#1FBDEB]">
                            <span class="text-sm">A vous de jouer!</span>
                            <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                        </a>
                    </div>
                </div>
                <div class="card relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/rafiki.png" class="w-full h-[210px] object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-semibold transition group-hover:text-[#1FBDEB]">Mise en relation</h5>
                            <p class="text-sm text-gray-600">Lorsque vous identifiez votre pièce perdues sur <em class="font-medium text-[17px]">findtofound</em>, nous vous mettons
                                en relation direct avec celui ayant retrouver votre pièce ou nous vous donnons
                                les informations precises du lieu où se trouve votre pièce.</p>
                        </div>
                    </div>
                </div>
                <div class="card relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/amico.png" class="w-full h-[210px] object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-semibold transition group-hover:text-[#1FBDEB]">Validation</h5>
                            <p class="text-sm text-gray-600">Lorque vous entrez en possession de votre pièce retrouvée,
                                nous vous encourageont vivement de valider l'action sur votre panel d'administration, ce qui nous permettra de retirer la piece du circuit de recherche et aussi au <em class="font-medium text-[17px]">finder</em> d'etre recompenser</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import NavLink from "@/Components/NavLink";
</script>

<style scoped>
.card{
    border-radius:45px;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;
}
</style>
