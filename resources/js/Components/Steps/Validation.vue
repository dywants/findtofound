<template>
    <article>
        <div v-if="isAnonymous" class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Mode anonyme activé
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>
                            En restant anonyme, vous ne pourrez pas recevoir de récompense pour avoir retrouvé ce
                            document. Si vous souhaitez être récompensé(e), veuillez :
                        </p>
                        <ul class="list-disc list-inside mt-2">
                            <li>Retourner à l'étape précédente</li>
                            <li>Décocher l'option "Rester anonyme"</li>
                            <li>Remplir vos informations de contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Désirez-vous être récompensé ?</label>
            <div class="flex items-center space-x-3">
                <div class="flex items-center mb-2">
                    <Field type="radio" id="amount-yes" name="amount_choice" :value="amount" v-model="checkedNames"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" />
                    <label for="amount-yes" class="ml-2 text-sm font-medium text-gray-900">Oui</label>
                </div>

                <div class="flex items-center mb-2">
                    <Field type="radio" id="amount-no" name="amount_choice" value="0" v-model="checkedNames"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" />
                    <label for="amount-no" class="ml-2 text-sm font-medium text-gray-900">Non</label>
                </div>
            </div>
            <ErrorMessage name="amount_choice" class="mt-2 text-sm text-red-600" />

            <div v-if="checkedNames && checkedNames !== '0'" class="mt-4 p-4 bg-green-50 rounded-lg">
                <label class="text-gray-800 text-sm">
                    Votre récompense sera de :
                    <span class="text-green-700 text-lg font-semibold ml-1">{{ checkedNames }} FCFA</span>
                </label>
            </div>
        </div>
    </article>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";

export default {
    name: "Validation",
    components: { Field, ErrorMessage },
    props: {
        amount: {
            type: [String, Number],
            required: true
        },
        isAnonymous: {
            type: Boolean,
            required: true,
            default: false
        }
    },
    data() {
        return {
            checkedNames: ''
        }
    },
    watch: {
        isAnonymous: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.checkedNames = '0';
                }
            }
        }
    }
}
</script>