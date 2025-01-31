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
        name: 'Validation',
        icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
    }
];

const getSectionName = computed(() => {
    return steps[currentStepIdx.value]?.name || "Validation";
});

const validationSchema = [
    yup.object({
        fullName: yup.string().required('Le nom inscrit sur la pièce est une information importante'),
        findCity: yup.string().required("La ville où la pièce a été retrouvée est une information importante"),
        piece_id: yup.number().required("Le choix du type de pièce est important").positive().integer(),
        photos: yup.mixed().required("L'image est requise"),
    }),
    yup.object({
        name: yup.string().required('Votre nom est requis'),
        email: yup.string().email().required('Votre email est requis'),
        phone_number: yup.number().required('Votre numéro de téléphone nous permettra de vous contacter').positive().integer(),
    }),
    yup.object({
        amount_check: yup.string().required('La validation de la rémunération est importante'),
    })
];

const onSubmit = (formData) => {
    isLoadingRegisterPiece.value = true;
    router.post('/piece-enregistrer', formData, {
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
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                                Déclarer une découverte
                            </h2>
                        </div>
                    </div>
                </template>
            </HeaderPage>

            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <!-- Progress Section avec un meilleur espacement -->
                <div class="max-w-4xl mx-auto mb-12">
                    <!-- Step Title -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ getSectionName }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Étape {{ currentStepIdx + 1 }} sur {{ steps.length }}
                        </p>
                    </div>

                    <!-- Steps Indicators -->
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
                                            <path :d="step.icon" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" />
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
                </div>

                <!-- Form Section -->
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100">
                        <FormWizard :validation-schema="validationSchema" @submit="onSubmit" @CURRENT_STEP="updateStep">
                            <FormStep>
                                <template #header>
                                    <div
                                        class="px-8 py-10 bg-gradient-to-r from-blue-50 to-white border-b border-gray-100">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="p-2 bg-blue-100 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-900">
                                                    Informations de la pièce
                                                </h3>
                                                <p class="mt-3 text-base text-gray-600">
                                                    Renseignez les détails de la pièce que vous avez trouvée
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="px-8 py-10 bg-white">
                                    <InforObject :pieces="pieces" @amount="updateAmount" class="space-y-6" />
                                </div>
                            </FormStep>

                            <FormStep>
                                <template #header>
                                    <div
                                        class="px-8 py-10 bg-gradient-to-r from-blue-50 to-white border-b border-gray-100">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="p-2 bg-blue-100 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-900">
                                                    Vos informations personnelles
                                                </h3>
                                                <p class="mt-3 text-base text-gray-600">
                                                    Ces informations nous permettront de vous contacter
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="px-8 py-10 bg-white">
                                    <YourInformation class="space-y-6" />
                                </div>
                            </FormStep>

                            <FormStep>
                                <template #header>
                                    <div
                                        class="px-8 py-10 bg-gradient-to-r from-blue-50 to-white border-b border-gray-100">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0 mt-1">
                                                <div class="p-2 bg-blue-100 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-900">
                                                    Validation finale
                                                </h3>
                                                <p class="mt-3 text-base text-gray-600">
                                                    Vérifiez les informations avant de finaliser
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="px-8 py-10 bg-white">
                                    <Validation :amount="amount" class="space-y-6" />
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
