<script setup>
import { ref, reactive, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Layout from '@/Layouts/Layout.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import Icon from '@/Components/Icon.vue';


// Formulaire avec animation de progression
const currentStep = ref(1);
const totalSteps = 1;
const isSubmitting = ref(false);

// Utilisation du formulaire Inertia
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

// États pour les validations en temps réel
const validations = reactive({
    name: { valid: false, message: '' },
    email: { valid: false, message: '' },
    password: { valid: false, message: '' },
    passwordConfirmation: { valid: false, message: '' }
});

// Validation du nom
const validateName = () => {
    if (form.name.length < 2) {
        validations.name.valid = false;
        validations.name.message = 'Le nom doit contenir au moins 2 caractères';
    } else {
        validations.name.valid = true;
        validations.name.message = '';
    }
};

// Validation de l'email
const validateEmail = () => {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(form.email)) {
        validations.email.valid = false;
        validations.email.message = 'Veuillez entrer une adresse e-mail valide';
    } else {
        validations.email.valid = true;
        validations.email.message = '';
    }
};

// Validation du mot de passe
const validatePassword = () => {
    if (form.password.length < 8) {
        validations.password.valid = false;
        validations.password.message = 'Le mot de passe doit contenir au moins 8 caractères';
    } else {
        validations.password.valid = true;
        validations.password.message = '';
    }
};

// Validation de la confirmation du mot de passe
const validatePasswordConfirmation = () => {
    if (form.password !== form.password_confirmation) {
        validations.passwordConfirmation.valid = false;
        validations.passwordConfirmation.message = 'Les mots de passe ne correspondent pas';
    } else {
        validations.passwordConfirmation.valid = true;
        validations.passwordConfirmation.message = '';
    }
};

// Pourcentage de complétion du formulaire
const completionPercentage = computed(() => {
    let completedFields = 0;
    let totalFields = 4; // name, email, password, password_confirmation

    if (form.name) completedFields++;
    if (form.email) completedFields++;
    if (form.password) completedFields++;
    if (form.password_confirmation) completedFields++;

    return Math.floor((completedFields / totalFields) * 100);
});

// Tous les champs sont-ils valides?
const isFormValid = computed(() => {
    return validations.name.valid &&
        validations.email.valid &&
        validations.password.valid &&
        validations.passwordConfirmation.valid &&
        form.terms;
});

// Soumission du formulaire
const submit = () => {
    // Valider tous les champs d'abord
    validateName();
    validateEmail();
    validatePassword();
    validatePasswordConfirmation();

    if (!isFormValid.value) {
        return;
    }

    isSubmitting.value = true;

    form.post(route('register'), {
        onFinish: () => {
            isSubmitting.value = false;
            form.reset('password', 'password_confirmation');
        },
    });
};

// Animation pour l'affichage des erreurs
const shouldShake = ref(false);
const triggerShake = () => {
    shouldShake.value = true;
    setTimeout(() => {
        shouldShake.value = false;
    }, 500);
};
</script>

<template>
    <Layout>

        <Head title="Inscription" />

        <div class="max-w-2xl mx-auto my-12">
            <!-- En-tête avec animation -->
            <div class="text-center mb-8 animate-fade-in-down">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Créez votre compte</h1>
                <p class="text-gray-600">Rejoignez notre communauté et commencez à retrouver vos objets perdus</p>
            </div>

            <!-- Affichage des erreurs avec animation -->
            <div v-if="form.errors" :class="{ 'animate-shake': shouldShake }">
                <BreezeValidationErrors class="mb-4" />
            </div>

            <!-- Formulaire d'inscription -->
            <form @submit.prevent="submit" class="space-y-6 animate-fade-in-up bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <Icon name="user" class="mr-2 text-primary-600" />
                    Informations de votre compte
                </h2>
                <p class="text-sm text-gray-600 mb-6">Ces informations nous permettront de vous identifier</p>
                
                <div class="space-y-4">
                        <!-- Champ Nom -->
                        <div class="group">
                            <div class="flex items-center justify-between">
                                <BreezeLabel for="name" value="Nom complet" class="block mb-1" />
                                <span v-if="validations.name.message" class="text-xs text-red-500">{{
                                    validations.name.message }}</span>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <Icon name="user" :solid="validations.name.valid" class="text-gray-400" />
                                </div>
                                <BreezeInput id="name" type="text"
                                    class="pl-10 pr-4 py-2 block w-full border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm transition-all"
                                    :class="{ 'border-green-500 bg-green-50': validations.name.valid && form.name }"
                                    v-model="form.name" @input="validateName" @blur="validateName" required autofocus
                                    autocomplete="name" />
                                <div v-if="validations.name.valid && form.name"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <Icon name="check" solid size="18" class="text-green-500" />
                                </div>
                            </div>
                        </div>

                        <!-- Champ Email -->
                        <div class="group">
                            <div class="flex items-center justify-between">
                                <BreezeLabel for="email" value="Adresse e-mail" class="block mb-1" />
                                <span v-if="validations.email.message" class="text-xs text-red-500">{{
                                    validations.email.message }}</span>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <Icon name="mail" :solid="validations.email.valid" class="text-gray-400" />
                                </div>
                                <BreezeInput id="email" type="email"
                                    class="pl-10 pr-4 py-2 block w-full border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm transition-all"
                                    :class="{ 'border-green-500 bg-green-50': validations.email.valid && form.email }"
                                    v-model="form.email" @input="validateEmail" @blur="validateEmail" required
                                    autocomplete="username" />
                                <div v-if="validations.email.valid && form.email"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <Icon name="check" solid size="18" class="text-green-500" />
                                </div>
                            </div>
                        </div>

                        <!-- Champ Mot de passe -->
                        <div class="group">
                            <div class="flex items-center justify-between">
                                <BreezeLabel for="password" value="Mot de passe" class="block mb-1" />
                                <span v-if="validations.password.message" class="text-xs text-red-500">{{
                                    validations.password.message }}</span>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <Icon name="shield" :solid="validations.password.valid" class="text-gray-400" />
                                </div>
                                <BreezeInput id="password" type="password"
                                    class="pl-10 pr-4 py-2 block w-full border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm transition-all"
                                    :class="{ 'border-green-500 bg-green-50': validations.password.valid && form.password }"
                                    v-model="form.password" @input="validatePassword" @blur="validatePassword" required
                                    autocomplete="new-password" />
                                <div v-if="validations.password.valid && form.password"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <Icon name="check" solid size="18" class="text-green-500" />
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Au moins 8 caractères</p>
                        </div>

                        <!-- Champ Confirmation du mot de passe -->
                        <div class="group">
                            <div class="flex items-center justify-between">
                                <BreezeLabel for="password_confirmation" value="Confirmer le mot de passe"
                                    class="block mb-1" />
                                <span v-if="validations.passwordConfirmation.message" class="text-xs text-red-500">{{
                                    validations.passwordConfirmation.message }}</span>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <Icon name="shield" :solid="validations.passwordConfirmation.valid"
                                        class="text-gray-400" />
                                </div>
                                <BreezeInput id="password_confirmation" type="password"
                                    class="pl-10 pr-4 py-2 block w-full border-gray-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 rounded-md shadow-sm transition-all"
                                    :class="{ 'border-green-500 bg-green-50': validations.passwordConfirmation.valid && form.password_confirmation }"
                                    v-model="form.password_confirmation" @input="validatePasswordConfirmation"
                                    @blur="validatePasswordConfirmation" required autocomplete="new-password" />
                                <div v-if="validations.passwordConfirmation.valid && form.password_confirmation"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <Icon name="check" solid size="18" class="text-green-500" />
                                </div>
                            </div>
                        </div>

                        <!-- Case à cocher pour les termes -->
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" type="checkbox" v-model="form.terms"
                                    class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded transition-all" />
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="text-gray-500">J'accepte les <a href="#"
                                        class="text-primary-600 hover:text-primary-800">termes et conditions</a></label>
                            </div>
                        </div>
                    </div>

                <!-- Séparateur et boutons de connexion sociale -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou inscrivez-vous avec</span>
                        </div>
                    </div>

                    <!-- Boutons de connexion sociale -->
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <Link :href="route('auth.google')"
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-all duration-200 hover:shadow">
                            <img class="h-5 w-5" src="/images/google.svg" alt="Google" />
                            <span class="ml-2">Google</span>
                        </Link>

                        <Link :href="route('auth.facebook')"
                            class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition-all duration-200 hover:shadow">
                            <img class="h-5 w-5" src="/images/facebook.svg" alt="Facebook" />
                            <span class="ml-2">Facebook</span>
                        </Link>
                    </div>
                </div>
                
                <!-- Boutons d'action -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <Link :href="route('login')"
                        class="text-sm text-primary-600 hover:text-primary-800 flex items-center group transition-all">
                    <Icon name="chevron-left" class="mr-1 group-hover:-translate-x-1 transition-transform" />
                    Déjà inscrit ? Connectez-vous
                    </Link>

                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-900 focus:outline-none focus:border-primary-900 focus:shadow-outline-primary transition ease-in-out duration-150"
                        :class="{ 'opacity-75 cursor-not-allowed': form.processing || isSubmitting, 'hover:scale-105': !form.processing && !isSubmitting }"
                        :disabled="form.processing || isSubmitting">
                        <span v-if="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Inscription en cours...
                        </span>
                        <span v-else class="flex items-center">
                            S'inscrire
                            <Icon name="chevron-right" class="ml-1" size="14" />
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </Layout>
</template>
