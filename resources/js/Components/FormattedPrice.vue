<template>
  <span class="formatted-price" :class="[size, { 'line-through': isStrikethrough }]">
    <span v-if="loading" class="animate-pulse">{{ placeholder }}</span>
    <template v-else>
      <span v-if="showSymbol" class="currency-symbol">{{ currencySymbol }}</span>
      <span class="price-value">{{ formattedValue }}</span>
      <span v-if="showCode" class="currency-code">{{ currencyCode }}</span>
    </template>
  </span>
</template>

<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from 'vue';
import axios from 'axios';

const props = defineProps({
  value: {
    type: [Number, String],
    required: true
  },
  originalCurrency: {
    type: String,
    default: 'XAF'
  },
  size: {
    type: String,
    default: 'base',
    validator: (value) => ['xs', 'sm', 'base', 'lg', 'xl', '2xl'].includes(value)
  },
  showSymbol: {
    type: Boolean,
    default: true
  },
  showCode: {
    type: Boolean,
    default: false
  },
  isStrikethrough: {
    type: Boolean,
    default: false
  }
});

const loading = ref(true);
const formattedValue = ref('');
const currencySymbol = ref('');
const currencyCode = ref(props.originalCurrency);
const placeholder = ref('---');

// Récupérer la devise sélectionnée
const getSelectedCurrency = () => {
  return localStorage.getItem('selected_currency') || props.originalCurrency;
};

// Convertir et formater le prix
const updatePrice = async () => {
  try {
    loading.value = true;
    const selectedCurrency = getSelectedCurrency();
    
    // Si la devise d'origine est la même que celle sélectionnée, pas besoin de convertir
    if (selectedCurrency === props.originalCurrency) {
      // Formater le prix selon la devise d'origine
      const response = await axios.get(`/api/currencies/${selectedCurrency}`);
      const currency = response.data;
      
      currencySymbol.value = currency.symbol;
      currencyCode.value = currency.code;
      
      // Formater le nombre selon les conventions de la devise
      formattedValue.value = new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: currency.decimal_places,
        maximumFractionDigits: currency.decimal_places
      }).format(props.value);
    } else {
      // Sinon, convertir le prix via l'API
      const response = await axios.post('/api/currencies/convert', {
        amount: props.value,
        from: props.originalCurrency,
        to: selectedCurrency
      });
      
      currencySymbol.value = response.data.formatted.split(' ')[0]; // Récupérer le symbole
      currencyCode.value = selectedCurrency;
      formattedValue.value = response.data.formatted.split(' ')[1]; // Récupérer le montant formaté
    }
    
    loading.value = false;
  } catch (error) {
    console.error('Erreur lors de la conversion du prix:', error);
    loading.value = false;
    formattedValue.value = props.value;
  }
};

// Écouter les changements de devise
const handleCurrencyChange = () => {
  updatePrice();
};

onMounted(() => {
  // Mettre à jour le prix au chargement du composant
  updatePrice();
  
  // Écouter l'événement de changement de devise
  window.addEventListener('currency-changed', handleCurrencyChange);
});

onBeforeUnmount(() => {
  // Nettoyer l'écouteur d'événement
  window.removeEventListener('currency-changed', handleCurrencyChange);
});

// Réagir aux changements de la valeur du prix
watch(() => props.value, () => {
  updatePrice();
});
</script>

<style scoped>
.formatted-price {
  @apply inline-flex items-center gap-1;
}

.formatted-price.xs {
  @apply text-xs;
}

.formatted-price.sm {
  @apply text-sm;
}

.formatted-price.base {
  @apply text-base;
}

.formatted-price.lg {
  @apply text-lg;
}

.formatted-price.xl {
  @apply text-xl font-bold;
}

.formatted-price.2xl {
  @apply text-2xl font-bold;
}

.line-through {
  @apply line-through text-gray-500;
}

.currency-symbol {
  @apply font-medium;
}

.currency-code {
  @apply text-gray-500 text-xs ml-1;
}
</style>
