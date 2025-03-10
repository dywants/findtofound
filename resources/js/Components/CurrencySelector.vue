<template>
  <div class="currency-selector">
    <div class="relative">
      <button 
        @click="isOpen = !isOpen" 
        class="flex items-center gap-1 text-sm px-2 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition"
        :aria-expanded="isOpen"
        aria-haspopup="true"
      >
        <span v-if="selectedCurrency">{{ selectedCurrency.symbol }} {{ selectedCurrency.code }}</span>
        <span v-else>Devise</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      
      <div 
        v-if="isOpen" 
        class="absolute right-0 mt-1 z-50 bg-white dark:bg-gray-900 border dark:border-gray-700 rounded shadow-lg py-1 min-w-[180px]"
        @click.outside="isOpen = false"
      >
        <button 
          v-for="currency in currencies" 
          :key="currency.code" 
          @click="selectCurrency(currency)" 
          class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2"
          :class="{ 'bg-gray-100 dark:bg-gray-800': currency.code === selectedCurrency?.code }"
        >
          <span class="font-medium">{{ currency.symbol }}</span>
          <span>{{ currency.code }}</span>
          <span class="ml-auto text-xs text-gray-500 dark:text-gray-400">{{ currency.name }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'

const isOpen = ref(false)
const currencies = ref([])
const selectedCurrencyCode = ref(localStorage.getItem('selected_currency') || null)

const selectedCurrency = computed(() => {
  return currencies.value.find(c => c.code === selectedCurrencyCode.value)
})

// Charger les devises disponibles
const loadCurrencies = async () => {
  try {
    const response = await axios.get(route('api.currencies.index'))
    currencies.value = response.data
    
    // Si aucune devise n'est sélectionnée, utiliser celle par défaut
    if (!selectedCurrencyCode.value && currencies.value.length > 0) {
      const defaultCurrency = currencies.value.find(c => c.is_default) || currencies.value[0]
      selectedCurrencyCode.value = defaultCurrency.code
      localStorage.setItem('selected_currency', defaultCurrency.code)
    }
  } catch (error) {
    console.error('Erreur lors du chargement des devises:', error)
  }
}

// Sélectionner une devise
const selectCurrency = (currency) => {
  selectedCurrencyCode.value = currency.code
  localStorage.setItem('selected_currency', currency.code)
  isOpen.value = false
  
  // Déclencher un événement pour informer les autres composants du changement de devise
  window.dispatchEvent(new CustomEvent('currency-changed', { 
    detail: { currencyCode: currency.code } 
  }))
  
  // Si besoin de rafraîchir la page pour mettre à jour tous les prix
  // window.location.reload()
}

onMounted(() => {
  loadCurrencies()
})
</script>
