<template>
  <div class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-16 sm:px-6 sm:py-24">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- En-tête avec bannière d'erreur -->
        <div class="bg-red-600 py-6 px-6 text-center">
          <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white">
            <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h1 class="mt-4 text-2xl font-bold text-white">Erreur de paiement</h1>
          <p class="mt-2 text-white opacity-90">Une erreur est survenue lors du traitement de votre paiement.</p>
        </div>

        <!-- Détails de l'erreur -->
        <div class="px-6 py-8">
          <div class="p-4 mb-6 rounded-md bg-red-50 border border-red-200">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                  Message d'erreur
                </h3>
                <div class="mt-2 text-sm text-red-700">
                  <p>{{ message }}</p>
                </div>
              </div>
            </div>
          </div>

          <h2 class="text-xl font-semibold text-gray-800 mb-4">Que faire maintenant ?</h2>
          
          <div class="space-y-4 text-gray-600">
            <p>Voici quelques suggestions pour résoudre ce problème :</p>
            <ul class="list-disc pl-5 space-y-2">
              <li>Vérifiez que les informations de votre carte sont correctes</li>
              <li>Assurez-vous que votre carte est activée pour les paiements en ligne</li>
              <li>Contactez votre banque pour vous assurer qu'il n'y a pas de restrictions sur votre compte</li>
              <li>Essayez avec une autre méthode de paiement</li>
            </ul>
          </div>

          <!-- Actions -->
          <div class="mt-8 flex flex-col space-y-3">
            <inertia-link :href="route('subscription.confirm', { planId: $page.props.previousPlanId || 1 })" class="inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Réessayer
            </inertia-link>
            <inertia-link :href="route('subscription.plans')" class="inline-flex justify-center py-3 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Choisir un autre plan
            </inertia-link>
          </div>
        </div>

        <!-- Pied de page avec information de support -->
        <div class="bg-gray-50 px-6 py-4 sm:flex sm:justify-between sm:items-center">
          <div class="text-sm text-gray-500">
            <p>Besoin d'aide ? Contactez notre équipe de support à <a href="mailto:support@findtofound.com" class="text-indigo-600 hover:text-indigo-500">support@findtofound.com</a></p>
          </div>
          <div class="mt-3 sm:mt-0">
            <inertia-link :href="route('home')" class="text-sm text-indigo-600 hover:text-indigo-500">
              Retour à l'accueil &rarr;
            </inertia-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
  layout: AppLayout,
  
  props: {
    error: {
      type: String,
      default: 'unknown_error'
    },
    message: {
      type: String,
      default: 'Une erreur est survenue lors du traitement de votre paiement.'
    }
  },
  
  beforeMount() {
    // Enregistrer l'erreur pour des fins analytiques
    console.error('Erreur de paiement:', this.error, this.message);
  }
})
</script>
