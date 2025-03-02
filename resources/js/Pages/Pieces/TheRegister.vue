<script setup>
/**
 * TheRegister.vue - Formulaire d'enregistrement de pièce trouvée
 * 
 * Structure refactorisée avec composables:
 * - useFormStorage: gestion de la sauvegarde/restauration des données du formulaire
 * - useWizardSteps: gestion des étapes du formulaire wizard
 * - useFormValidation: validation des données avec Yup
 * - useFormSubmission: traitement de la soumission du formulaire
 * - useImageUpload: gestion des images uploadées
 *
 * Cette structure modulaire facilite la maintenance et les évolutions futures
 */
import { ref, computed, watch, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout";
import HeaderPage from "@/Layouts/HeaderPage";
import InforObject from "@/Components/Steps/InforObject";
import YourInformation from "@/Components/Steps/YourInformation";
import Validation from "@/Components/Steps/Validation";
import FormWizard from "@/Components/Elements/FormWizard";
import FormStep from "@/Components/Elements/FormStep";
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

// Import des composables
import { useFormStorage } from "@/Composables/useFormStorage";
import { useWizardSteps } from "@/Composables/useWizardSteps";
import { useFormSubmission } from "@/Composables/useFormSubmission";
import { useFormValidation } from "@/Composables/useFormValidation";
import { useImageUpload } from "@/Composables/useImageUpload";

const props = defineProps({
    pieces: {
        type: Array,
        required: true
    },
    wantReward: {
        type: Boolean,
        default: true
    }
});

// État initial du formulaire avec une structure claire
const initialFormData = {
    step1: {
        fullName: '',
        findCity: '',
        piece_id: null,
        findDate: '',
        pieceCondition: '',
        pieceDescription: '',
        images: []
    },
    step2: {
        isAnonymous: !props.wantReward,
        accountData: { name: '', email: '', phone: '', city: '' },
        anonymousData: { localisation: '' },
        localisation: '',
        depositDate: '',
        pickupHours: '',
        additionalInfo: ''
    },
    step3: {
        amount_choice: ''
    }
};

// Utiliser les composables
const { data: formData, saveData, loadData, clearData } = useFormStorage(initialFormData);
const formWizardRef = ref(null);
const additionalDetails = ref('');

// Configuration et utilisation des composables
const { selectedImages, updateImages } = useImageUpload((images) => {
    if (formData.value.step1) {
        formData.value.step1.images = [...images];
        saveData();
    }
});

// Obtenir les variables de validation du formulaire
const { validationSchema, showRewardStep, showPersonalInfoStep } = useFormValidation(props.wantReward);

// Configuration des étapes du wizard
const stepsConfig = computed(() => {
    const baseSteps = [
        {
            number: '1',
            name: 'Informations pièce retrouvée',
            icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
        }
    ];

    // Si l'utilisateur ne veut pas de récompense, ajouter l'étape des informations de dépôt
    if (showPersonalInfoStep.value) {
        baseSteps.push({
            number: String(baseSteps.length + 1),
            name: 'Lieu de dépôt',
            icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'
        });
    }

    // Si l'utilisateur veut une récompense, ajouter l'étape de récompense
    if (showRewardStep.value) {
        baseSteps.push({
            number: String(baseSteps.length + 1),
            name: 'Récompense',
            icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        });
    }

    return baseSteps;
});

// Initialiser le gestionnaire d'étapes
const {
    currentStep,
    progressWidth: progressBarWidth,
    steps,
    updateStep,
    currentSectionName,
    canNavigateToStep,
    goToStep
} = useWizardSteps(0, stepsConfig.value);

// Mettre à jour les étapes lorsque la configuration change
watch(stepsConfig, (newSteps) => {
    steps.value = newSteps;
}, { deep: true });

// Obtenir les fonctions de soumission du formulaire
const { isLoading: isLoadingRegisterPiece, validationErrors, submitForm } = useFormSubmission();

// Variable pour stocker le montant de la récompense
const amount = ref('');

// Fonction de débogage simplifiée
const debugForm = () => {
    // Forcer la soumission manuelle
    if (formWizardRef.value) {
        onSubmit(formData.value);
    } else {
        console.error('Référence au formulaire non disponible');
    }
};

/**
 * Gère la soumission du formulaire
 * Utilise le composable useFormSubmission pour la logique principale
 */
const onSubmit = async (submitData) => {
    console.log('onSubmit called with:', submitData);

    try {
        // Déterminer si on veut une récompense à partir des props
        const wantReward = !!props.wantReward;

        // Déterminer si l'utilisateur est en mode anonyme
        // Accepter différentes représentations possibles d'une valeur booléenne
        const isUserAnonymous = [
            '1', 1, 'true', true, 'on', 'yes'
        ].includes(submitData.checkAnnonymary) || [
            '1', 1, 'true', true, 'on', 'yes'
        ].includes(submitData.is_anonymous);

        console.log('checkAnnonymary reçu:', submitData.checkAnnonymary);

        console.log('Mode récompense:', wantReward ? 'OUI' : 'NON');
        console.log('Mode anonyme:', isUserAnonymous ? 'OUI' : 'NON');

        // S'assurer que nous avons une structure de données qui correspond à ce que le composable attend
        // Même si nous utilisons un formulaire plat, nous devons structurer les données par étape pour le composable
        const formattedData = {
            // Générer une structure par étape pour le composable
            step1: {
                piece_id: submitData.piece_id,
                fullName: submitData.fullName,
                findCity: submitData.findCity,
                findDate: submitData.findDate,
                pieceCondition: submitData.pieceCondition,
                pieceDescription: submitData.pieceDescription,
                additionalDetails: submitData.additionalDetails,
                ward: submitData.ward
            },
            step2: wantReward ? {
                // Pour le cas avec récompense
                isAnonymous: isUserAnonymous,
                accountData: {
                    // S'assurer que ces champs ont toujours des valeurs par défaut car ils sont obligatoires
                    name: submitData.name || 'Utilisateur Connecté',
                    email: submitData.email || 'user@example.com',
                    phone: submitData.phone_number || '0123456789',
                    city: submitData.city || 'Ville par défaut'
                },
                anonymousData: {
                    // Pour le mode anonyme, la localisation est requise
                    localisation: submitData.localisation || 'Lieu de dépôt non spécifié'
                }
            } : {
                // Pour le cas sans récompense
                // S'assurer que tous les champs obligatoires ont des valeurs par défaut
                localisation: submitData.localisation || 'Lieu de dépôt non spécifié',
                depositDate: submitData.depositDate || new Date().toISOString().split('T')[0],
                pickupHours: submitData.pickup_hours || '9h-17h',
                additionalInfo: submitData.additionalInfo || submitData.special_instructions || 'Aucune information supplémentaire'
            },
            step3: wantReward ? {
                amount_choice: submitData.amount_check || '1000'
            } : {}
        };

        console.log('Données formatées pour soumission:', formattedData);

        // Utiliser notre composable pour la soumission
        const response = await submitForm(formattedData, selectedImages.value, wantReward);

        // En cas de succès, effacer les données locales et rediriger
        clearData();
        console.log('Formulaire soumis avec succès!', response);
        window.location.href = '/';
    } catch (error) {
        console.error('Erreur lors de la soumission:', error);
        // La gestion des erreurs est déjà dans le composable useFormSubmission
    }
};

/**
 * Gère le changement d'étape lors de la navigation du Wizard
 */
const handleStepChange = (step) => {
    updateStep(step);
};

/**
 * Gère le passage à l'étape suivante après validation
 */
const handleNextStep = (step) => {
    updateStep(step);
    saveData(formData.value);
};

/**
 * Gère les changements de données du formulaire
 */
const handleFormDataChange = (data) => {
    const step = `step${currentStep.value.index + 1}`;
    const currentData = JSON.stringify(formData.value[step]);
    const newData = JSON.stringify(data);

    if (currentData !== newData) {
        formData.value[step] = JSON.parse(JSON.stringify(data)); // Copie profonde
        saveData(formData.value);
    }
};

/**
 * Gère le changement de mode anonyme vs compte utilisateur
 */
const handleModeChange = (isAnonymous) => {
    if (formData.value.step2.isAnonymous !== isAnonymous) {
        formData.value.step2.isAnonymous = isAnonymous;
        saveData(formData.value);
    }
};

/**
 * Sauvegarde l'état actuel du formulaire lors de changements
 */
const validateCurrentStep = () => {
    saveData(formData.value);
};

// Les watches sont gérés à l'intérieur du composable useWizardSteps

// Fonction pour mettre à jour le montant de la récompense
const updateAmount = (newAmount) => {
    amount.value = newAmount;
};

</script>

<template>

    <Head title="Déclarer une découverte" />

    <Layout>
        <div class="min-h-screen bg-gray-50">
            <HeaderPage>
                <template #headerPage>
                    <div class="bg-white shadow-sm border-b border-gray-200 px-4 py-6">
                        <div class="flex items-center space-x-4">
                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ getSectionName }}
                            </h1>
                        </div>
                    </div>
                </template>
            </HeaderPage>

            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <!-- Progress Section -->
                <div class="max-w-4xl mx-auto mb-12">
                    <nav aria-label="Progress">
                        <div class="relative">
                            <div class="absolute top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200">
                                <div class="h-full bg-blue-600 transition-all duration-500 ease-in-out"
                                    :style="{ width: progressBarWidth }"></div>
                            </div>

                            <div class="relative flex justify-between">
                                <template v-for="(step, index) in steps" :key="index">
                                    <div class="flex flex-col items-center"
                                        @click="canNavigateToStep(index) && goToStep(index)">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-full transition-all duration-300"
                                            :class="[
                                                index < currentStep.index ? 'bg-blue-600 text-white' :
                                                    index === currentStep.index ? 'bg-blue-100 border-2 border-blue-600 text-blue-600' :
                                                        'bg-white border-2 border-gray-300 text-gray-400'
                                            ]">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path :d="step.icon" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" />
                                            </svg>
                                        </div>
                                        <div class="mt-2 text-sm font-medium" :class="[
                                            index <= currentStep.index ? 'text-blue-600' : 'text-gray-500'
                                        ]">
                                            {{ step.name }}
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </nav>
                </div>

                <!-- Form Section -->
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white shadow-lg rounded-3xl overflow-hidden border border-gray-100">
                        <!-- Bouton de déboggage -->
                        <div class="bg-yellow-100 p-4 text-center">
                            <button @click="debugForm" type="button"
                                class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                Déboguer le formulaire
                            </button>
                        </div>

                        <!-- Afficher les erreurs de validation si présentes -->
                        <div v-if="validationErrors"
                            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <h3 class="font-bold">Erreurs de validation:</h3>
                            <ul class="list-disc pl-5">
                                <li v-for="(error, field) in validationErrors" :key="field">
                                    {{ field }}: {{ error[0] }}
                                </li>
                            </ul>
                        </div>

                        <FormWizard :validation-schema="validationSchema" @submit="onSubmit" @next="handleNextStep"
                            @CURRENT_STEP="handleStepChange" ref="formWizardRef">
                            <FormStep>
                                <template #header>
                                    <div class="relative">
                                        <div class="px-8 py-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-white">
                                            <div class="flex items-center space-x-5">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transform -rotate-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900">
                                                        Informations de la pièce
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Renseignez les détails de la pièce que vous avez trouvée
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="p-8">
                                    <div class="bg-gray-50/50 rounded-2xl p-6 backdrop-blur-sm border border-gray-100">
                                        <InforObject :pieces="pieces" :stored-images="selectedImages"
                                            :initial-data="formData.step1" @amount="updateAmount"
                                            @update-images="updateImages" @form-data-change="handleFormDataChange"
                                            v-model:additionalDetails="additionalDetails" class="space-y-6" />
                                    </div>
                                </div>
                            </FormStep>

                            <!-- Étape 2 pour les utilisateurs qui ne veulent pas de récompense (information de dépôt anonyme) -->
                            <FormStep v-if="showPersonalInfoStep">
                                <template #header>
                                    <div class="relative">
                                        <div class="px-8 py-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-white">
                                            <div class="flex items-center space-x-5">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transform -rotate-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900">
                                                        Lieu de dépôt de la pièce
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Indiquez où et quand la pièce pourra être récupérée
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="p-8">
                                    <div class="bg-gray-50/50 rounded-2xl p-6 backdrop-blur-sm border border-gray-100">
                                        <div class="space-y-8">
                                            <!-- Lieu de dépôt avec icône de localisation -->
                                            <div class="form-group">
                                                <label for="localisation"
                                                    class="form-label flex items-center text-gray-700 text-md font-medium mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 mr-2 text-indigo-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Lieu de dépôt
                                                </label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-indigo-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                                        </svg>
                                                    </div>
                                                    <input id="localisation" v-model="formData.step2.localisation"
                                                        type="text"
                                                        class="pl-10 py-3 px-4 block w-full border-2 border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm transition duration-200 ease-in-out"
                                                        placeholder="Commissariat, Mairie, Bureau de poste..."
                                                        @input="validateCurrentStep" />
                                                </div>
                                                <ErrorMessage name="localisation" class="text-red-500 text-sm mt-1" />
                                                <p class="text-sm text-gray-500 mt-2 ml-2 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-1 text-indigo-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Ex: Commissariat du 12ème arrondissement, Mairie de Lyon, etc.
                                                </p>
                                            </div>

                                            <!-- Date de dépôt avec icône de calendrier -->
                                            <div class="form-group">
                                                <label for="depositDate"
                                                    class="form-label flex items-center text-gray-700 text-md font-medium mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 mr-2 text-indigo-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Date de dépôt
                                                </label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-indigo-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <input id="depositDate" v-model="formData.step2.depositDate"
                                                        type="date"
                                                        class="pl-10 py-3 px-4 block w-full border-2 border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm transition duration-200 ease-in-out"
                                                        @input="validateCurrentStep" />
                                                </div>
                                                <ErrorMessage name="depositDate" class="text-red-500 text-sm mt-1" />
                                            </div>

                                            <!-- Horaires de récupération avec icône d'horloge -->
                                            <div class="form-group">
                                                <label for="pickupHours"
                                                    class="form-label flex items-center text-gray-700 text-md font-medium mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 mr-2 text-indigo-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Horaires de récupération
                                                </label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-indigo-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <input id="pickupHours" v-model="formData.step2.pickupHours"
                                                        type="text"
                                                        class="pl-10 py-3 px-4 block w-full border-2 border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm transition duration-200 ease-in-out"
                                                        placeholder="Lundi-Vendredi, 9h-17h"
                                                        @input="validateCurrentStep" />
                                                </div>
                                                <ErrorMessage name="pickupHours" class="text-red-500 text-sm mt-1" />
                                                <p class="text-sm text-gray-500 mt-2 ml-2 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-1 text-indigo-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Ex: Lundi au vendredi, 9h-17h
                                                </p>
                                            </div>

                                            <!-- Informations complémentaires avec icône de note -->
                                            <div class="form-group">
                                                <label for="additionalInfo"
                                                    class="form-label flex items-center text-gray-700 text-md font-medium mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 mr-2 text-indigo-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Informations complémentaires (optionnel)
                                                </label>
                                                <div class="relative">
                                                    <QuillEditor id="additionalInfo"
                                                        v-model:content="formData.step2.additionalInfo" theme="snow"
                                                        toolbar="essential"
                                                        class="block w-full border-2 border-indigo-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm transition duration-200 ease-in-out"
                                                        placeholder="Précisions sur le lieu, contact, personne à demander..."
                                                        @text-change="validateCurrentStep" contentType="html" />
                                                </div>
                                                <ErrorMessage name="additionalInfo" class="text-red-500 text-sm mt-1" />
                                                <p class="text-sm text-gray-500 mt-2 ml-2 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-1 text-indigo-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Précisions sur le lieu de dépôt, contact sur place, etc.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </FormStep>

                            <FormStep v-if="showRewardStep">
                                <template #header>
                                    <div class="relative">
                                        <div class="px-8 py-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-white">
                                            <div class="flex items-center space-x-5">
                                                <div class="flex-shrink-0">
                                                    <div
                                                        class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transform -rotate-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900">
                                                        Récompense
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Choisissez si vous souhaitez une récompense pour avoir retrouvé
                                                        ce document
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="p-8">
                                    <div class="bg-gray-50/50 rounded-2xl p-6 backdrop-blur-sm border border-gray-100">
                                        <Validation :amount="amount" :is-anonymous="checkAnnonymary"
                                            :initial-data="formData.step3" @form-data-change="handleFormDataChange"
                                            class="space-y-6" />
                                    </div>
                                </div>
                            </FormStep>
                        </FormWizard>
                    </div>
                </div>
            </div>
        </div>
    </Layout>

</template>

<style scoped>
.form-section {
    @apply bg-white rounded-lg shadow-lg p-8;
}

/* Styles améliorés pour les inputs */
input,
textarea {
    @apply hover:border-indigo-400 hover:shadow-md transition-all ease-in-out duration-300;
    outline: none !important;
}

input:focus,
textarea:focus {
    @apply ring-4 ring-indigo-100 border-indigo-500 shadow-md;
    outline: none !important;
}

/* Animation de l'icône lors du focus */
input:focus+.absolute svg,
textarea:focus+.absolute svg {
    @apply text-indigo-600 transform scale-110;
    transition: all 0.3s;
}


.step-header {
    @apply text-center mb-8;
}

.step-title {
    @apply text-xl font-semibold text-gray-900;
}

.step-description {
    @apply mt-2 text-sm text-gray-500;
}

.progress-line {
    @apply absolute top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200;
}

.progress-indicator {
    @apply h-full bg-blue-600 transition-all duration-500 ease-in-out;
}

.step-icon {
    @apply flex items-center justify-center w-12 h-12 rounded-full transition-all duration-300;
}

.step-icon-active {
    @apply bg-blue-100 border-2 border-blue-600 text-blue-600;
}

.step-icon-completed {
    @apply bg-blue-600 text-white;
}

.step-icon-pending {
    @apply bg-white border-2 border-gray-300 text-gray-400;
}

.step-label {
    @apply mt-2 text-sm font-medium;
}

.step-label-active {
    @apply text-blue-600;
}

.step-label-pending {
    @apply text-gray-500;
}
</style>
