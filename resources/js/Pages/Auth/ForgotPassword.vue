<script setup>
import { computed, ref } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const emailSent = ref(false);
const isSubmitting = computed(() => form.processing);

const submit = () => {
    form.post(route('password.email'), {
        onSuccess: () => {
            emailSent.value = true;
        },
    });
};
</script>

<template>
    <BreezeGuestLayout>

        <Head title="Récupération de mot de passe" />

        <div class="text-center mb-8">
            <img src="/images/logo.svg" alt="DocuTrace logo" class="h-16 mx-auto mb-4"
                onerror="this.onerror=null; this.src='/favicon.ico'; this.classList.add('h-10');">
            <h1 class="text-2xl font-bold text-gray-800">Récupération de mot de passe</h1>
        </div>

        <div v-if="!emailSent" class="bg-white rounded-lg p-6 shadow-md mb-6 transition-all">
            <div class="mb-6 text-gray-600 border-l-4 border-blue-500 pl-4 py-2 bg-blue-50 rounded">
                Indiquez l'adresse e-mail associée à votre compte, et nous vous enverrons un lien pour réinitialiser
                votre mot de passe.
            </div>

            <div v-if="status"
                class="mb-6 font-medium text-green-600 bg-green-50 p-3 rounded-md border border-green-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ status }}
            </div>

            <BreezeValidationErrors class="mb-6" />

            <form @submit.prevent="submit">
                <div class="mb-6">
                    <BreezeLabel for="email" value="Adresse e-mail" class="text-gray-700 font-semibold" />
                    <BreezeInput id="email" type="email"
                        class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                        v-model="form.email" required autofocus autocomplete="username" placeholder="votre@email.com" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <Link :href="route('login')"
                        class="text-sm text-gray-600 hover:text-blue-500 underline transition-colors">
                    Retour à la connexion
                    </Link>
                    <BreezeButton type="submit"
                        class="bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 text-white px-6 py-2 rounded-md transition-all"
                        :class="{ 'opacity-75 cursor-not-allowed': isSubmitting }" :disabled="isSubmitting">
                        <span v-if="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Envoi en cours...
                        </span>
                        <span v-else>Envoyer le lien de récupération</span>
                    </BreezeButton>
                </div>
            </form>
        </div>

        <div v-else class="bg-white rounded-lg p-6 shadow-md text-center">
            <div class="mb-6 text-green-600 flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h2 class="text-xl font-bold mb-2">Vérifiez votre boîte mail</h2>
                <p class="text-gray-600">Nous avons envoyé un lien de récupération à l'adresse e-mail fournie. Veuillez
                    vérifier votre boîte de réception et suivre les instructions.</p>
            </div>

            <div class="text-gray-500 mt-4 text-sm border-t pt-4">
                <p>Si vous ne recevez pas l'e-mail dans les prochaines minutes, veuillez vérifier votre dossier de spam
                    ou essayer à nouveau.</p>
            </div>

            <div class="mt-6">
                <Link :href="route('login')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 text-white rounded-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Retour à la connexion
                </Link>
            </div>
        </div>

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Vous n'avez pas encore de compte ?
                <Link :href="route('register')" class="text-blue-600 hover:underline">
                S'inscrire
                </Link>
            </p>
        </div>
    </BreezeGuestLayout>
</template>
