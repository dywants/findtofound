<template>
  <Layout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
          <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center">Choisissez votre plan d'abonnement</h1>
          <p class="text-xl text-gray-600 mb-12 text-center">Débloquez toutes les fonctionnalités pour optimiser la récupération de vos objets</p>
          
          <!-- Affichage annuel/mensuel -->
          <div class="flex justify-center mb-8">
            <div class="bg-gray-100 p-1 rounded-full flex items-center">
              <button 
                @click="billingCycle = 'monthly'" 
                class="px-4 py-2 rounded-full font-medium text-sm"
                :class="billingCycle === 'monthly' ? 'bg-white shadow-sm' : 'text-gray-500'"
              >
                Mensuel
              </button>
              <button 
                @click="billingCycle = 'yearly'" 
                class="px-4 py-2 rounded-full font-medium text-sm"
                :class="billingCycle === 'yearly' ? 'bg-white shadow-sm' : 'text-gray-500'"
              >
                Annuel <span class="text-emerald-500 text-xs font-bold">-15%</span>
              </button>
            </div>
          </div>
          
          <div v-if="loading" class="flex flex-col items-center justify-center p-12">
            <div class="w-16 h-16 border-t-4 border-b-4 border-tahiti rounded-full animate-spin"></div>
            <p class="mt-4 text-gray-600">Chargement des plans d'abonnement...</p>
          </div>
          
          <div v-else class="flex flex-col md:flex-row gap-8 justify-center items-stretch">
            <div v-for="plan in subscriptionPlans" :key="plan.id" class="flex-1 border rounded-xl shadow-sm overflow-hidden max-w-md hover:shadow-lg transition-all duration-300">
              <div class="bg-gradient-to-r from-tahiti to-tahiti-dark text-white p-6">
                <h2 class="text-2xl font-bold">{{ plan.name }}</h2>
                <p class="text-white/80 mt-2">{{ plan.description }}</p>
                
                <div class="mt-4">
                  <FormattedPrice 
                    :value="billingCycle === 'monthly' ? plan.monthly_price : plan.yearly_price" 
                    :original-currency="plan.currency ? plan.currency.code : 'XAF'"
                    size="xl"
                    class="block"
                  />
                  <span class="text-white/70 text-sm">
                    {{ billingCycle === 'monthly' ? 'par mois' : 'par an' }}
                  </span>
                </div>
              </div>
              
              <div class="p-6 bg-white">
                <h3 class="font-medium text-gray-900 mb-4">Ce que vous obtenez :</h3>
                <ul class="space-y-3">
                  <li v-for="(feature, index) in getFeatures(plan)" :key="index" class="flex">
                    <svg class="h-5 w-5 text-emerald-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ feature }}</span>
                  </li>
                </ul>
                
                <button 
                  @click="selectPlan(plan)"
                  class="mt-8 w-full py-3 px-4 bg-tahiti hover:bg-tahiti-dark text-white rounded-md font-medium transition-colors duration-300"
                >
                  Souscrire
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/Layout'
import FormattedPrice from '@/Components/FormattedPrice'
import axios from 'axios'

const billingCycle = ref('monthly')
const subscriptionPlans = ref([])
const loading = ref(true)

// Récupérer les plans d'abonnement
const getSubscriptionPlans = async () => {
  try {
    loading.value = true
    const response = await axios.get(route('subscription-plans.index'))
    subscriptionPlans.value = response.data
    loading.value = false
  } catch (error) {
    console.error('Erreur lors du chargement des plans:', error)
    loading.value = false
  }
}

// Extraire les caractéristiques d'un plan
const getFeatures = (plan) => {
  // Convertit les caractéristiques JSON en tableau lisible
  const features = []
  
  if (plan.can_post_finds) features.push('Publier des objets trouvés illimités')
  if (plan.can_post_losts) features.push('Publier des objets perdus illimités')
  
  features.push(`${plan.max_images_per_post} images par publication`)
  
  if (plan.can_promote_posts) features.push('Promotion de vos publications')
  if (plan.has_priority_support) features.push('Support prioritaire')
  
  return features
}

// Sélectionner un plan d'abonnement
const selectPlan = (plan) => {
  const form = useForm({
    plan_id: plan.id,
    billing_cycle: billingCycle.value
  })
  
  form.post(route('subscription.create'))
}

onMounted(() => {
  getSubscriptionPlans()
})
</script>
