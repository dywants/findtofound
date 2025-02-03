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
                <Field type="checkbox" id="anonymous" name="checkAnnommary" v-model="checkAnnommary"
                    class="w-5 h-5 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 focus:ring-2" />
                <label for="anonymous" class="ml-3 flex-1">
                    <span class="block font-medium text-gray-900">Rester anonyme</span>
                    <span class="block text-sm text-gray-500 mt-1">
                        Vous ne souhaitez pas créer de compte et préférez simplement indiquer où la pièce peut être
                        récupérée
                    </span>
                </label>
            </div>
        </div>

        <!-- Formulaire selon le choix -->
        <transition name="fade" mode="out-in">
            <!-- Mode Création de Compte -->
            <div v-if="checkAnnommary" key="account" class="space-y-6">
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                Un compte sera créé pour vous permettre de suivre la restitution
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Votre nom</label>
                        <Field type="text" name="name" id="name" class="form-input" placeholder="Jean Dupont" />
                        <ErrorMessage name="name" class="form-error" />
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Votre email</label>
                        <Field type="email" name="email" id="email" class="form-input"
                            placeholder="jean.dupont@example.com" />
                        <ErrorMessage name="email" class="form-error" />
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Numéro de téléphone</label>
                        <Field type="tel" name="phone_number" id="phone" class="form-input"
                            placeholder="+237 6XX XX XX XX" />
                        <ErrorMessage name="phone_number" class="form-error" />
                    </div>

                    <div class="form-group">
                        <label for="city" class="form-label">Ville de résidence</label>
                        <Field type="text" name="city" id="city" class="form-input" placeholder="Douala" />
                        <ErrorMessage name="city" class="form-error" />
                    </div>
                </div>
            </div>

            <!-- Mode Anonyme -->
            <div v-else key="anonymous" class="space-y-6">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
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
                                Pour faciliter la restitution du document, merci de fournir les informations suivantes
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Date et heure de dépôt -->
                    <div class="form-group">
                        <label for="depositDate" class="form-label">Date et heure de dépôt du document</label>
                        <Field type="datetime-local" id="depositDate" name="depositDate" class="form-input" />
                        <ErrorMessage name="depositDate" class="form-error" />
                        <p class="mt-2 text-sm text-gray-500">
                            Cette information aidera à tracer l'historique du document
                        </p>
                    </div>

                    <!-- Lieu de dépôt -->
                    <div class="form-group">
                        <label for="location" class="form-label">Lieu de dépôt du document</label>
                        <Field id="location" name="localisation" as="textarea" rows="4" class="form-textarea"
                            placeholder="Exemple : Commissariat de police du 2e arrondissement, bureau des objets trouvés..." />
                        <ErrorMessage name="localisation" class="form-error" />
                        <p class="mt-2 text-sm text-gray-500">
                            Soyez le plus précis possible pour faciliter la récupération
                        </p>
                    </div>

                    <!-- Personne ou service à contacter -->
                    <div class="form-group">
                        <label for="contactPerson" class="form-label">Personne ou service à contacter
                            (optionnel)</label>
                        <Field type="text" id="contactPerson" name="contactPerson" class="form-input"
                            placeholder="Ex: Bureau des objets trouvés, Agent de sécurité, etc." />
                        <ErrorMessage name="contactPerson" class="form-error" />
                        <p class="mt-2 text-sm text-gray-500">
                            Si vous avez confié le document à une personne ou un service spécifique
                        </p>
                    </div>

                    <!-- Horaires de récupération -->
                    <div class="form-group">
                        <label for="pickupHours" class="form-label">Horaires de récupération possibles
                            (optionnel)</label>
                        <Field id="pickupHours" name="pickupHours" as="textarea" rows="2" class="form-textarea"
                            placeholder="Ex: Du lundi au vendredi, 9h-17h" />
                        <ErrorMessage name="pickupHours" class="form-error" />
                        <p class="mt-2 text-sm text-gray-500">
                            Précisez les horaires pendant lesquels le document peut être récupéré
                        </p>
                    </div>

                    <!-- Instructions particulières -->
                    <div class="form-group">
                        <label for="specialInstructions" class="form-label">Instructions particulières
                            (optionnel)</label>
                        <Field id="specialInstructions" name="specialInstructions" as="textarea" rows="3"
                            class="form-textarea"
                            placeholder="Ex: Se présenter à l'accueil avec une pièce d'identité..." />
                        <ErrorMessage name="specialInstructions" class="form-error" />
                        <p class="mt-2 text-sm text-gray-500">
                            Toute information supplémentaire utile pour la récupération du document
                        </p>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";
import { ref, watch } from 'vue';

export default {
    name: 'YourInformation',
    components: { Field, ErrorMessage },
    props: {
        modelValue: {
            type: Boolean,
            required: true
        }
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
        const checkAnnommary = ref(props.modelValue);

        watch(checkAnnommary, (newValue) => {
            emit('update:modelValue', newValue);
        });

        return {
            checkAnnommary
        };
    }
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