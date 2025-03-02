<template>

    <Head :title="'Récupération - ' + fullName" />

    <!-- En-tête avec progression -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Validation et Contact</h1>
                    <p class="mt-1 text-sm text-gray-600">Finalisez la procédure pour entrer en contact avec le finder
                    </p>
                </div>
                <!-- Indicateur de progression avec le composant ProgressStepper -->
                <ProgressStepper :current-step="currentStep" :steps="progressSteps" />                
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        <!-- Étape 1 : Informations (seulement si non connecté) -->
        <UserInfoForm
            v-if="currentStep === 1 && !props.auth?.user"
            :form="form"
            :errors="errors"
            @submit="handleSubmitInfo"
        />

        <!-- Étape 2 : Paiement -->
        <div v-else-if="currentStep === 2" class="bg-white rounded-lg shadow">
            <!-- Résumé des informations -->
            <InfoSummary :items="infoSummaryItems" />
            
            <!-- Options de paiement -->
            <PaymentOptions
                :payment-options="paymentOptionsConfig"
                :selected-payment="selectedPayment"
                :providers="providers"
                :selected-provider="selectedProvider"
                :formatted-amount="formattedAmount + ' FCFA'"
                :formatted-amount-e-u-r="formattedAmountEUR + ' EUR'"
                @select-payment="selectPayment"
                @select-provider="selectMobileProvider"
                @process-mobile="processMobilePayment"
            />
            
            <!-- Bouton pour mobile payment qui n'est pas dans le composant -->
            <div v-if="selectedPayment === 'mobile' && selectedProvider" class="p-6">
                <button 
                    @click="processMobilePayment"
                    class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Payer avec {{ selectedProviderName }}
                </button>
            </div>

            <!-- Boutons de navigation -->
            <div class="mt-6 flex justify-between p-6">
                <button @click="currentStep = 1"
                    class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Modifier mes informations
                </button>
            </div>
        </div>
    </main>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import ProgressStepper from '@/Components/ProgressStepper.vue'
import UserInfoForm from '@/Components/UserInfoForm.vue'
import InfoSummary from '@/Components/InfoSummary.vue'
import PaymentOptions from '@/Components/PaymentOptions.vue'

// Props
const props = defineProps({
    fullName: {
        type: String,
        required: true
    },
    amount: {
        type: [String, Number],
        default: 0
    },
    amount_check: {
        type: [String, Number, Object],
        default: 0
    },
    amount_eur: {
        type: [String, Number],
        default: 0
    },
    id: {
        type: [String, Number],
        required: true
    },
    auth: {
        type: Object,
        required: true
    },
    hasExistingRegistration: {
        type: Boolean,
        default: false
    },
    userInfo: {
        type: Object,
        default: () => ({
            email: '',
            phone_number: '',
            city: ''
        })
    }
})

// État
const currentStep = ref(props.auth?.user && props.hasExistingRegistration ? 2 : 1)

// Configuration des étapes de progression
const progressSteps = [
    { number: 1, label: props.auth?.user ? 'Connecté' : 'Informations' },
    { number: 2, label: 'Paiement' }
]

// Configuration des options de paiement
const paymentOptionsConfig = [
    {
        id: 'mobile',
        title: 'Paiement Mobile',
        description: 'Orange Money, MTN Mobile Money',
        icons: [
            { src: '/images/paiement/MTN_Group-Logo.svg', alt: 'MTN Money' },
            { src: '/images/paiement/Orange_Money-Logo.svg', alt: 'Orange Money' }
        ]
    },
    {
        id: 'paypal',
        title: 'PayPal',
        description: 'Paiement sécurisé par PayPal',
        icons: [
            { src: 'https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg', alt: 'PayPal' }
        ]
    }
]

// Définition d'une ref computée pour le nom complet
const fullName = computed(() => props.fullName || form.value.name || '')

// Construction des items pour le résumé des informations
const infoSummaryItems = computed(() => [
    { label: 'Nom', value: fullName.value },
    { label: 'Email', value: form.value.email },
    { label: 'Téléphone', value: form.value.phone_number },
    { label: 'Ville', value: form.value.city }
])
const selectedPayment = ref(null)
const selectedProvider = ref(null)
const selectedProviderName = ref('')
const errors = ref({})

const form = ref({
    name: props.fullName || '',
    email: props.userInfo?.email || '',
    phone_number: props.userInfo?.phone_number || '',
    city: props.userInfo?.city || '',
    amount: props.amount || 0,
    thefind_id: props.id,
})

// Formatage des montants
const formattedAmount = computed(() => {
    const amount = parseFloat(props.amount);
    return new Intl.NumberFormat('fr-FR').format(amount);
})

const formattedAmountEUR = computed(() => {
    const amount = parseFloat(props.amount_eur);
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
})

// Providers de paiement mobile
const providers = [
    {
        name: 'Orange Money',
        provider: 'orange',
        image: '/images/paiement/Orange_Money-Logo.svg'
    },
    {
        name: 'MTN Mobile Money',
        provider: 'mtn',
        image: '/images/paiement/MTN_Group-Logo.svg'
    },
    {
        name: 'Afrikpay',
        provider: 'afrikpay',
        image: '/images/paiement/afrikpay.png'
    }
]

// Validation du formulaire
const validateForm = () => {
    errors.value = {}
    let isValid = true

    if (!form.value.name) {
        errors.value.name = 'Le nom est requis'
        isValid = false
    }

    if (!form.value.email) {
        errors.value.email = 'L\'email est requis'
        isValid = false
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
        errors.value.email = 'L\'email n\'est pas valide'
        isValid = false
    }

    if (!form.value.phone_number) {
        errors.value.phone_number = 'Le téléphone est requis'
        isValid = false
    } else if (!/^[0-9]{9}$/.test(form.value.phone_number)) {
        errors.value.phone_number = 'Le numéro de téléphone doit contenir 9 chiffres'
        isValid = false
    }

    if (!form.value.city) {
        errors.value.city = 'La ville est requise'
        isValid = false
    }

    return isValid
}

// Gestion de la soumission du formulaire
const handleSubmitInfo = () => {
    if (validateForm()) {
        Inertia.post(route('found.store'), form.value, {
            preserveScroll: true,
            onSuccess: () => {
                currentStep.value = 2
            },
            onError: (errors) => {
                errors.value = errors
            }
        })
    }
}

// Méthodes
const selectPayment = (method) => {
    selectedPayment.value = method
    selectedProvider.value = null
    selectedProviderName.value = ''

    if (method === 'paypal') {
        mountPaypalButton()
    }
}

const selectMobileProvider = (provider) => {
    selectedProvider.value = provider.provider
    selectedProviderName.value = provider.name
}

const processMobilePayment = () => {
    Inertia.post(route('afrikpay.store'), {
        ...form.value,
        provider: selectedProvider.value,
        amount: props.amount,
        thefind_id: props.id
    })
}

const mountPaypalButton = () => {
    const amountEUR = (props.amount / 655.957).toFixed(2)

    paypal.Buttons({
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        currency_code: "EUR",
                        value: amountEUR,
                        breakdown: {
                            item_total: {
                                currency_code: "EUR",
                                value: amountEUR
                            }
                        }
                    },
                    items: [
                        {
                            name: props.fullName,
                            description: props.type_piece,
                            unit_amount: {
                                currency_code: "EUR",
                                value: amountEUR
                            },
                            quantity: "1"
                        },
                    ]
                }]
            })
        },
        onApprove: async (data, actions) => {
            try {
                const authorization = await actions.order.authorize()
                const authorizationId = authorization.purchase_units[0].payments.authorizations[0].id

                Inertia.post(route('paypal.store', { id: authorizationId }), {
                    ...form.value,
                    authorization_id: authorizationId,
                    amount: amountEUR,
                    currency: 'EUR',
                    sourcePayment: data.paymentSource,
                    thefind_id: props.id
                })
            } catch (error) {
                console.error('Erreur lors du traitement du paiement:', error)
            }
        },
        onError: (err) => {
            console.error('Erreur PayPal:', err)
        }
    }).render('#paypal-button-container')
}
</script>

<style>
.payment-option {
    @apply transition-all duration-200;
}

.payment-option:hover {
    @apply bg-gray-50;
}

.payment-provider {
    @apply flex items-center p-3 rounded-lg border border-gray-200 cursor-pointer;
}

.payment-provider.selected {
    @apply border-blue-500 bg-blue-50;
}

.payment-provider img {
    @apply h-8 w-auto;
}
</style>
