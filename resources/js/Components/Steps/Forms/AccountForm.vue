<template>
    <div class="space-y-6">
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Créez votre compte pour suivre l'état de votre déclaration
                    </p>
                </div>
            </div>
        </div>

        <!-- Utiliser les données initiales du parent -->
        <Form @submit="onSubmit" :validation-schema="schema" :initial-values="props.initialData" v-slot="{ errors, values }">
            <div class="grid grid-cols-1 gap-6">
                <div class="form-group">
                    <label for="name" class="form-label">Nom complet</label>
                    <Field name="name" type="text" class="form-input" :class="{ 'error': errors.name }" />
                    <ErrorMessage name="name" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <Field name="email" type="email" class="form-input" :class="{ 'error': errors.email }" />
                    <ErrorMessage name="email" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="form-group">
                    <label for="phone_number" class="form-label">Numéro de téléphone</label>
                    <Field name="phone_number" type="tel" class="form-input"
                        :class="{ 'error': errors.phone_number }" />
                    <ErrorMessage name="phone_number" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">Ville</label>
                    <Field name="city" type="text" class="form-input" :class="{ 'error': errors.city }" />
                    <ErrorMessage name="city" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="bg-blue-50 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Un mot de passe sera généré automatiquement et envoyé à votre adresse email.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </Form>
    </div>
</template>

<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import { onMounted } from 'vue';
import * as yup from 'yup';

const props = defineProps({
    initialData: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['form-data-change']);

const schema = yup.object({
    name: yup.string().required('Votre nom est requis'),
    email: yup.string().email('Email invalide').required('Votre email est requis'),
    phone_number: yup.string().required('Votre numéro de téléphone est requis'),
    city: yup.string().required('Votre ville est requise'),
    // Les champs de mot de passe ont été retirés car ils sont générés automatiquement
});

const onSubmit = (values) => {
    emit('form-data-change', values);
};

// Émettre les valeurs initiales au montage pour s'assurer que le parent a les données
onMounted(() => {
    if (Object.keys(props.initialData).length > 0) {
        emit('form-data-change', props.initialData);
    }
});
</script>

<style scoped>
.form-label {
    @apply block text-sm font-medium text-gray-700 mb-1;
}

.form-input {
    @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition duration-150 ease-in-out;
}

.form-input.error {
    --tw-border-opacity: 1;
    border-color: rgb(239 68 68 / var(--tw-border-opacity));
}

.form-input.error:focus {
    --tw-border-opacity: 1;
    border-color: rgb(239 68 68 / var(--tw-border-opacity));
    --tw-ring-opacity: 1;
    --tw-ring-color: rgb(239 68 68 / var(--tw-ring-opacity));
}

.form-group {
    @apply relative;
}
</style>
