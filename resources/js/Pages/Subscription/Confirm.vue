<template>
    <Layout>
        <Head>
            <title>Confirmation d'abonnement - DocuTrace</title>
            <meta type="description"
                content="Confirmez votre plan d'abonnement DocuTrace pour la protection de documents">
        </Head>

        <div class="min-h-screen bg-gray-50 pt-16 pb-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- En-tête de la page -->
                <div class="max-w-xl mx-auto">
                    <div class="text-center">
                        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                            Confirmation d'abonnement
                        </h1>
                        <p class="mt-4 text-lg text-gray-500">
                            Vous êtes sur le point de vous abonner au plan <strong>{{ plan.name }}</strong>.
                            Veuillez vérifier les détails ci-dessous.
                        </p>
                    </div>
                </div>

                <!-- Récapitulatif du plan -->
                <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 bg-blue-600 text-white">
                        <h2 class="text-xl font-semibold">Récapitulatif de votre plan</h2>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ plan.name }}</h3>
                                <p class="text-sm text-gray-500">
                                    Facturation {{ billingPeriod === 'monthly' ? 'mensuelle' : 'annuelle' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ getPlanPrice() }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ billingPeriod === 'monthly' ? '/mois' : '/an' }}
                                </p>
                                <p v-if="billingPeriod === 'annual' && plan.savingsPercent > 0" 
                                   class="text-sm text-green-600 font-medium">
                                    Économisez {{ plan.savingsPercent }}%
                                </p>
                            </div>
                        </div>

                        <!-- Liste des fonctionnalités -->
                        <div class="mt-6">
                            <h4 class="text-base font-medium text-gray-900 mb-4">
                                Fonctionnalités incluses :
                            </h4>
                            <ul class="space-y-3">
                                <li v-for="(feature, index) in planFeatures" :key="index" class="flex items-start">
                                    <Icon name="check" class="h-5 w-5 text-green-500 flex-shrink-0 mr-2" />
                                    <span class="text-gray-700">{{ feature }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de facturation -->
                <div class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 bg-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900">Informations de facturation</h2>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <form @submit.prevent="submitPayment" class="space-y-6">
                            <!-- Informations personnelles -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    Coordonnées
                                </h3>
                                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                    <div>
                                        <label for="firstName" class="block text-sm font-medium text-gray-700">Prénom</label>
                                        <input type="text" id="firstName" v-model="billingInfo.firstName" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                               required>
                                    </div>
                                    <div>
                                        <label for="lastName" class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input type="text" id="lastName" v-model="billingInfo.lastName" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                               required>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" id="email" v-model="billingInfo.email" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                               required>
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input type="tel" id="phone" v-model="billingInfo.phone" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Options de personnalisation spécifiques au plan -->
                            <div v-if="plan.features && plan.features.watermark_customization">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    Options de personnalisation
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="watermarkText" class="block text-sm font-medium text-gray-700">
                                            Texte de filigrane par défaut
                                        </label>
                                        <input type="text" id="watermarkText" v-model="customization.watermarkText" 
                                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                               placeholder="ex: Confidentiel - Votre Nom">
                                    </div>
                                    
                                    <!-- Options avancées pour les plans premium -->
                                    <div v-if="plan.id === 'premium'">
                                        <label for="watermarkColor" class="block text-sm font-medium text-gray-700">
                                            Couleur du filigrane
                                        </label>
                                        <div class="mt-1 flex items-center space-x-3">
                                            <input type="color" id="watermarkColor" v-model="customization.watermarkColor" 
                                                  class="h-8 w-8 rounded border border-gray-300">
                                            <span class="text-sm text-gray-500">{{ customization.watermarkColor }}</span>
                                        </div>
                                    </div>
                                    
                                    <div v-if="plan.id === 'premium'">
                                        <label for="watermarkOpacity" class="block text-sm font-medium text-gray-700">
                                            Opacité du filigrane: {{ customization.watermarkOpacity }}%
                                        </label>
                                        <input type="range" id="watermarkOpacity" v-model="customization.watermarkOpacity" 
                                               min="10" max="90" step="5" 
                                               class="mt-1 block w-full">
                                    </div>
                                </div>
                            </div>

                            <!-- Méthodes de paiement -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    Méthode de paiement
                                </h3>
                                <div class="space-y-4">
                                    <div v-for="method in paymentMethods" :key="method.id" 
                                         class="flex items-center">
                                        <input :id="method.id" name="paymentMethod" type="radio" 
                                               v-model="selectedPaymentMethod" :value="method.id"
                                               :disabled="method.disabled"
                                               class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        <label :for="method.id" 
                                               :class="[
                                                   'ml-3 block text-sm font-medium flex items-center',
                                                   method.disabled ? 'text-gray-400' : 'text-gray-700'
                                               ]">
                                            <!-- Icônes SVG directement intégrées pour garantir l'affichage -->
                                            <span v-if="method.id === 'paypal'" class="h-6 w-auto mr-2 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#003087">
                                                    <path d="M8.32,21.97C8.21,21.92,8.08,21.76,8.06,21.65C8.03,21.5,8,21.76,8.66,17.56C9.26,13.76,9.25,13.82,9.33,13.71C9.46,13.54,9.44,13.54,10.94,13.53C12.26,13.5,12.54,13.5,13.13,13.41C16.38,12.96,18.39,11.05,19.09,7.75C19.13,7.53,19.17,7.34,19.18,7.34C19.18,7.33,19.25,7.33,19.33,7.33C19.41,7.33,19.57,7.33,19.67,7.32C19.91,7.31,20.15,7.3,20.14,7.13C20.13,7.01,20.12,6.94,20.09,6.79C19.88,5.79,19.47,4.95,18.87,4.24C18.41,3.72,18.26,3.57,17.79,3.21C16.71,2.38,15.35,1.88,13.79,1.68C13.41,1.63,12.17,1.59,11.83,1.63C6.84,1.96,4.45,5.01,5.1,9.74C5.3,11.24,5.77,12.37,6.52,13.29C7.12,14.02,7.96,14.53,8.96,14.78C9.27,14.86,9.62,14.93,9.94,14.97C10.06,14.99,10.13,15.01,10.11,15.02C10.07,15.03,7.93,15.05,7.47,15.05C7.3,15.05,7.13,15.05,7.13,15.05L7.12,15.18L7.13,15.33C7.14,15.43,7.15,15.59,7.16,15.74C7.18,16.32,7.24,16.99,7.27,17.24C7.33,17.89,7.4,18.55,7.46,19.3C7.54,19.94,7.5,20.3,7.35,21.17C7.31,21.38,7.31,21.71,7.36,21.82C7.38,21.86,7.39,21.89,7.38,21.9C7.38,21.91,7.36,21.94,7.32,21.97H8.32Z" />
                                                    <path d="M20.62,7.74C20.58,8.86,20.4,9.93,20.1,10.93C19.3,13.64,17.4,15.37,14.5,15.89C14.04,15.97,13.79,16,12.69,16C11.6,16,11.45,16,11.1,15.93C10.43,15.81,9.82,15.56,9.34,15.22C9.31,15.21,9.31,15.19,9.33,15.16C9.34,15.12,9.36,15.1,9.37,15.08C9.49,15.04,9.63,14.98,9.78,14.93C10.71,14.63,11.13,14.39,11.91,13.6C12.33,13.17,13.13,12.15,13.33,11.85C13.68,11.33,14.09,10.55,14.33,9.92C14.46,9.57,14.67,8.93,14.86,8.3C15.06,7.66,15.25,7.03,15.24,7.01C15.23,7,15.39,6.99,15.57,6.98C15.76,6.97,16.05,6.97,16.2,6.96C16.86,6.95,17.39,6.94,17.64,6.92C18.34,6.89,18.9,6.82,19.65,6.66C20.14,6.57,20.58,6.44,20.62,6.43C20.63,6.44,20.62,7.1,20.62,7.74Z" />
                                                </svg>
                                            </span>
                                            <span v-else-if="method.id === 'afrikpay'" class="h-6 w-auto mr-2 flex items-center justify-center bg-blue-600 text-white rounded px-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-5h10v2H7v-2zm0-4h10v2H7v-2zm0-4h7v2H7V7z"/>
                                                </svg>
                                                <span class="text-xs font-bold ml-1">AfrikPay</span>
                                            </span>
                                            <span v-else-if="method.id === 'flutterwave'" class="h-6 w-auto mr-2 flex items-center justify-center bg-orange-500 text-white rounded px-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white">
                                                    <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71L12 2z"/>
                                                </svg>
                                                <span class="text-xs font-bold ml-1">Flutterwave</span>
                                            </span>
                                            {{ method.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Conditions générales -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" v-model="termsAccepted"
                                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">J'accepte les conditions générales</label>
                                    <p class="text-gray-500">
                                        En souscrivant, vous acceptez nos <a href="#" class="text-blue-600 hover:text-blue-500">
                                        Conditions générales d'utilisation</a> et notre <a href="#" class="text-blue-600 hover:text-blue-500">
                                        Politique de confidentialité</a>.
                                    </p>
                                </div>
                            </div>

                            <!-- Boutons de soumission -->
                            <div class="flex justify-between">
                                <Link :href="route('documents.home')" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Annuler
                                </Link>
                                <button type="submit" 
                                        :disabled="!termsAccepted || processing" 
                                        :class="[
                                            'inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
                                            termsAccepted && !processing ? 'bg-blue-600 hover:bg-blue-700' : 'bg-blue-400 cursor-not-allowed'
                                        ]">
                                    <span v-if="processing" class="mr-2">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                    {{ processing ? 'Traitement en cours...' : 'Procéder au paiement' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import Icon from '@/Components/Icon.vue';

const props = defineProps({
    plan: Object,
    billingPeriod: {
        type: String,
        default: 'monthly'
    },
    user: Object
});

// Informations de facturation
const billingInfo = ref({
    firstName: props.user?.name?.split(' ')[0] || '',
    lastName: props.user?.name?.split(' ')[1] || '',
    email: props.user?.email || '',
    phone: ''
});

// Options de personnalisation
const customization = ref({
    watermarkText: `Protégé par ${props.user?.name || 'DocuTrace'}`,
    watermarkColor: '#3B82F6', // Bleu par défaut
    watermarkOpacity: 30 // 30% par défaut
});

// Méthodes de paiement
const paymentMethods = [
    { 
        id: 'paypal', 
        name: 'PayPal (Non disponible au Cameroun)', 
        disabled: true // Désactivé pour les utilisateurs au Cameroun
    },
    { 
        id: 'afrikpay', 
        name: 'AfrikPay (Mobile Money MTN, Orange)'
    },
    { 
        id: 'flutterwave', 
        name: 'Flutterwave (Mobile Money, Cartes bancaires)'
    },
    // Autres méthodes de paiement...
];

// Sélectionner AfrikPay par défaut (adapté pour le Cameroun)
const selectedPaymentMethod = ref('afrikpay');
const termsAccepted = ref(false);
const processing = ref(false);

// Fonctions
const getPlanPrice = () => {
    // Sélectionner le prix en fonction de la période de facturation
    const price = props.billingPeriod === 'monthly' ? props.plan.price_monthly : props.plan.price_yearly;
    
    // Gestion des valeurs null
    if (price === null || price === undefined) {
        return 'Prix non défini';
    }
    
    const currency = props.plan.currency ? props.plan.currency.symbol : '€';
    return `${price}${currency}`;
};

// Liste des fonctionnalités formatées pour l'affichage
const planFeatures = computed(() => {
    const features = [];
    
    if (props.plan.features) {
        // Documents protégés
        if (props.plan.features.monthly_generations) {
            const count = props.plan.features.monthly_generations;
            features.push(`${count === -1 ? 'Nombre illimité' : count} de documents protégés ${count !== -1 ? 'par mois' : ''}`);
        }
        
        // Types de documents
        if (props.plan.features.document_types && Array.isArray(props.plan.features.document_types)) {
            features.push(`Types de documents supportés: ${props.plan.features.document_types.map(type => type.toUpperCase()).join(', ')}`);
        }
        
        // Durée de stockage
        if (props.plan.features.storage_duration) {
            const duration = props.plan.features.storage_duration;
            if (duration === -1) {
                features.push('Stockage permanent des documents');
            } else if (duration > 30) {
                features.push(`Stockage pendant ${Math.floor(duration / 30)} mois`);
            } else {
                features.push(`Stockage pendant ${duration} jours`);
            }
        }
        
        // Taille maximale des documents
        if (props.plan.features.max_document_size) {
            features.push(`Taille maximale de ${props.plan.features.max_document_size} MB par document`);
        }
        
        // Personnalisation du filigrane
        if (props.plan.features.watermark_customization) {
            features.push('Personnalisation du filigrane');
        }
        
        // Nombre de partages
        if (props.plan.features.shares_per_document) {
            const count = props.plan.features.shares_per_document;
            features.push(`${count === -1 ? 'Partages illimités' : `${count} partages`} par document`);
        }
    }
    
    return features;
});

// Soumission du paiement
const submitPayment = () => {
    processing.value = true;
    
    // Création de l'objet de données pour la requête
    const paymentData = {
        planId: props.plan.id,
        billingPeriod: props.billingPeriod,
        paymentMethod: selectedPaymentMethod.value,
        billingInfo: billingInfo.value,
        customization: customization.value
    };
    
    // Envoi de la requête au backend
    router.post(route('subscription.process'), paymentData, {
        onSuccess: (response) => {
            processing.value = false;
            
            // Vérifier si une URL de redirection est fournie dans la réponse
            if (response.redirect_url) {
                // Rediriger l'utilisateur vers la passerelle de paiement
                window.location.href = response.redirect_url;
            }
        },
        onError: (errors) => {
            processing.value = false;
            console.error('Erreurs de paiement:', errors);
            
            // Vérifier si une URL de redirection d'erreur est fournie
            if (errors.redirect_url) {
                window.location.href = errors.redirect_url;
            }
        }
    });
};
</script>

<style scoped>
/* Styles spécifiques au composant */
</style>
