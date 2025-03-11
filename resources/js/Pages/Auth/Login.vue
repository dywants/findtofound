<template>

    <Head title="Connexion - DocuTrace" />

    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
        <!-- Header avec logo -->
        <header class="absolute top-0 left-0 w-full p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <Link :href="route('home')" class="flex items-center space-x-2">
                <img src="/images/logo.svg" alt="FindToFound Logo" class="h-8 w-auto" />
                </Link>
                <Link :href="route('register')" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                Pas encore de compte ? <span class="text-blue-600 hover:text-blue-700">Créer un compte</span>
                </Link>
            </div>
        </header>

        <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-xl p-8">
                <!-- En-tête du formulaire -->
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">
                        Bienvenue !
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Connectez-vous pour accéder à votre compte
                    </p>
                </div>

                <!-- Messages d'erreur et de statut -->
                <div class="space-y-4">
                    <BreezeValidationErrors :errors="errors" />
                    <div v-if="status" class="p-4 rounded-md bg-green-50">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <CheckCircleIcon class="h-5 w-5 text-green-400" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ status }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de connexion -->
                <form @submit.prevent="submit" class="mt-8 space-y-6">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Adresse email
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <MailIcon class="h-5 w-5 text-gray-400" />
                            </div>
                            <input id="email" type="email" v-model="form.email" required
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="vous@exemple.com" autocomplete="email" />
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Mot de passe
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <LockClosedIcon class="h-5 w-5 text-gray-400" />
                            </div>
                            <input id="password" type="password" v-model="form.password" required
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="••••••••" autocomplete="current-password" />
                        </div>
                    </div>

                    <!-- Options de connexion -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" v-model="form.remember"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                            <label for="remember" class="ml-2 block text-sm text-gray-900">
                                Se souvenir de moi
                            </label>
                        </div>

                        <div class="text-sm">
                            <Link v-if="canResetPassword" :href="route('password.request')"
                                class="font-medium text-blue-600 hover:text-blue-500">
                            Mot de passe oublié ?
                            </Link>
                        </div>
                    </div>

                    <!-- Bouton de connexion -->
                    <div>
                        <button type="submit" :disabled="form.processing"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <LockClosedIcon class="h-5 w-5 text-blue-500 group-hover:text-blue-400"
                                    aria-hidden="true" />
                            </span>
                            <span v-if="form.processing">Connexion en cours...</span>
                            <span v-else>Se connecter</span>
                        </button>
                    </div>
                </form>

                <!-- Séparateur -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou continuez avec</span>
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
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import {
    LockClosedIcon,
    EnvelopeIcon as MailIcon,
    CheckCircleIcon
} from '@heroicons/vue/24/solid';
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
    errors: Object,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<style scoped>
.bg-gradient-to-br {
    background-size: 400% 400%;
    animation: gradient 15s ease infinite;
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }

    50% {
        background-position: 100% 50%;
    }

    100% {
        background-position: 0% 50%;
    }
}
</style>
