<template>
    <div class="space-y-6">
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        Indiquez où et quand la pièce pourra être récupérée
                    </p>
                </div>
            </div>
        </div>

        <!-- Utiliser les données initiales du parent -->
        <Form @submit="onSubmit" :validation-schema="schema" :initial-values="props.initialData" v-slot="{ errors, values }">
            <div class="grid grid-cols-1 gap-6">
                <div class="form-group">
                    <label for="localisation" class="form-label">Lieu de dépôt</label>
                    <Field name="localisation" type="text" class="form-input"
                        :class="{ 'error': errors.localisation }" />
                    <ErrorMessage name="localisation" class="text-red-500 text-sm mt-1" />
                    <p class="text-sm text-gray-500 mt-1">Ex: Commissariat du 12ème arrondissement, Mairie de Lyon, etc.
                    </p>
                </div>

                <div class="form-group">
                    <label for="depositDate" class="form-label">Date de dépôt</label>
                    <Field name="depositDate" type="date" class="form-input" :class="{ 'error': errors.depositDate }" />
                    <ErrorMessage name="depositDate" class="text-red-500 text-sm mt-1" />
                </div>

                <div class="form-group">
                    <label for="pickupHours" class="form-label">Horaires de récupération</label>
                    <Field name="pickupHours" type="text" class="form-input" :class="{ 'error': errors.pickupHours }" />
                    <ErrorMessage name="pickupHours" class="text-red-500 text-sm mt-1" />
                    <p class="text-sm text-gray-500 mt-1">Ex: Lundi au vendredi, 9h-17h</p>
                </div>

                <div class="form-group">
                    <label for="additionalInfo" class="form-label">Informations complémentaires (optionnel)</label>
                    <Field name="additionalInfo" as="textarea" class="form-input h-24"
                        :class="{ 'error': errors.additionalInfo }" />
                    <ErrorMessage name="additionalInfo" class="text-red-500 text-sm mt-1" />
                    <p class="text-sm text-gray-500 mt-1">Précisions sur le lieu de dépôt, contact sur place, etc.</p>
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
    localisation: yup.string().required('Veuillez indiquer le lieu où vous avez déposé le document'),
    depositDate: yup.date()
        .required('La date de dépôt est requise')
        .min(new Date(), 'La date de dépôt ne peut pas être dans le passé'),
    pickupHours: yup.string().required('Les horaires de récupération sont requis'),
    additionalInfo: yup.string().nullable()
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
    @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm transition duration-150 ease-in-out;
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

textarea.form-input {
    @apply resize-none;
}
</style>
