<template>
    <Layout>
        <Head title="Introduction à l'enregistrement d'objet trouvé" />
        <HeaderPage title="Enregistrer un objet trouvé" />

        <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-4xl mx-auto">
                <!-- Titre de la page -->
                <div class="bg-primary-600 py-6 px-6">
                    <h1 class="text-2xl font-bold text-white">Comment fonctionne le processus d'enregistrement ?</h1>
                </div>
                
                <!-- Contenu principal -->
                <div class="p-6 space-y-8">
                    <!-- Introduction -->
                    <div class="prose max-w-none">
                        <p class="text-gray-700 text-lg">
                            Merci pour votre honnêteté et votre démarche citoyenne ! Nous allons vous guider à travers le processus d'enregistrement d'un objet que vous avez trouvé.
                        </p>
                    </div>
                    
                    <!-- Étapes du processus -->
                    <div class="border-l-4 border-primary-500 pl-4 space-y-6">
                        <div>
                            <h3 class="font-bold text-xl text-gray-800">Étape 1 : Informations sur l'objet trouvé</h3>
                            <p class="text-gray-600 mt-2">
                                Vous décrivez l'objet que vous avez trouvé, sa condition, et vous téléchargez des photos pour faciliter son identification.
                            </p>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-xl text-gray-800">Étape 2 : Vos informations personnelles</h3>
                            <p class="text-gray-600 mt-2">
                                Selon votre choix ci-dessous, nous recueillerons vos informations de contact pour le suivi du processus.
                            </p>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-xl text-gray-800">Étape 3 : Validation et confirmation</h3>
                            <p class="text-gray-600 mt-2">
                                Vérifiez l'exactitude des informations avant de finaliser l'enregistrement de l'objet trouvé.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Options pour l'utilisateur -->
                    <div class="mt-8 space-y-6">
                        <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Choisissez votre préférence</h2>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Option avec récompense -->
                            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow duration-300" :class="{'border-primary-500 bg-primary-50': wantReward}">
                                <div class="flex items-start">
                                    <input 
                                        id="with-reward" 
                                        type="radio" 
                                        name="registration-option" 
                                        class="h-5 w-5 mt-1 text-primary-600 focus:ring-primary-500" 
                                        v-model="wantReward" 
                                        :value="true"
                                    />
                                    <div class="ml-3">
                                        <label for="with-reward" class="text-lg font-medium text-gray-900">Je souhaite recevoir une récompense</label>
                                        <p class="text-gray-600 mt-1">
                                            Vous devrez créer un compte pour suivre le processus et recevoir une éventuelle récompense de la part du propriétaire.
                                        </p>
                                        <ul class="mt-3 list-disc pl-5 text-gray-600">
                                            <li>Création d'un compte personnel</li>
                                            <li>Suivi complet du processus</li>
                                            <li>Possibilité de recevoir une récompense</li>
                                            <li>Notification en cas de réclamation</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Option sans récompense -->
                            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow duration-300" :class="{'border-primary-500 bg-primary-50': !wantReward}">
                                <div class="flex items-start">
                                    <input 
                                        id="without-reward" 
                                        type="radio" 
                                        name="registration-option" 
                                        class="h-5 w-5 mt-1 text-primary-600 focus:ring-primary-500" 
                                        v-model="wantReward" 
                                        :value="false"
                                    />
                                    <div class="ml-3">
                                        <label for="without-reward" class="text-lg font-medium text-gray-900">Je ne souhaite pas de récompense</label>
                                        <p class="text-gray-600 mt-1">
                                            Vous pouvez enregistrer l'objet de manière anonyme, sans créer de compte sur la plateforme.
                                        </p>
                                        <ul class="mt-3 list-disc pl-5 text-gray-600">
                                            <li>Processus simplifié</li>
                                            <li>Aucun compte nécessaire</li>
                                            <li>Option totalement anonyme</li>
                                            <li>Démarche purement altruiste</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                        <!-- Bouton pour l'enregistrement d'objets -->
                        <button 
                            type="button"
                            @click="proceedToRegistration"
                            class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        >
                            Continuer vers l'enregistrement
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <!-- Bouton pour les documents -->
                        <button 
                            type="button"
                            @click="goToDocumentProtection"
                            class="inline-flex items-center px-8 py-3 border border-primary-500 text-base font-medium rounded-md shadow-sm text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        >
                            Enregistrer un objet trouvé
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout";
import HeaderPage from "@/Layouts/HeaderPage";

// État local pour la préférence de l'utilisateur
const wantReward = ref(true);

// Vérifier si l'utilisateur est authentifié
const { auth } = usePage().props;

// Fonction pour continuer vers la page d'enregistrement
function proceedToRegistration() {
    // Si l'utilisateur veut une récompense mais n'est pas connecté, le rediriger vers la page d'inscription
    if (wantReward.value && (!auth || !auth.user)) {
        router.visit(route('register.finder'), {
            data: {
                redirectUrl: route('find.register'),
                wantReward: wantReward.value
            },
            method: 'get',
            preserveState: true
        });
    } else {
        // Sinon, rediriger directement vers la page d'enregistrement
        router.visit(route('find.register'), {
            data: {
                wantReward: wantReward.value
            },
            method: 'get',
            preserveState: true
        });
    }
}

// Fonction pour aller à la page d'enregistrement des pièces trouvées
function goToDocumentProtection() {
    // Si l'utilisateur veut une récompense mais n'est pas connecté, le rediriger vers la page d'inscription
    if (wantReward.value && (!auth || !auth.user)) {
        router.visit(route('register.finder'), {
            data: {
                // Rediriger vers la page d'enregistrement des pièces après la création du compte
                redirectUrl: route('find.register'),
                wantReward: wantReward.value
            },
            method: 'get',
            preserveState: true
        });
    } else {
        // Sinon, rediriger directement vers la page d'enregistrement des pièces
        router.visit(route('find.register'), {
            data: {
                wantReward: wantReward.value
            },
            method: 'get',
            preserveState: true
        });
    }
}
</script>

<style scoped>
/* Styles supplémentaires si nécessaire */
</style>
