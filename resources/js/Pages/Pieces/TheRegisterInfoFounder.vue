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
                <!-- Indicateur de progression -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center"
                            :class="[currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200']">
                            1
                        </div>
                        <div class="ml-2">
                            <p class="text-sm font-medium">{{ auth?.user ? 'Connecté' : 'Informations' }}</p>
                        </div>
                    </div>
                    <div class="w-12 h-0.5" :class="[currentStep >= 2 ? 'bg-blue-600' : 'bg-gray-200']"></div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center"
                            :class="[currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200']">
                            2
                        </div>
                        <div class="ml-2">
                            <p class="text-sm font-medium">Paiement</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        <!-- Étape 1 : Informations (seulement si non connecté) -->
        <div v-if="currentStep === 1 && !auth?.user" class="bg-white rounded-lg shadow p-6">
            <form @submit.prevent="handleSubmitInfo" class="space-y-6">
                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <input id="name" type="text" v-model="form.name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
                </div>
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" v-model="form.email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email }}</p>
                </div>

                <!-- Téléphone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="tel" v-model="form.phone_number"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="errors.phone_number" class="mt-1 text-sm text-red-600">{{ errors.phone_number }}</p>
                </div>

                <!-- Ville -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ville</label>
                    <input type="text" v-model="form.city"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    <p v-if="errors.city" class="mt-1 text-sm text-red-600">{{ errors.city }}</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Continuer vers le paiement
                    </button>
                </div>
            </form>
        </div>

        <!-- Étape 2 : Paiement -->
        <div v-else-if="currentStep === 2" class="bg-white rounded-lg shadow">
            <!-- Résumé des informations -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Résumé de vos informations</h2>
                <dl class="mt-4 space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-600">Nom</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ fullName }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-600">Email</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ email }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-600">Téléphone</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ phone_number }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-600">Ville</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ city }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Options de paiement -->
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Choisissez votre mode de paiement</h2>

                <div class="mt-4 space-y-4">
                    <!-- Mobile Money -->
                    <div class="relative border rounded-lg p-4 hover:border-blue-500 cursor-pointer"
                        :class="{ 'border-blue-500 bg-blue-50': selectedPayment === 'mobile' }"
                        @click="selectPayment('mobile')">
                        <div class="flex items-center space-x-4">
                            <div class="flex space-x-2">
                                <img src="/images/paiement/MTN_Group-Logo.svg" alt="MTN Money" class="w-12 h-12" />
                                <img src="/images/paiement/Orange_Money-Logo.svg" alt="Orange Money"
                                    class="w-12 h-12" />
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Paiement Mobile</h3>
                                <p class="text-sm text-gray-500">Orange Money, MTN Mobile Money</p>
                            </div>
                        </div>
                    </div>

                    <!-- PayPal -->
                    <div class="relative border rounded-lg p-4 hover:border-blue-500 cursor-pointer"
                        :class="{ 'border-blue-500 bg-blue-50': selectedPayment === 'paypal' }"
                        @click="selectPayment('paypal')">
                        <div class="flex items-center space-x-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal"
                                class="w-24" />
                            <div>
                                <h3 class="font-medium text-gray-900">PayPal</h3>
                                <p class="text-sm text-gray-500">Paiement sécurisé par PayPal</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Montant à payer -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-900">Montant à payer</span>
                        <span class="text-lg font-bold text-gray-900">
                            {{ formattedAmount }} FCFA
                            <span class="text-sm text-gray-500">({{ formattedAmountEUR }} EUR)</span>
                        </span>
                    </div>
                </div>

                <!-- Conteneur PayPal -->
                <div v-if="selectedPayment === 'paypal'" class="mt-6">
                    <div id="paypal-button-container"></div>
                </div>

                <!-- Mobile Money Providers -->
                <div v-if="selectedPayment === 'mobile'" class="mt-6 space-y-4">
                    <div v-for="provider in providers" :key="provider.name"
                        class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer"
                        @click="selectMobileProvider(provider)">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img :src="provider.image" :alt="provider.name" class="w-8 h-8" />
                                <span class="font-medium">{{ provider.name }}</span>
                            </div>
                            <svg v-if="selectedProvider === provider.provider" class="w-5 h-5 text-green-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>

                    <button v-if="selectedProvider" @click="processMobilePayment"
                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Payer avec {{ selectedProviderName }}
                    </button>
                </div>

                <!-- Boutons de navigation -->
                <div class="mt-6 flex justify-between">
                    <button @click="currentStep = 1"
                        class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Modifier mes informations
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Head, useForm } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

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
const selectedPayment = ref(null)
const selectedProvider = ref(null)
const selectedProviderName = ref('')
const errors = ref({})

// Informations utilisateur
const { email, phone_number, city } = props.userInfo

const form = ref({
    name: props.fullName || '',
    email: email || '',
    phone_number: phone_number || '',
    city: city || '',
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
