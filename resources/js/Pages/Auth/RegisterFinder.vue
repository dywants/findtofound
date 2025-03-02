<template>
    <Layout>
        <Head title="Créer un compte pour recevoir une récompense" />
        <div class="container mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-xl mx-auto">
                <!-- Titre de la page -->
                <div class="bg-primary-600 py-6 px-6">
                    <h1 class="text-2xl font-bold text-white">Créez votre compte</h1>
                    <p class="text-white text-sm mt-2">Pour recevoir votre récompense, vous devez créer un compte</p>
                </div>
                
                <!-- Formulaire d'inscription -->
                <div class="p-6 space-y-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Ce compte vous permettra de suivre le processus de restitution et de recevoir votre récompense si le propriétaire en propose une.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Erreurs de validation -->
                    <div v-if="Object.keys(errors).length > 0" class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                        <div class="text-red-700">
                            <p class="font-bold">Des erreurs sont survenues :</p>
                            <ul class="mt-1 list-disc pl-5">
                                <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
                            </ul>
                        </div>
                    </div>
                    
                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <input 
                                id="name" 
                                type="text" 
                                v-model="form.name" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                required 
                                autofocus 
                            />
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                            <input 
                                id="email" 
                                type="email" 
                                v-model="form.email" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                required 
                            />
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            <input 
                                id="password" 
                                type="password" 
                                v-model="form.password" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                required 
                            />
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                v-model="form.password_confirmation" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                required 
                            />
                        </div>
                        
                        <div class="flex items-center">
                            <input 
                                id="terms" 
                                type="checkbox" 
                                v-model="form.terms" 
                                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                required
                            />
                            <label for="terms" class="ml-2 block text-sm text-gray-900">
                                J'accepte les <a href="/terms" class="text-primary-600 hover:text-primary-700">conditions d'utilisation</a> et la <a href="/privacy" class="text-primary-600 hover:text-primary-700">politique de confidentialité</a>
                            </label>
                        </div>
                        
                        <div class="flex justify-end">
                            <button 
                                type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                :disabled="form.processing"
                                :class="{ 'opacity-75': form.processing }"
                            >
                                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Créer mon compte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout";

// Props pour les erreurs de validation
const props = defineProps({
    errors: Object,
    redirectUrl: {
        type: String,
        default: route('find.register')
    },
    wantReward: {
        type: Boolean,
        default: true
    }
});

// Formulaire pour l'inscription
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    redirectUrl: props.redirectUrl,
    wantReward: props.wantReward
});

// Soumission du formulaire
const submit = () => {
    form.post(route('register.finder.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
