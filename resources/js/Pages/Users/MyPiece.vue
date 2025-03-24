<template>
    <Layout>
        <Head title="Ma pièce retrouvée" />
        <div class="py-6 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Fil d'Ariane -->
                <div class="mb-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <Link :href="route('dashboard')" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                    Tableau de bord
                                </Link>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Suivi de pièce</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>

                <!-- Header avec titre -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Suivi de ma pièce</h1>
                    <p class="mt-1 text-gray-600">Consultez les détails de votre pièce retrouvée</p>
                </div>

                <!-- Contenu principal - Paiement complété -->
                <div v-if="piece && status === 'COMPLETED'" class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                    <div class="p-6 sm:p-8 bg-gradient-to-r from-purple-600 to-indigo-700 text-white">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-6 md:mb-0">
                                <h2 class="text-2xl font-bold mb-2">{{ piece.thefind.fullName }}</h2>
                                <p class="text-purple-100">Pièce retrouvée et disponible pour récupération</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Paiement complété
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                        <!-- Colonne 1: Photo et détails de la pièce -->
                        <div class="md:col-span-1 space-y-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Photo de la pièce</h3>
                                <div class="flex justify-center">
                                    <img :src="firstPhoto" 
                                         class="w-full max-w-xs h-auto object-cover rounded-lg shadow-md" 
                                         :alt="piece?.thefind?.fullName || 'Image de la pièce'" />
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Détails de la pièce</h3>
                                <ul class="space-y-3 text-gray-700">
                                    <li class="flex flex-wrap">
                                        <span class="font-medium w-28">Type:</span>
                                        <span>{{ getPieceType() }}</span>
                                    </li>
                                    <li class="flex flex-wrap">
                                        <span class="font-medium w-28">Nom complet:</span>
                                        <span>{{ piece.thefind.fullName }}</span>
                                    </li>
                                    <li v-if="piece.thefind.details" class="block">
                                        <span class="font-medium block mb-1">Description:</span>
                                        <p class="text-gray-600 bg-white p-3 rounded border border-gray-200">{{ piece.thefind.details }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Colonne 2: Lieu de trouvaille et informations du finder -->
                        <div class="md:col-span-2 space-y-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Lieu de la trouvaille</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <span class="text-purple-600 font-semibold block mb-1">Ville</span>
                                        <span class="text-lg">{{ piece.thefind.findCity }}</span>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <span class="text-purple-600 font-semibold block mb-1">Quartier</span>
                                        <span class="text-lg">{{ piece.thefind.ward }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations verrouillées -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informations sur le trouveur</h3>
                                <div class="bg-white p-5 rounded-lg shadow-sm relative overflow-hidden">
                                    <!-- Effet de verrouillage -->
                                    <div class="absolute inset-0 bg-gradient-to-b from-white/70 to-white/95 backdrop-blur-sm flex flex-col items-center justify-center z-10">
                                        <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                                            <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-center px-4 max-w-md">
                                            <h4 class="text-xl font-bold text-gray-900 mb-2">Coordonnées verrouillées</h4>
                                            <p class="text-gray-600 mb-6">Effectuez le paiement pour débloquer les coordonnées du trouveur et récupérer votre pièce.</p>
                                            
                                            <!-- Bouton de paiement amélioré et plus visible -->
                                            <Link :href="route('found.info', { thefind: piece.thefind_id })"
                                                class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-bold rounded-lg shadow-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-300 transform hover:scale-105 animate-pulse">
                                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Effectuer le paiement
                                            </Link>
                                            
                                            <p class="text-sm text-gray-500 mt-4">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Paiement sécurisé - Accès immédiat
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Contenu flouté en arrière-plan -->
                                    <div class="opacity-30 filter blur-[2px]">
                                        <div class="flex items-center mb-6">
                                            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-2xl font-bold">Trouveur</h4>
                                                <p class="text-gray-500">Coordonnées de contact</p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <span class="text-purple-600 font-semibold block mb-2">Téléphone</span>
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    <span class="text-lg font-medium">XXX XXX XXX</span>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <span class="text-purple-600 font-semibold block mb-2">Ville de résidence</span>
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span class="text-lg font-medium">Information masquée</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                                            <span class="text-purple-600 font-semibold block mb-2">Instructions spéciales</span>
                                            <p class="text-gray-600 bg-white p-3 rounded border border-gray-200">
                                                Les informations de contact du trouveur vous permettront de convenir d'un rendez-vous pour récupérer votre pièce. Effectuez le paiement pour y accéder.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Remplacer le bouton de paiement en bas par une bannière plus visible -->
                            <div class="bg-gradient-to-r from-green-100 to-emerald-100 p-6 rounded-lg border-2 border-green-300 shadow-md">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="mb-4 md:mb-0 md:mr-6">
                                        <h3 class="text-xl font-bold text-green-800 mb-2">Débloquer les coordonnées maintenant</h3>
                                        <p class="text-green-700">Paiement unique et sécurisé de <span class="font-bold">{{ piece.amount }} FCFA</span> pour accéder aux informations de contact</p>
                                    </div>
                                    <Link :href="route('found.info', { thefind: piece.thefind_id })"
                                        class="flex-shrink-0 py-4 px-8 text-center text-white rounded-lg transition bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 shadow-lg inline-flex items-center justify-center text-lg font-bold">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Payer maintenant
                                    </Link>
                                </div>
                                <div class="mt-4 flex items-center justify-center md:justify-start text-sm text-green-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Paiement 100% sécurisé - Accès immédiat aux coordonnées du trouveur
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prévisualisation avec paiement requis -->
                <div v-else-if="piece" class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                    <div class="p-6 sm:p-8 bg-gradient-to-r from-yellow-500 to-amber-600 text-white">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-6 md:mb-0">
                                <h2 class="text-2xl font-bold mb-2">{{ piece.thefind.fullName }}</h2>
                                <p class="text-yellow-100">Prévisualisation - Paiement requis pour accéder aux coordonnées</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white text-amber-700">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Accès limité
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
                        <!-- Colonne 1: Photo et détails de la pièce -->
                        <div class="md:col-span-1 space-y-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Photo de la pièce</h3>
                                <div class="flex justify-center">
                                    <img :src="firstPhoto" 
                                         class="w-full max-w-xs h-auto object-cover rounded-lg shadow-md" 
                                         :alt="piece?.thefind?.fullName || 'Image de la pièce'" />
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Détails de la pièce</h3>
                                <ul class="space-y-3 text-gray-700">
                                    <li class="flex flex-wrap">
                                        <span class="font-medium w-28">Type:</span>
                                        <span>{{ getPieceType() }}</span>
                                    </li>
                                    <li class="flex flex-wrap">
                                        <span class="font-medium w-28">Nom complet:</span>
                                        <span>{{ piece.thefind.fullName }}</span>
                                    </li>
                                    <li v-if="piece.thefind.details" class="block">
                                        <span class="font-medium block mb-1">Description:</span>
                                        <p class="text-gray-600 bg-white p-3 rounded border border-gray-200">{{ piece.thefind.details }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Colonne 2: Lieu de trouvaille et informations verrouillées -->
                        <div class="md:col-span-2 space-y-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Lieu de la trouvaille</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <span class="text-purple-600 font-semibold block mb-1">Ville</span>
                                        <span class="text-lg">{{ piece.thefind.findCity }}</span>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                        <span class="text-purple-600 font-semibold block mb-1">Quartier</span>
                                        <span class="text-lg">{{ piece.thefind.ward }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations verrouillées -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informations sur le trouveur</h3>
                                <div class="bg-white p-5 rounded-lg shadow-sm relative overflow-hidden">
                                    <!-- Effet de verrouillage -->
                                    <div class="absolute inset-0 bg-gradient-to-b from-white/70 to-white/95 backdrop-blur-sm flex flex-col items-center justify-center z-10">
                                        <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                                            <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-center px-4 max-w-md">
                                            <h4 class="text-xl font-bold text-gray-900 mb-2">Coordonnées verrouillées</h4>
                                            <p class="text-gray-600 mb-6">Effectuez le paiement pour débloquer les coordonnées du trouveur et récupérer votre pièce.</p>
                                            
                                            <!-- Bouton de paiement amélioré et plus visible -->
                                            <Link :href="route('found.info', { thefind: piece.thefind_id })"
                                                class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-bold rounded-lg shadow-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-300 transform hover:scale-105 animate-pulse">
                                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Effectuer le paiement
                                            </Link>
                                            
                                            <p class="text-sm text-gray-500 mt-4">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Paiement sécurisé - Accès immédiat
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Contenu flouté en arrière-plan -->
                                    <div class="opacity-30 filter blur-[2px]">
                                        <div class="flex items-center mb-6">
                                            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mr-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="text-2xl font-bold">Trouveur</h4>
                                                <p class="text-gray-500">Coordonnées de contact</p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <span class="text-purple-600 font-semibold block mb-2">Téléphone</span>
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    <span class="text-lg font-medium">XXX XXX XXX</span>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <span class="text-purple-600 font-semibold block mb-2">Ville de résidence</span>
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span class="text-lg font-medium">Information masquée</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                                            <span class="text-purple-600 font-semibold block mb-2">Instructions spéciales</span>
                                            <p class="text-gray-600 bg-white p-3 rounded border border-gray-200">
                                                Les informations de contact du trouveur vous permettront de convenir d'un rendez-vous pour récupérer votre pièce. Effectuez le paiement pour y accéder.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Remplacer le bouton de paiement en bas par une bannière plus visible -->
                            <div class="bg-gradient-to-r from-green-100 to-emerald-100 p-6 rounded-lg border-2 border-green-300 shadow-md">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="mb-4 md:mb-0 md:mr-6">
                                        <h3 class="text-xl font-bold text-green-800 mb-2">Débloquer les coordonnées maintenant</h3>
                                        <p class="text-green-700">Paiement unique et sécurisé de <span class="font-bold">{{ piece.amount }} FCFA</span> pour accéder aux informations de contact</p>
                                    </div>
                                    <Link :href="route('found.info', { thefind: piece.thefind_id })"
                                        class="flex-shrink-0 py-4 px-8 text-center text-white rounded-lg transition bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 shadow-lg inline-flex items-center justify-center text-lg font-bold">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Payer maintenant
                                    </Link>
                                </div>
                                <div class="mt-4 flex items-center justify-center md:justify-start text-sm text-green-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Paiement 100% sécurisé - Accès immédiat aux coordonnées du trouveur
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aucune pièce -->
                <div v-else class="bg-white rounded-xl shadow-sm overflow-hidden p-8 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Aucune pièce retrouvée</h2>
                        <p class="text-gray-600 mb-6">Vous n'avez pas encore retrouvé de pièces déclarées par d'autres utilisateurs.</p>
                        <Link :href="route('found.search')"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Rechercher des pièces
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Layouts/Layout';
import { Head, Link } from '@inertiajs/vue3';
import { usePage, router } from '@inertiajs/vue3'
import { reactive, onMounted, ref, computed } from 'vue';

let props = defineProps({
    piece: Object,
    status: String,
    photos: String
});

// Référence pour stocker le nom du type de pièce
const pieceTypeName = ref('');

// Tableau de correspondance des types de pièces
const pieceTypes = {
    1: 'Carte Nationale d\'Identité',
    2: 'Passeport',
    3: 'Permis de conduire',
    4: 'Carte d\'électeur',
    5: 'Carte professionnelle',
    6: 'Carte d\'étudiant',
    7: 'Carte de séjour',
    8: 'Carte bancaire',
    9: 'Autre document'
};

// Computed property pour les photos
const photoArray = computed(() => {
    if (!props.piece?.thefind?.photos) return [];
    
    try {
        // Si c'est déjà un tableau, le retourner
        if (Array.isArray(props.piece.thefind.photos)) {
            return props.piece.thefind.photos;
        }
        
        // Sinon, essayer de parser la chaîne JSON
        return JSON.parse(props.piece.thefind.photos);
    } catch (e) {
        console.error('Erreur lors du parsing des photos:', e);
        return [];
    }
});

// Computed property pour la première photo
const firstPhoto = computed(() => {
    if (photoArray.value.length > 0) {
        return `/storage/findImages/${photoArray.value[0]}`;
    }
    return 'https://via.placeholder.com/150?text=Pas+d%27image';
});

const form = reactive({
    _token: usePage().props.csrf_token,
    _method: "PUT"
});

// Sécuriser l'accès aux propriétés imbriquées
function getPieceType() {
    try {
        // Vérifier si la pièce a un objet piece avec un nom
        if (props.piece?.thefind?.piece?.name) {
            return props.piece.thefind.piece.name;
        } 
        // Vérifier si la pièce a un type directement dans thefind
        else if (props.piece?.thefind?.type) {
            return props.piece.thefind.type;
        }
        // Vérifier si la pièce a un piece_id et le convertir en nom
        else if (props.piece?.thefind?.piece_id) {
            const pieceId = props.piece.thefind.piece_id;
            // Utiliser le tableau de correspondance pour obtenir le nom
            return pieceTypes[pieceId] || `Type #${pieceId}`;
        } 
        // Vérifier si la pièce a un type_id et le convertir en nom
        else if (props.piece?.thefind?.type_id) {
            const typeId = props.piece.thefind.type_id;
            // Utiliser le tableau de correspondance pour obtenir le nom
            return pieceTypes[typeId] || `Type #${typeId}`;
        }
        else {
            return 'Non spécifié';
        }
    } catch (error) {
        console.error('Erreur lors de la récupération du type de pièce:', error);
        return 'Non spécifié';
    }
}

// Fonction alternative pour charger le type de pièce depuis l'API
function loadPieceTypeName() {
    if (props.piece?.thefind?.piece_id) {
        // Vous pourriez faire une requête API ici pour obtenir le nom du type
        // Exemple avec axios:
        // axios.get(`/api/piece-types/${props.piece.thefind.piece_id}`)
        //     .then(response => {
        //         pieceTypeName.value = response.data.name;
        //     })
        //     .catch(error => {
        //         console.error('Erreur lors du chargement du type de pièce:', error);
        //     });
        
        // Pour l'instant, utilisons le tableau de correspondance
        const pieceId = props.piece.thefind.piece_id;
        pieceTypeName.value = pieceTypes[pieceId] || `Type #${pieceId}`;
    }
}

function getUserName() {
    try {
        return props.piece?.thefind?.user?.name || 'Non disponible';
    } catch (error) {
        return 'Non disponible';
    }
}

function getUserPhone() {
    try {
        return props.piece?.thefind?.user?.profile?.phone_number || 'Non disponible';
    } catch (error) {
        return 'Non disponible';
    }
}

function getUserCity() {
    try {
        return props.piece?.thefind?.user?.profile?.city || 'Non disponible';
    } catch (error) {
        return 'Non disponible';
    }
}

const thefindId = props.piece?.thefind?.id;

function submitted() {
    if (thefindId) {
        router.post(route('find.update', { 'thefind': thefindId }), form, {
            forceFormData: true
        });
    }
}

function showImage(file) {
    // Si aucun fichier n'est fourni
    if (!file) {
        // Utiliser la computed property firstPhoto
        return firstPhoto.value;
    }
    
    // Si le fichier est déjà un chemin complet
    if (typeof file === 'string') {
        // Vérifier si le chemin commence déjà par /storage
        if (file.startsWith('/storage')) {
            return file;
        }
        
        // Sinon, ajouter le préfixe
        return `/storage/findImages/${file}`;
    }
    
    // Fallback: retourner le fichier tel quel
    return file;
}

// Afficher des informations de débogage dans la console
onMounted(() => {
    console.log('Photos reçues:', props.photos);
    console.log('Pièce reçue:', props.piece);
    
    if (props.piece?.thefind?.photos) {
        console.log('Photos de la pièce:', props.piece.thefind.photos);
        console.log('Type des photos:', typeof props.piece.thefind.photos);
        
        // Afficher le tableau de photos après parsing
        console.log('Photos parsées:', photoArray.value);
        
        if (photoArray.value.length > 0) {
            console.log('Première photo:', photoArray.value[0]);
        }
    }
    
    // Charger le nom du type de pièce
    loadPieceTypeName();
    
    // Afficher des informations sur le type de pièce
    if (props.piece?.thefind?.piece_id) {
        console.log('ID du type de pièce:', props.piece.thefind.piece_id);
        console.log('Nom du type de pièce:', pieceTypes[props.piece.thefind.piece_id]);
    }
});
</script>

<style scoped>
/* Styles spécifiques à la page */
</style>