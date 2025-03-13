<script setup>
import { computed, ref } from 'vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const resetComplete = ref(false);
const isSubmitting = computed(() => form.processing);
const passwordStrength = ref('');
const passwordVisible = ref(false);
const confirmPasswordVisible = ref(false);

const checkPasswordStrength = () => {
    if (!form.password) {
        passwordStrength.value = '';
        return;
    }
    
    const hasUppercase = /[A-Z]/.test(form.password);
    const hasLowercase = /[a-z]/.test(form.password);
    const hasNumbers = /\d/.test(form.password);
    const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(form.password);
    const isLongEnough = form.password.length >= 8;
    
    const score = [hasUppercase, hasLowercase, hasNumbers, hasSpecialChars, isLongEnough].filter(Boolean).length;
    
    if (score <= 2) passwordStrength.value = 'faible';
    else if (score <= 4) passwordStrength.value = 'moyen';
    else passwordStrength.value = 'fort';
};

const togglePasswordVisibility = (field) => {
    if (field === 'password') {
        passwordVisible.value = !passwordVisible.value;
    } else {
        confirmPasswordVisible.value = !confirmPasswordVisible.value;
    }
};

const submit = () => {
    form.post(route('password.update'), {
        onSuccess: () => {
            resetComplete.value = true;
        },
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Réinitialisation de mot de passe" />

        <div class="text-center mb-8">
            <img src="/images/logo.svg" alt="DocuTrace logo" class="h-16 mx-auto mb-4"
                onerror="this.onerror=null; this.src='/favicon.ico'; this.classList.add('h-10');">
            <h1 class="text-2xl font-bold text-gray-800">Réinitialisation de mot de passe</h1>
        </div>

        <div v-if="!resetComplete" class="bg-white rounded-lg p-6 shadow-md mb-6 transition-all">
            <div class="mb-6 text-gray-600 border-l-4 border-blue-500 pl-4 py-2 bg-blue-50 rounded">
                Créez un nouveau mot de passe sécurisé pour votre compte. Utilisez une combinaison de lettres, chiffres et caractères spéciaux.
            </div>

            <BreezeValidationErrors class="mb-6" />

            <form @submit.prevent="submit">
                <div class="mb-6">
                    <BreezeLabel for="email" value="Adresse e-mail" class="text-gray-700 font-semibold" />
                    <BreezeInput 
                        id="email" 
                        type="email" 
                        class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                        v-model="form.email" 
                        required 
                        readonly 
                        autocomplete="username" 
                    />
                </div>

                <div class="mb-6">
                    <BreezeLabel for="password" value="Nouveau mot de passe" class="text-gray-700 font-semibold" />
                    <div class="relative">
                        <BreezeInput 
                            id="password" 
                            :type="passwordVisible ? 'text' : 'password'" 
                            class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                            v-model="form.password" 
                            @input="checkPasswordStrength"
                            required 
                            autocomplete="new-password" 
                        />
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 mt-2"
                            @click="togglePasswordVisibility('password')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <template v-if="passwordVisible">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </template>
                                <template v-else>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </template>
                            </svg>
                        </button>
                    </div>
                    
                    <div v-if="passwordStrength" class="mt-2">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div 
                                    class="h-full rounded-full" 
                                    :class="{
                                        'bg-red-500': passwordStrength === 'faible',
                                        'bg-yellow-500': passwordStrength === 'moyen',
                                        'bg-green-500': passwordStrength === 'fort'
                                    }"
                                    :style="{
                                        width: passwordStrength === 'faible' ? '33%' : passwordStrength === 'moyen' ? '66%' : '100%'
                                    }"
                                ></div>
                            </div>
                            <span 
                                class="text-xs font-medium" 
                                :class="{
                                    'text-red-500': passwordStrength === 'faible',
                                    'text-yellow-500': passwordStrength === 'moyen',
                                    'text-green-500': passwordStrength === 'fort'
                                }"
                            >
                                {{ passwordStrength.charAt(0).toUpperCase() + passwordStrength.slice(1) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <BreezeLabel for="password_confirmation" value="Confirmer le mot de passe" class="text-gray-700 font-semibold" />
                    <div class="relative">
                        <BreezeInput 
                            id="password_confirmation" 
                            :type="confirmPasswordVisible ? 'text' : 'password'" 
                            class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition" 
                            v-model="form.password_confirmation" 
                            required 
                            autocomplete="new-password" 
                        />
                        <button 
                            type="button" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 mt-2"
                            @click="togglePasswordVisibility('confirm')"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <template v-if="confirmPasswordVisible">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </template>
                                <template v-else>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </template>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        Les deux mots de passe doivent être identiques.
                    </p>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <Link :href="route('login')" class="text-sm text-gray-600 hover:text-blue-500 underline transition-colors mr-4">
                        Retour à la connexion
                    </Link>
                    <BreezeButton 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 text-white px-6 py-2 rounded-md transition-all"
                        :class="{ 'opacity-75 cursor-not-allowed': isSubmitting }" 
                        :disabled="isSubmitting"
                    >
                        <span v-if="isSubmitting" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Enregistrement...
                        </span>
                        <span v-else>Réinitialiser le mot de passe</span>
                    </BreezeButton>
                </div>
            </form>
        </div>

        <div v-else class="bg-white rounded-lg p-6 shadow-md text-center">
            <div class="mb-6 text-green-600 flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-xl font-bold mb-2">Mot de passe réinitialisé avec succès !</h2>
                <p class="text-gray-600">Votre mot de passe a été modifié. Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.</p>
            </div>

            <div class="mt-6">
                <Link :href="route('login')" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 text-white rounded-md transition-all">
                    Se connecter
                </Link>
            </div>
        </div>
    </BreezeGuestLayout>
</template>
