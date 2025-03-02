<template>
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm p-8">
        <!-- En-tête du formulaire -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Vos informations</h2>
            <p class="text-gray-600">Comment souhaitez-vous procéder pour la restitution de la pièce ?</p>
        </div>

        <!-- Option Anonymat -->
        <div class="mb-8">
            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                <input type="radio" id="account" name="submissionType" :value="false" v-model="isAnonymous"
                    class="w-5 h-5 text-blue-600 bg-gray-100 rounded-full border-gray-300 focus:ring-blue-500 focus:ring-2" />
                <label for="account" class="ml-3 flex-1 cursor-pointer">
                    <span class="block font-medium text-gray-900">Créer un compte</span>
                    <span class="block text-sm text-gray-500 mt-1">
                        Créez un compte pour suivre l'état de votre déclaration et être notifié
                    </span>
                </label>
            </div>

            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 mt-4">
                <input type="radio" id="anonymous" name="submissionType" :value="true" v-model="isAnonymous"
                    class="w-5 h-5 text-blue-600 bg-gray-100 rounded-full border-gray-300 focus:ring-blue-500 focus:ring-2" />
                <label for="anonymous" class="ml-3 flex-1 cursor-pointer">
                    <span class="block font-medium text-gray-900">Rester anonyme</span>
                    <span class="block text-sm text-gray-500 mt-1">
                        Déposez la pièce dans un lieu sécurisé sans créer de compte
                    </span>
                </label>
            </div>
        </div>

        <!-- Formulaire selon le choix -->
        <transition name="fade" mode="out-in">
            <component :is="currentFormComponent" :key="isAnonymous ? 'anonymous' : 'account'"
                :initial-data="isAnonymous ? anonymousData : accountData" @form-data-change="handleFormDataChange" />
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import AccountForm from './Forms/AccountForm.vue';
import AnonymousForm from './Forms/AnonymousForm.vue';

const props = defineProps({
    savedData: {
        type: Object,
        default: () => ({
            isAnonymous: false,
            accountData: {},
            anonymousData: {}
        }),
        // Vérifier que les données sauvegardées ont une structure valide
        validator: (value) => {
            if (!value) return false;
            // S'assurer que les propriétés nécessaires existent, sinon les créer
            if (typeof value.isAnonymous !== 'boolean') value.isAnonymous = false;
            if (!value.accountData) value.accountData = {};
            if (!value.anonymousData) value.anonymousData = {};
            return true;
        }
    }
});

const emit = defineEmits(['modeChange', 'formDataChange']);

// S'assurer que les données sauvegardées ont la structure attendue
const isAnonymous = ref(typeof props.savedData?.isAnonymous === 'boolean' ? props.savedData.isAnonymous : false);
const accountData = ref(props.savedData?.accountData || {});
const anonymousData = ref(props.savedData?.anonymousData || {});

// Log pour débogage
console.log('YourInformation init avec:', { 
    isAnonymous: isAnonymous.value, 
    accountData: accountData.value, 
    anonymousData: anonymousData.value 
});

// Émettre les données au montage du composant pour garantir la consistance
onMounted(() => {
    // Informer le parent de l'état initial
    emit('formDataChange', {
        isAnonymous: isAnonymous.value,
        accountData: accountData.value,
        anonymousData: anonymousData.value
    });
});

// Composant de formulaire dynamique
const currentFormComponent = computed(() => {
    return isAnonymous.value ? AnonymousForm : AccountForm;
});

// Gérer les changements de mode
watch(isAnonymous, (newValue) => {
    emit('modeChange', newValue);
    
    // Émettre les données actuelles pour une mise à jour complète
    emit('formDataChange', {
        isAnonymous: newValue,
        accountData: accountData.value,
        anonymousData: anonymousData.value
    });
});

// Gérer les changements de données du formulaire
const handleFormDataChange = (data) => {
    if (isAnonymous.value) {
        anonymousData.value = data;
    } else {
        accountData.value = data;
    }

    emit('formDataChange', {
        isAnonymous: isAnonymous.value,
        accountData: accountData.value,
        anonymousData: anonymousData.value
    });
};
</script>

<style scoped>
.form-group {
    @apply relative;
}

.form-label {
    @apply block mb-2 text-sm font-medium text-gray-900;
}

.form-input {
    @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors duration-200;
}

.form-textarea {
    @apply block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200;
}

.form-error {
    @apply mt-2 text-sm text-red-600;
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>