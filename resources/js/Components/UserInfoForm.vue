<template>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 text-white">
            <h2 class="text-xl font-semibold">Vos informations de contact</h2>
            <p class="text-sm text-blue-100">Ces informations permettront au finder de vous contacter</p>
        </div>
        
        <form @submit.prevent="$emit('submit')" class="p-6 space-y-6">
            <!-- Nom -->
            <div class="transition-opacity duration-300" :class="{ 'opacity-70': !isFieldActive('name') }">
                <label for="name" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Nom complet</span>
                </label>
                <div class="relative mt-1">
                    <input 
                        id="name" 
                        type="text" 
                        v-model="form.name" 
                        required
                        @focus="activeField = 'name'"
                        @blur="activeField = null"
                        class="block w-full rounded-md border-gray-300 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300" 
                    />
                    <div 
                        v-if="form.name"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 transition-opacity duration-200" 
                        :class="{ 'text-green-500': !errors.name, 'text-red-500': errors.name }"
                    >
                        <svg v-if="!errors.name" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <transition name="fade">
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </transition>
            </div>
            
            <!-- Email -->
            <div class="transition-opacity duration-300" :class="{ 'opacity-70': !isFieldActive('email') }">
                <label for="email" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>Email</span>
                </label>
                <div class="relative mt-1">
                    <input 
                        id="email" 
                        type="email" 
                        v-model="form.email"
                        required
                        @focus="activeField = 'email'"
                        @blur="activeField = null"
                        class="block w-full rounded-md border-gray-300 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300" 
                    />
                    <div 
                        v-if="form.email"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 transition-opacity duration-200" 
                        :class="{ 'text-green-500': isValidEmail && !errors.email, 'text-red-500': !isValidEmail || errors.email }"
                    >
                        <svg v-if="isValidEmail && !errors.email" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <transition name="fade">
                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                    <p v-else-if="form.email && !isValidEmail" class="mt-1 text-sm text-amber-600">Veuillez saisir un email valide</p>
                </transition>
            </div>

            <!-- Téléphone -->
            <div class="transition-opacity duration-300" :class="{ 'opacity-70': !isFieldActive('phone') }">
                <label for="phone" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span>Téléphone</span>
                </label>
                <div class="relative mt-1">
                    <input 
                        id="phone" 
                        type="tel" 
                        v-model="form.phone_number"
                        required
                        @focus="activeField = 'phone'"
                        @blur="activeField = null"
                        class="block w-full rounded-md border-gray-300 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300" 
                    />
                    <div 
                        v-if="form.phone_number"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 transition-opacity duration-200" 
                        :class="{ 'text-green-500': isValidPhone && !errors.phone_number, 'text-red-500': !isValidPhone || errors.phone_number }"
                    >
                        <svg v-if="isValidPhone && !errors.phone_number" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <transition name="fade">
                    <p v-if="errors.phone_number" class="mt-1 text-sm text-red-600">{{ errors.phone_number }}</p>
                    <p v-else-if="form.phone_number && !isValidPhone" class="mt-1 text-sm text-amber-600">Veuillez saisir un numéro de téléphone valide</p>
                </transition>
            </div>

            <!-- Ville -->
            <div class="transition-opacity duration-300" :class="{ 'opacity-70': !isFieldActive('city') }">
                <label for="city" class="flex items-center space-x-2 text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span>Ville</span>
                </label>
                <div class="relative mt-1">
                    <input 
                        id="city" 
                        type="text" 
                        v-model="form.city"
                        required
                        @focus="activeField = 'city'"
                        @blur="activeField = null"
                        class="block w-full rounded-md border-gray-300 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-300" 
                    />
                    <div 
                        v-if="form.city"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 transition-opacity duration-200" 
                        :class="{ 'text-green-500': !errors.city, 'text-red-500': errors.city }"
                    >
                        <svg v-if="!errors.city" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                <transition name="fade">
                    <p v-if="errors.city" class="mt-1 text-sm text-red-600">{{ errors.city }}</p>
                </transition>
            </div>

            <div class="pt-4">
                <button 
                    type="submit"
                    class="w-full flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]"
                >
                    <span>Continuer vers le paiement</span>
                    <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, computed } from 'vue';

defineEmits(['submit']);

const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

// Suivre le champ actif pour l'animation de focus
const activeField = ref(null);

// Vérifier si un champ est actif
const isFieldActive = (field) => {
    return activeField.value === field || !activeField.value;
};

// Validation de l'email
const isValidEmail = computed(() => {
    if (!props.form.email) return true; // Ne pas valider si vide
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(props.form.email);
});

// Validation du numéro de téléphone
const isValidPhone = computed(() => {
    if (!props.form.phone_number) return true; // Ne pas valider si vide
    const phoneRegex = /^\+?[0-9]{8,15}$/; // Format international simplifié
    return phoneRegex.test(props.form.phone_number);
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
