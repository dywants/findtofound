<template>
    <Head >
        <title>Accueil</title>
        <meta type="description" content="Plate-forme de recherche de pièce officiel ">
    </Head>
    <!-- component -->
    <div class="py-16 bg-gray-50 overflow-hidden">
        <div class="container m-auto px-6 space-y-8 text-gray-500 md:px-12">
            <div>
                <span class="text-gray-600 text-lg font-semibold">Information utile</span>
                <h2 class="mt-4 text-2xl text-gray-900 font-bold md:text-4xl">Comment ça marche?</h2>
            </div>
            <div class="mt-16 grid border divide-x divide-y rounded-xl overflow-hidden sm:grid-cols-2 lg:divide-y-0 lg:grid-cols-3 xl:grid-cols-4">
                <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/icons/register.svg" class="w-10 h-10 object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600">Enregistrer une pièce</h5>
                            <p class="text-sm text-gray-600">Lorsque vous trouvez une pièce, enregistrer la sur <em class="font-medium text-[17px]">findtofound</em> via notre formulaire en cliquant sur
                                <span class="text-[17px] font-semibold">Enregistrer pièce</span></p>
                        </div>
                        <a href="#" class="flex justify-between items-center group-hover:text-yellow-600">
                            <span class="text-sm font-medium">A vous de jouer!</span>
                            <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                        </a>
                    </div>
                </div>
                <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/icons/search.svg" class="w-10 h-10 object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600">Retrouver une pièce</h5>
                            <p class="text-sm text-gray-600">Si vous etes a la recherche de votre pièce perdues, vous pouvez la retrouver
                                via notre formulaire de recherche en cliquant sur <span class="text-[17px] font-semibold">Recherche pièce</span></p>
                        </div>
                        <a href="#" class="flex justify-between items-center group-hover:text-yellow-600">
                            <span class="text-sm">A vous de jouer!</span>
                            <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                        </a>
                    </div>
                </div>
                <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/icons/mise-relation.svg" class="w-10 h-10 object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600">Mise en relation</h5>
                            <p class="text-sm text-gray-600">Lorsque vous identifiez votre pièce perdues sur <em class="font-medium text-[17px]">findtofound</em>, nous vous mettons
                                en relation direct avec celui ayant retrouver votre pièce ou nous vous donnons
                                les informations precises du lieu où se trouve votre pièce.</p>
                        </div>
                    </div>
                </div>
                <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                    <div class="relative p-8 space-y-8">
                        <img src="images/icons/validation.svg" class="w-10 h-10 object-contain" width="512" height="512" alt="burger illustration">

                        <div class="space-y-2">
                            <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600">Validation</h5>
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
</script>

<style scoped>

</style>
