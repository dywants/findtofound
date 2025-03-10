<template>
  <div class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-16 sm:px-6 sm:py-24">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- En-tête avec bannière d'annulation -->
        <div class="bg-yellow-500 py-6 px-6 text-center">
          <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white">
            <svg class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <h1 class="mt-4 text-2xl font-bold text-white">Paiement annulé</h1>
          <p class="mt-2 text-white opacity-90">Vous avez annulé le processus de paiement.</p>
        </div>

        <!-- Contenu principal -->
        <div class="px-6 py-8">
          <p class="text-gray-600 mb-6">
            Vous avez choisi d'annuler votre paiement. Aucun montant n'a été débité de votre compte.
          </p>

          <h2 class="text-xl font-semibold text-gray-800 mb-4">Que souhaitez-vous faire maintenant ?</h2>
          
          <div class="space-y-4 text-gray-600">
            <p>Vous pouvez :</p>
            <ul class="list-disc pl-5 space-y-2">
              <li>Retourner à la page de confirmation pour réessayer le paiement</li>
              <li>Choisir un autre plan d'abonnement</li>
              <li>Revenir plus tard pour finaliser votre abonnement</li>
            </ul>
          </div>

          <!-- Actions -->
          <div class="mt-8 flex flex-col space-y-3">
            <inertia-link :href="route('subscription.confirm', { planId: $page.props.previousPlanId || 1 })" class="inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Retourner à la page de confirmation
            </inertia-link>
            <inertia-link :href="route('subscription.plans')" class="inline-flex justify-center py-3 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Voir tous les plans d'abonnement
            </inertia-link>
            <inertia-link :href="route('home')" class="inline-flex justify-center py-3 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Retour à l'accueil
            </inertia-link>
          </div>
        </div>

        <!-- Pied de page avec information de support -->
        <div class="bg-gray-50 px-6 py-4 sm:flex sm:justify-between sm:items-center">
          <div class="text-sm text-gray-500">
            <p>Des questions ? Contactez notre équipe de support à <a href="mailto:support@findtofound.com" class="text-indigo-600 hover:text-indigo-500">support@findtofound.com</a></p>
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
    provider: {
      type: String,
      default: 'unknown'
    }
  },
  
  mounted() {
    // Log de l'annulation pour suivi analytique
    console.log('Paiement annulé par l\'utilisateur. Fournisseur:', this.provider);
  }
})
</script>
