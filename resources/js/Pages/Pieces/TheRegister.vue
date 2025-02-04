<script setup>
import { ref, computed, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout";
import HeaderPage from "@/Layouts/HeaderPage";
import InforObject from "@/Components/Steps/InforObject";
import YourInformation from "@/Components/Steps/YourInformation";
import Validation from "@/Components/Steps/Validation";
import FormWizard from "@/Components/Elements/FormWizard";
import FormStep from "@/Components/Elements/FormStep";
import * as yup from "yup";
import { router } from '@inertiajs/vue3';

const props = defineProps({
    pieces: {
        type: Array,
        required: true
    }
});

const currentStepIdx = ref(0);
const amount = ref('');
const isLoadingRegisterPiece = ref(false);
const progressWidth = ref('0%');
const checkAnnonymary = ref(false);
const selectedImages = ref([]);  // Pour stocker les images sélectionnées
const additionalDetails = ref('');

// Fonction pour mettre à jour les images
const updateImages = (newImages) => {
    selectedImages.value = newImages;
};

const steps = [
    {
        number: '1',
        name: 'Informations pièce retrouvée',
        icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
    },
    {
        number: '2',
        name: 'Vos informations',
        icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'
    },
    {
        number: '3',
        name: 'Récompense',
        icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    }
];

const getSectionName = computed(() => {
    return steps[currentStepIdx.value]?.name || "Validation";
});

const validationSchema = [
    // Première étape - validation des informations de la pièce
    yup.object({
        fullName: yup.string().required('Le nom inscrit sur la pièce est une information importante'),
        findCity: yup.string().required("La ville où la pièce a été retrouvée est une information importante"),
        piece_id: yup.number().required("Le choix du type de pièce est important").positive().integer(),
        findDate: yup.date()
            .required("La date de découverte est importante")
            .max(new Date(), "La date ne peut pas être dans le futur"),
        pieceCondition: yup.string()
            .required("L'état de la pièce est important")
            .oneOf(['Excellent', 'Bon', 'Moyen', 'Mauvais'], "Veuillez sélectionner un état valide"),
        additionalDetails: yup.string().nullable()
    }),
    // Deuxième étape - validation des informations personnelles
    yup.object({
        localisation: yup.string().when('checkAnnonymary', {
            is: true,
            then: yup.string().required('Veuillez indiquer le lieu où vous avez déposé le document'),
            otherwise: yup.string().optional()
        }),
        name: yup.string().when('checkAnnonymary', {
            is: false,
            then: yup.string().required('Votre nom est requis'),
            otherwise: yup.string().optional()
        }),
        email: yup.string().when('checkAnnonymary', {
            is: false,
            then: yup.string().email().required('Votre email est requis'),
            otherwise: yup.string().optional()
        }),
        phone_number: yup.string().when('checkAnnonymary', {
            is: false,
            then: yup.string().required('Votre numéro de téléphone nous permettra de vous contacter'),
            otherwise: yup.string().optional()
        }),
        city: yup.string().when('checkAnnonymary', {
            is: false,
            then: yup.string().required('Votre ville de résidence est requise'),
            otherwise: yup.string().optional()
        })
    }),
    // Troisième étape - validation de la rémunération
    yup.object({
        amount_check: yup.string().required('La validation de la rémunération est importante'),
    })
];

const onSubmit = (formData) => {
    isLoadingRegisterPiece.value = true;
    router.post('/piece/enregistrer', formData, {
        onSuccess: () => {
            isLoadingRegisterPiece.value = false;
        },
        onError: () => {
            isLoadingRegisterPiece.value = false;
        }
    });
};

const updateStep = (step) => {
    currentStepIdx.value = step;
    // Mettre à jour la largeur de la barre de progression
    progressWidth.value = `${(step / (steps.length - 1)) * 100}%`;
};

// Ajouter un watcher pour s'assurer que la progression est toujours correcte
watch(currentStepIdx, (newVal) => {
    progressWidth.value = `${(newVal / (steps.length - 1)) * 100}%`;
}, { immediate: true });

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
                                    :style="{ width: progressWidth }"></div>
                            </div>

                            <div class="relative flex justify-between">
                                <template v-for="(step, index) in steps" :key="index">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-full transition-all duration-300"
                                            :class="[
                                                index < currentStepIdx ? 'bg-blue-600 text-white' :
                                                    index === currentStepIdx ? 'bg-blue-100 border-2 border-blue-600 text-blue-600' :
                                                        'bg-white border-2 border-gray-300 text-gray-400'
                                            ]">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path :d="step.icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                            </svg>
                                        </div>
                                        <div class="mt-2 text-sm font-medium" :class="[
                                            index <= currentStepIdx ? 'text-blue-600' : 'text-gray-500'
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
                        <FormWizard :validation-schema="validationSchema" @submit="onSubmit" @next="updateStep"
                            @CURRENT_STEP="updateStep">
                            <FormStep>
                                <template #header>
                                    <div class="relative">
                                        <div class="px-8 py-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-white">
                                            <div class="flex items-center space-x-5">
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transform -rotate-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
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
                                        <InforObject 
                                            :pieces="pieces" 
                                            :stored-images="selectedImages"
                                            @amount="updateAmount" 
                                            @update-images="updateImages"
                                            v-model:additionalDetails="additionalDetails" 
                                            class="space-y-6" 
                                        />
                                    </div>
                                </div>
                            </FormStep>

                            <FormStep>
                                <template #header>
                                    <div class="relative">
                                        <div class="px-8 py-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-white">
                                            <div class="flex items-center space-x-5">
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transform -rotate-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900">
                                                        Vos informations personnelles
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Ces informations nous permettront de vous contacter
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="p-8">
                                    <div class="bg-gray-50/50 rounded-2xl p-6 backdrop-blur-sm border border-gray-100">
                                        <YourInformation v-model="checkAnnonymary" class="space-y-6" />
                                    </div>
                                </div>
                            </FormStep>

                            <FormStep>
                                <template #header>
                                    <div class="relative">
                                        <div class="px-8 py-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-white">
                                            <div class="flex items-center space-x-5">
                                                <div class="flex-shrink-0">
                                                    <div class="w-12 h-12 flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg transform -rotate-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900">
                                                        Récompense
                                                    </h3>
                                                    <p class="mt-1 text-sm text-gray-500">
                                                        Choisissez si vous souhaitez une récompense pour avoir retrouvé ce document
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="p-8">
                                    <div class="bg-gray-50/50 rounded-2xl p-6 backdrop-blur-sm border border-gray-100">
                                        <Validation :amount="amount" :is-anonymous="checkAnnonymary" class="space-y-6" />
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
