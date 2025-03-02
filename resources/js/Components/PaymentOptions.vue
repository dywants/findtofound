<template>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- En-tête avec icône et titre -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-4 text-white">
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h2 class="text-xl font-bold">Finaliser votre paiement</h2>
            </div>
            <p class="mt-1 text-sm text-blue-100">Choisissez votre méthode de paiement préférée</p>
        </div>

        <div class="p-6">
            <!-- Montant à payer avec animation -->
            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-indigo-100 transform transition-all duration-500 hover:shadow-md">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <div class="rounded-full bg-indigo-100 p-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-800">Montant à payer</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xl font-bold text-indigo-800 animate-pulse">
                            {{ formattedAmount }}
                        </span>
                        <div v-if="formattedAmountEUR" class="text-sm text-gray-600">
                            {{ formattedAmountEUR }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options de paiement avec animations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div 
                    v-for="option in paymentOptions" 
                    :key="option.id"
                    class="relative overflow-hidden border rounded-xl transition-all duration-300 cursor-pointer transform hover:scale-[1.02] hover:shadow-lg"
                    :class="{
                        'border-indigo-500 ring-2 ring-indigo-200 scale-[1.02]': selectedPayment === option.id,
                        'border-gray-200 hover:border-indigo-300': selectedPayment !== option.id
                    }"
                    @click="selectPayment(option.id)"
                >
                    <!-- Badge selon sélection -->
                    <div 
                        v-if="selectedPayment === option.id" 
                        class="absolute -right-1 -top-1 bg-indigo-600 text-white text-xs px-3 py-1 transform rotate-12 shadow-md"
                    >
                        Choisi
                    </div>
                    
                    <!-- Contenu de l'option -->
                    <div 
                        class="p-4 bg-white transition-colors duration-300" 
                        :class="{ 'bg-gradient-to-r from-indigo-50 to-blue-50': selectedPayment === option.id }"
                    >
                        <div class="flex items-center space-x-4">
                            <!-- Icones de paiement -->
                            <div class="flex -space-x-2">
                                <div 
                                    v-for="(icon, idx) in option.icons" 
                                    :key="icon.src"
                                    class="rounded-full bg-white p-1 border-2 shadow-sm transform transition-all duration-300 hover:scale-110 hover:z-10" 
                                    :class="{ 
                                        'border-indigo-200': selectedPayment === option.id,
                                        'border-gray-100': selectedPayment !== option.id
                                    }"
                                    :style="{zIndex: option.icons.length - idx, transitionDelay: `${idx * 50}ms`}"
                                >
                                    <img 
                                        :src="icon.src" 
                                        :alt="icon.alt" 
                                        class="w-10 h-10 object-contain" 
                                    />
                                </div>
                            </div>
                            
                            <!-- Texte de l'option -->
                            <div class="flex-1">
                                <h3 
                                    class="font-semibold text-gray-900 transition-colors duration-300"
                                    :class="{'text-indigo-700': selectedPayment === option.id}"
                                >
                                    {{ option.title }}
                                </h3>
                                <p class="text-sm text-gray-500">{{ option.description }}</p>
                            </div>
                            
                            <!-- Indicateur de sélection -->
                            <div class="flex-shrink-0">
                                <div 
                                    class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-300"
                                    :class="{
                                        'border-indigo-600 bg-indigo-100': selectedPayment === option.id,
                                        'border-gray-300': selectedPayment !== option.id
                                    }"
                                >
                                    <div 
                                        v-if="selectedPayment === option.id"
                                        class="w-3 h-3 rounded-full bg-indigo-600 animate-scale"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conteneur PayPal avec animation de transition -->
            <transition name="fade-slide">
                <div v-if="selectedPayment === 'paypal'" class="mt-6 p-4 border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-2 mb-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-600">Vous allez être redirigé vers PayPal pour finaliser votre paiement de manière sécurisée.</p>
                    </div>
                    <div id="paypal-button-container" class="w-full"></div>
                </div>
            </transition>

            <!-- Mobile Money Providers avec animations -->
            <transition name="fade-slide">
                <div v-if="selectedPayment === 'mobile'" class="mt-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Sélectionnez votre opérateur
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div 
                            v-for="(provider, index) in providers" 
                            :key="provider.name"
                            class="relative border rounded-lg overflow-hidden transition-all duration-300 transform hover:scale-[1.03] cursor-pointer"
                            :class="{
                                'border-green-500 ring-2 ring-green-100': selectedProvider === provider.provider,
                                'border-gray-200 hover:border-green-300': selectedProvider !== provider.provider
                            }"
                            @click="selectProvider(provider)"
                            :style="{transitionDelay: `${index * 50}ms`}"
                        >
                            <div 
                                class="p-4 transition-colors duration-300" 
                                :class="{'bg-gradient-to-r from-green-50 to-emerald-50': selectedProvider === provider.provider}"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="rounded-md overflow-hidden border border-gray-100 bg-white p-1">
                                            <img :src="provider.image" :alt="provider.name" class="w-8 h-8 object-contain" />
                                        </div>
                                        <span 
                                            class="font-medium transition-colors duration-300"
                                            :class="{'text-green-700': selectedProvider === provider.provider}"
                                        >
                                            {{ provider.name }}
                                        </span>
                                    </div>
                                    <div 
                                        class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-300"
                                        :class="{
                                            'border-green-600 bg-green-100': selectedProvider === provider.provider,
                                            'border-gray-300': selectedProvider !== provider.provider
                                        }"
                                    >
                                        <div 
                                            v-if="selectedProvider === provider.provider"
                                            class="w-3 h-3 rounded-full bg-green-600 animate-scale"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <transition name="fade-scale">
                        <button 
                            v-if="selectedProvider" 
                            @click="processMobilePayment"
                            class="mt-6 w-full flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-md text-base font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Procéder au paiement
                        </button>
                    </transition>
                </div>
            </transition>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const emit = defineEmits(['select-payment', 'select-provider', 'process-mobile']);

const props = defineProps({
    paymentOptions: {
        type: Array,
        required: true
    },
    selectedPayment: {
        type: String,
        default: ''
    },
    providers: {
        type: Array,
        default: () => []
    },
    selectedProvider: {
        type: String,
        default: ''
    },
    formattedAmount: {
        type: String,
        required: true
    },
    formattedAmountEUR: {
        type: String,
        default: ''
    }
});

const selectPayment = (method) => {
    emit('select-payment', method);
};

const selectProvider = (provider) => {
    emit('select-provider', provider);
};

const processMobilePayment = () => {
    emit('process-mobile');
};
</script>

<style scoped>
/* Animations pour les transitions */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

.fade-scale-enter-active,
.fade-scale-leave-active {
    transition: all 0.3s ease-out;
}

.fade-scale-enter-from,
.fade-scale-leave-to {
    opacity: 0;
    transform: scale(0.95);
}

/* Animation pour les indicateurs de sélection */
@keyframes scale {
    0% { transform: scale(0.6); opacity: 0.8; }
    50% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(1); opacity: 1; }
}

.animate-scale {
    animation: scale 0.3s ease-in-out;
}

/* Animation pour le montant */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.8; }
    100% { opacity: 1; }
}

.animate-pulse {
    animation: pulse 2s infinite ease-in-out;
}
</style>
