<template>
  <div class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-16 sm:px-6 sm:py-24">
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- En-tête avec bannière de succès -->
        <div class="bg-green-600 py-6 px-6 text-center">
          <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-white">
            <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h1 class="mt-4 text-2xl font-bold text-white">Paiement réussi !</h1>
          <p class="mt-2 text-white opacity-90">Votre abonnement a été activé avec succès.</p>
        </div>

        <!-- Détails de l'abonnement -->
        <div class="px-6 py-8">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Détails de votre abonnement</h2>
          
          <div class="border-t border-b border-gray-200 py-4 space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Plan</span>
              <span class="font-medium text-gray-900">{{ subscription.plan_name }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Période de facturation</span>
              <span class="font-medium text-gray-900">{{ formatBillingPeriod(subscription.billing_period) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Montant</span>
              <span class="font-medium text-gray-900">{{ formatAmount(subscription.amount, subscription.currency) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Date de début</span>
              <span class="font-medium text-gray-900">{{ subscription.start_date }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Date d'expiration</span>
              <span class="font-medium text-gray-900">{{ subscription.end_date }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">ID de transaction</span>
              <span class="font-medium text-gray-900">{{ subscription.payment_id }}</span>
            </div>
          </div>

          <!-- Actions -->
          <div class="mt-8 flex flex-col space-y-3">
            <inertia-link :href="route('dashboard')" class="inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Accéder à mon tableau de bord
            </inertia-link>
            <a href="#" class="inline-flex justify-center py-3 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click.prevent="printReceipt">
              Télécharger un reçu
            </a>
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
    subscription: {
      type: Object,
      required: true
    }
  },
  
  methods: {
    formatBillingPeriod(period) {
      const periods = {
        'monthly': 'Mensuelle',
        'annual': 'Annuelle',
        'annuelle': 'Annuelle'
      }
      return periods[period] || period;
    },
    
    formatAmount(amount, currency) {
      if (currency === 'XAF') {
        return new Intl.NumberFormat('fr-FR', { 
          style: 'currency', 
          currency: 'XAF',
          minimumFractionDigits: 0,
          maximumFractionDigits: 0
        }).format(amount);
      }
      
      return new Intl.NumberFormat('fr-FR', { 
        style: 'currency', 
        currency: currency || 'EUR'
      }).format(amount);
    },
    
    printReceipt() {
      // Fonction à implémenter pour l'impression ou le téléchargement d'un reçu
      window.print();
    }
  }
})
</script>
