<template>
    <Layout>
        <div class="bg-gray-50 min-h-screen">
            <!-- Header de profil -->
            <div class="relative h-60 rounded-b-lg overflow-hidden group transition-all duration-300" 
                 :class="{'shadow-2xl': isHeaderHovered}"
                 @mouseenter="handleHeaderHover(true)"
                 @mouseleave="handleHeaderHover(false)">
                <!-- Image de couverture ou gradient stylisé -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 transition-all duration-700 transform" 
                     :class="{'scale-105': isHeaderHovered}"></div>
                
                <!-- Pattern d'arrière-plan animé -->
                <div class="absolute inset-0 bg-blue-900 opacity-20 pattern-dots transition-opacity duration-300" 
                     :class="{'animate-pulse': isHeaderHovered}"></div>
                
                <!-- Effets dynamiques (particules ou vagues) -->
                <div class="absolute inset-0 opacity-30">
                    <div class="wave-animation"></div>
                </div>
                
                <!-- Panneau d'info utilisateur -->
                <div class="absolute top-4 left-8 flex items-center space-x-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-lg border border-white/20 shadow-lg transform transition duration-300"
                     :class="{'translate-y-1': isHeaderHovered}">
                    <span class="inline-block h-3 w-3 rounded-full bg-green-400 shadow-inner shadow-green-500/50 animate-pulse"></span>
                    <span class="text-white text-sm font-medium">Membre depuis {{ userJoinDate }}</span>
                </div>

                <!-- Cover photo options avec menu déroulant -->
                <div class="absolute top-4 right-4 z-10" 
                     @mouseenter="showCoverOptions = true" 
                     @mouseleave="showCoverOptions = false">
                    <button class="bg-white/20 text-white px-3 py-1.5 rounded-lg backdrop-blur-sm flex items-center space-x-1 hover:bg-white/30 transition shadow-lg">
                        <PencilIcon class="w-4 h-4" />
                        <span class="text-sm font-medium">Modifier couverture</span>
                    </button>
                    
                    <!-- Menu d'options pour la couverture -->
                    <div v-if="showCoverOptions" 
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl border border-gray-100 overflow-hidden transform transition-all duration-200 z-10">
                         <div class="py-1">
                            <button @click="triggerCoverFileInput" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                </svg>
                                Télécharger une image
                            </button>
                            <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Voir l'image actuelle
                            </button>
                            <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer l'image
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Input file caché pour la couverture -->
                <input type="file" ref="coverFileInput" @change="onCoverFileChange" accept="image/*" class="hidden" />

                <!-- Photo de profil - repositionnée en entier dans la section supérieure -->
                <div class="absolute top-1/2 left-8 sm:left-12 z-20 transform -translate-y-1/2">
                    <div class="relative group">
                        <!-- Photo container avec effet de survol -->
                        <div 
                            @click="triggerFileInput"
                            class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden transition duration-300 ease-in-out group-hover:shadow-xl group-hover:scale-105 cursor-pointer">
                            <img :src="currentPhotoUrl || 'https://cdn.tuk.dev/assets/webapp/forms/form_layouts/form2.jpg'"
                                alt="Photo de profil" class="w-full h-full object-cover" />
                            
                                        <!-- Overlay toujours visible mais plus prononcé au survol -->
                            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-70 hover:opacity-90 transition-opacity duration-300">
                                <span class="text-white text-xs sm:text-sm text-center font-medium px-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Modifier photo
                                </span>
                            </div>
                        </div>
                        
                        <!-- Bouton d'édition de photo avec tooltip - plus grand et plus visible -->
                        <button @click="triggerFileInput"
                            class="absolute -bottom-2 -right-2 bg-blue-600 text-white p-2 rounded-full shadow-lg hover:bg-blue-700 hover:scale-110 transition transform duration-200 ease-in-out z-10 border-2 border-white"
                            title="Changer votre photo de profil">
                            <PencilIcon class="w-5 h-5" />
                        </button>
                        
                        <!-- Menu d'options pour la photo - toujours accessible via un bouton dédié -->
                        <div class="absolute -right-3 sm:right-0 top-0 mt-2 mr-2">
                            <button @click="togglePhotoMenu" 
                                    class="bg-white/90 p-1.5 rounded-md shadow-md hover:bg-white transition" 
                                    title="Options de photo">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                            
                            <!-- Menu déroulant standard, affiché/masqué via togglePhotoMenu -->
                            <div v-show="showPhotoMenu" 
                                 class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-20">
                                <button @click="triggerFileInput" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                    </svg>
                                    Télécharger une photo
                                </button>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Voir la photo
                                </button>
                                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer la photo
                                </button>
                            </div>
                        </div>
                        
                        <!-- Input file caché -->
                        <input type="file" ref="fileInput" @change="onFileChange" accept="image/*" class="hidden" />
                    </div>
                </div>
            </div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
                <!-- User name -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">{{ props.user?.name || 'Utilisateur' }}</h1>
                    <p class="text-gray-500">{{ props.user?.email || '' }}</p>
                </div>

                <!-- Tabs -->
                <div class="mb-8">
                    <div class="flex space-x-1 rounded-xl bg-white p-1 shadow-sm border border-gray-100">
                        <button @click="activeTab = 'personal'" :class="[
                            'w-full rounded-lg py-2.5 text-sm font-medium leading-5',
                            'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                            activeTab === 'personal' ? 'bg-blue-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                        ]">
                            <div class="flex items-center justify-center space-x-2">
                                <UserIcon class="w-4 h-4" />
                                <span>Informations personnelles</span>
                            </div>
                        </button>
                        <button @click="activeTab = 'security'" :class="[
                            'w-full rounded-lg py-2.5 text-sm font-medium leading-5',
                            'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
                            activeTab === 'security' ? 'bg-blue-600 text-white shadow' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                        ]">
                            <div class="flex items-center justify-center space-x-2">
                                <ShieldCheckIcon class="w-4 h-4" />
                                <span>Sécurité</span>
                            </div>
                        </button>
                    </div>
                    <div class="mt-6">
                        <!-- Personal Information Panel -->
                        <div v-if="activeTab === 'personal'">

                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                                <!-- Erreurs et messages -->
                                <ErrorsAndMessages :errors="errors" />

                                <!-- Formulaire d'informations personnelles -->
                                <form method="post" @submit.prevent="submit" class="space-y-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <!-- Nom -->
                                        <div class="space-y-2">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700">Nom</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <UserIcon class="h-5 w-5 text-gray-400" />
                                                </div>
                                                <input type="text" name="name" id="name" v-model="form.name" required
                                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <!-- Email -->
                                        <div class="space-y-2">
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <EnvelopeIcon class="h-5 w-5 text-gray-400" />
                                                </div>
                                                <input type="email" name="email" id="email" :value="props.user.email"
                                                    disabled
                                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-500 sm:text-sm" />
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                                    <LockClosedIcon class="h-4 w-4 text-gray-400" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Téléphone -->
                                        <div class="space-y-2">
                                            <label for="phone_number"
                                                class="block text-sm font-medium text-gray-700">Numéro de
                                                téléphone</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <PhoneIcon class="h-5 w-5 text-gray-400" />
                                                </div>
                                                <input type="tel" name="phone_number" id="phone_number"
                                                    v-model="form.phone_number" required
                                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                            </div>
                                        </div>

                                        <!-- Ville -->
                                        <div class="space-y-2">
                                            <label for="city"
                                                class="block text-sm font-medium text-gray-700">Ville</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <MapPinIcon class="h-5 w-5 text-gray-400" />
                                                </div>
                                                <input type="text" name="city" id="city" v-model="form.city" required
                                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bouton de soumission -->
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                            <CheckIcon class="h-4 w-4 mr-1.5" />
                                            Enregistrer les modifications
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security Panel -->
                        <div v-if="activeTab === 'security'">
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                                <!-- Erreurs et messages -->
                                <ErrorsAndMessages :errors="errors" />

                                <h3 class="text-lg font-medium text-gray-900 mb-4">Changer votre mot de passe</h3>

                                <form method="post" @submit.prevent="submitPassword" class="space-y-6">
                                    <!-- Ancien mot de passe -->
                                    <div class="space-y-2">
                                        <label for="old_password" class="block text-sm font-medium text-gray-700">Ancien
                                            mot de passe</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <KeyIcon class="h-5 w-5 text-gray-400" />
                                            </div>
                                            <input type="password" name="old_password" id="old_password"
                                                v-model="formPassword.old_password" required
                                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <!-- Nouveau mot de passe -->
                                    <div class="space-y-2">
                                        <label for="new_password"
                                            class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <LockClosedIcon class="h-5 w-5 text-gray-400" />
                                            </div>
                                            <input type="password" name="new_password" id="new_password"
                                                v-model="formPassword.new_password" required
                                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <!-- Confirmation mot de passe -->
                                    <div class="space-y-2">
                                        <label for="password_confirmation"
                                            class="block text-sm font-medium text-gray-700">Confirmation du mot de
                                            passe</label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <CheckCircleIcon class="h-5 w-5 text-gray-400" />
                                            </div>
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" v-model="formPassword.password_confirmation"
                                                required
                                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                                        </div>
                                    </div>

                                    <!-- Bouton de soumission -->
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                            <KeyIcon class="h-4 w-4 mr-1.5" />
                                            Mettre à jour le mot de passe
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modale de confirmation pour la photo de profil -->
            <div v-if="showPhotoConfirmationModal" class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Overlay de fond -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Centre la modale -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    
                    <!-- Contenu de la modale -->
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Confirmer la nouvelle photo</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Voulez-vous utiliser cette image comme photo de profil ?</p>
                                    </div>
                                    <div class="mt-4 flex justify-center">
                                        <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                            <img :src="photoPreview" alt="Prévisualisation de la photo" class="w-full h-full object-cover" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="confirmAndUploadPhoto" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                                    :disabled="isUploading">
                                <svg v-if="isUploading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ isUploading ? 'Enregistrement...' : 'Confirmer' }}
                            </button>
                            <button @click="showPhotoConfirmationModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                    :disabled="isUploading">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notification de succès après upload de photo -->
            <div v-if="photoUploaded" class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg flex items-center z-50 transform transition-all duration-500 ease-in-out translate-y-0 opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Photo de profil mise à jour avec succès !
            </div>
        </div>
    </Layout>
</template>

<script setup>
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages";
import { reactive, computed, ref } from "vue";
import Layout from "@/Layouts/Layout";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { Tab } from '@headlessui/vue';
import UserIcon from '@heroicons/vue/24/outline/UserIcon';
import EnvelopeIcon from '@heroicons/vue/24/outline/EnvelopeIcon';
import PhoneIcon from '@heroicons/vue/24/outline/PhoneIcon';
import MapPinIcon from '@heroicons/vue/24/outline/MapPinIcon';
import ShieldCheckIcon from '@heroicons/vue/24/outline/ShieldCheckIcon';
import KeyIcon from '@heroicons/vue/24/outline/KeyIcon';
import LockClosedIcon from '@heroicons/vue/24/outline/LockClosedIcon';
import CheckCircleIcon from '@heroicons/vue/24/outline/CheckCircleIcon';
import CheckIcon from '@heroicons/vue/24/outline/CheckIcon';
import PencilIcon from '@heroicons/vue/24/outline/PencilIcon';

const props = defineProps({
    user: Object,
    errors: Object
});

// Onglet actif
const activeTab = ref('personal');

// Photo de profil (URL de placeholder si non définie)
const originalPhotoUrl = computed(() => {
    return props.user?.profile?.photo_url || null;
});

// Version modifiable de l'URL de photo
const currentPhotoUrl = ref(originalPhotoUrl.value);

// Variables pour la gestion des photos
const fileInput = ref(null);
const coverFileInput = ref(null);
const isHeaderHovered = ref(false);
const showCoverOptions = ref(false);
const showPhotoMenu = ref(false);
const photoPreview = ref(null);
const isUploading = ref(false);
const photoUploaded = ref(false);
const showPhotoConfirmationModal = ref(false);

// Calcul de la date d'inscription (formatée)
const userJoinDate = computed(() => {
    if (!props.user?.created_at) return 'Récemment';
    
    const date = new Date(props.user.created_at);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('fr-FR', options);
});

// Déclenche le dialogue de sélection de fichier pour la photo de profil
const triggerFileInput = () => {
    fileInput.value.click();
    // Ferme le menu si ouvert
    showPhotoMenu.value = false;
};

// Gère l'affichage/masquage du menu d'options pour la photo
const togglePhotoMenu = () => {
    showPhotoMenu.value = !showPhotoMenu.value;
    
    // Si on ouvre le menu, on ajoute un event listener pour le fermer lors d'un clic ailleurs
    if (showPhotoMenu.value) {
        setTimeout(() => {
            document.addEventListener('click', closePhotoMenuOnClickOutside);
        }, 0);
    }
};

// Ferme le menu lorsqu'on clique en dehors
const closePhotoMenuOnClickOutside = (event) => {
    // Si le clic est en dehors du menu et de son bouton
    if (showPhotoMenu.value) {
        showPhotoMenu.value = false;
        document.removeEventListener('click', closePhotoMenuOnClickOutside);
    }
};

// Déclenche le dialogue de sélection de fichier pour la couverture
const triggerCoverFileInput = () => {
    coverFileInput.value.click();
};

// Surveille le survol du header pour les effets d'animation
const handleHeaderHover = (isHovered) => {
    isHeaderHovered.value = isHovered;
};

// Gère le changement de fichier pour la photo de profil
const onFileChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;
    
    // Vérifie que c'est bien une image
    if (!file.type.match('image.*')) {
        alert('Veuillez sélectionner une image');
        return;
    }
    
    // Taille maximale (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('La taille de l\'image ne doit pas dépasser 2MB');
        return;
    }
    
    // Aperçu local temporaire pendant le téléchargement
    const reader = new FileReader();
    reader.onload = (e) => {
        // Afficher la prévisualisation de l'image
        photoPreview.value = e.target.result;
        // Afficher la modale de confirmation
        showPhotoConfirmationModal.value = true;
    };
    reader.readAsDataURL(file);
};

// Fonction pour confirmer et uploader la photo
const confirmAndUploadPhoto = () => {
    isUploading.value = true;
    
    // Récupérer le fichier depuis l'input
    const file = fileInput.value.files[0];
    
    // Utiliser Inertia pour envoyer la photo au serveur
    const form = new FormData();
    form.append('profile_photo', file);
    
    // Envoyer les données au serveur via Inertia
    Inertia.post(route('user.profile.update-photo'), form, {
        forceFormData: true,
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            // Mettre à jour l'URL de la photo localement en attendant le rafraîchissement
            currentPhotoUrl.value = photoPreview.value;
            
            // Réinitialiser les états
            isUploading.value = false;
            photoUploaded.value = true;
            showPhotoConfirmationModal.value = false;
            
            // Réinitialiser l'input file
            if (fileInput.value) {
                fileInput.value.value = '';
            }
            
            // Réinitialiser l'état d'upload après un délai
            setTimeout(() => {
                photoUploaded.value = false;
            }, 3000);
            
            console.log('Photo téléchargée avec succès');
        },
        onError: (errors) => {
            // Gérer l'erreur avec plus de détails
            isUploading.value = false;
            console.error('Erreurs lors du téléchargement:', errors);
            alert('Erreur: ' + JSON.stringify(errors));
        }
    });
    
    // Code pour l'intégration réelle avec le backend (à décommenter et adapter)
    /*
    Inertia.post(route('user.update.photo', { 'user': props.user.id }), formData, {
        forceFormData: true,
        onSuccess: () => {
            // Réinitialiser l'input file
            if (fileInput.value) {
                fileInput.value.value = '';
            }
            // Réinitialiser les états
            isUploading.value = false;
            photoUploaded.value = true;
            showPhotoConfirmationModal.value = false;
            
            // Réinitialiser l'état d'upload après un délai
            setTimeout(() => {
                photoUploaded.value = false;
            }, 3000);
        },
        onError: () => {
            isUploading.value = false;
            alert('Une erreur est survenue lors du téléchargement de l\'image');
        }
    });
    */
};

// Gère le changement de fichier pour la photo de couverture
const onCoverFileChange = (event) => {
    const file = event.target.files[0];
    if (!file) return;
    
    // Vérifie que c'est bien une image
    if (!file.type.match('image.*')) {
        alert('Veuillez sélectionner une image');
        return;
    }
    
    // Taille maximale (5MB pour une image de couverture)
    if (file.size > 5 * 1024 * 1024) {
        alert('La taille de l\'image ne doit pas dépasser 5MB');
        return;
    }
    
    // Télécharger l'image de couverture au serveur
    const formData = new FormData();
    formData.append('cover_photo', file);
    
    // Aperçu local temporaire pendant le téléchargement
    const reader = new FileReader();
    reader.onload = (e) => {
        console.log('Image de couverture chargée localement');
    };
    reader.readAsDataURL(file);
    
    // Afficher un indicateur de chargement
    isUploading.value = true;
    
    // Envoi au serveur
    Inertia.post(route('user.profile.update-cover-photo'), formData, {
        forceFormData: true,
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            // Réinitialiser l'input file
            if (coverFileInput.value) {
                coverFileInput.value.value = '';
            }
            showCoverOptions.value = false;
            isUploading.value = false;
            
            // Afficher un message de succès temporaire
            alert('Photo de couverture mise à jour avec succès!');
        },
        onError: (errors) => {
            // Gérer l'erreur avec plus de détails
            isUploading.value = false;
            console.error('Erreurs lors du téléchargement de la couverture:', errors);
            alert('Erreur: ' + JSON.stringify(errors));
        }
    });
};

const form = reactive({
    name: props.user?.name || '',
    phone_number: props.user?.profile?.phone_number || '',
    city: props.user?.profile?.city || '',
    _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
    _method: "PUT"
});

// Utilisation de useForm pour le formulaire de mot de passe (meilleure gestion des erreurs et réinitialisation)
const formPassword = useForm({
    old_password: '',
    new_password: '',
    password_confirmation: '',
    _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
    _method: "PUT"
});

// Les données du formulaire sont déjà initialisées de manière sécurisée dans la définition du reactive

const submit = () => {
    Inertia.post(route('user.update', { 'user': props.user.id }), form, {
        forceFormData: true
    });
}

const submitPassword = () => {
    Inertia.post(route('user.update.password', { 'user': props.user.id }), formPassword, {
        forceFormData: true,
        onFinish: () => formPassword.reset('old_password', 'new_password', 'password_confirmation'),
    });
}
</script>

<style scoped>
.pattern-dots {
    background-image: radial-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px);
    background-size: 16px 16px;
}

.wave-animation {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 30%;
    background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNDQwIDMyMCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PHBhdGggZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjIpIiBkPSJNMCw5NlMxNDguNSwwLDMyMCwwczMyMCw5NiwzMjAsOTZWMzIwSDBaIj48L3BhdGg+PHBhdGggZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjEpIiBkPSJNMCw5NlM0NDgsMCw3MjAsMFMxNDQwLDk2LDE0NDAsOTZWMzIwSDBaIj48L3BhdGg+PC9zdmc+') repeat-x;
    background-size: 100% 100%;
    animation: wave 15s linear infinite;
}

@keyframes wave {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.6;
    }
    50% {
        opacity: 1;
    }
}

/* Animations pour les transitions entre onglets */
.tab-enter-active,
.tab-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.tab-enter-from,
.tab-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

/* Animation pour les boutons */
button {
    transition: all 0.2s ease;
}

button:active {
    transform: scale(0.97);
}

/* Animation pour les champs de formulaire en focus */
input:focus {
    animation: pulse 1s;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.3);
    }

    70% {
        box-shadow: 0 0 0 5px rgba(59, 130, 246, 0);
    }

    100% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
    }
}
</style>