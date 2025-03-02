<template>
    <div class="w-full max-w-2xl mx-auto">
        <h3 class="text-2xl font-semibold text-gray-800 mb-6">Envoyez-nous un message</h3>
        
        <form @submit.prevent="submitForm">
            <div class="space-y-6">
                <!-- Nom -->
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input 
                        type="text" 
                        id="name" 
                        v-model="form.name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        :class="{'border-red-500': form.errors.name}" 
                        placeholder="Votre nom" 
                    />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        v-model="form.email" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        :class="{'border-red-500': form.errors.email}" 
                        placeholder="votre@email.com" 
                    />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>
                
                <!-- Sujet -->
                <div class="form-group">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                    <input 
                        type="text" 
                        id="subject" 
                        v-model="form.subject" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        :class="{'border-red-500': form.errors.subject}" 
                        placeholder="Sujet de votre message" 
                    />
                    <p v-if="form.errors.subject" class="mt-1 text-sm text-red-600">{{ form.errors.subject }}</p>
                </div>
                
                <!-- Message -->
                <div class="form-group">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea 
                        id="message" 
                        v-model="form.message" 
                        rows="5" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        :class="{'border-red-500': form.errors.message}" 
                        placeholder="Votre message..." 
                    ></textarea>
                    <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2"
                    :disabled="form.processing"
                >
                    <div v-if="form.processing" class="flex items-center justify-center">
                        <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Envoi en cours...
                    </div>
                    <span v-else>Envoyer le message</span>
                </button>
            </div>
        </form>
        
        <!-- Message de succès avec animation -->
        <transition
            enter-active-class="transform transition duration-500 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transform transition duration-300 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div v-if="success" class="mt-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-md flex items-start">
                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-medium">Message envoyé avec succès !</p>
                    <p class="text-sm">Nous vous répondrons dans les plus brefs délais.</p>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

// Utilisation du formulaire Inertia avec initialisation des champs
const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: ''
});

// États pour la gestion du traitement et des succès
const success = ref(false);
const formSubmitted = ref(false);

// Vérifier les messages flash de la session lors du chargement du composant
onMounted(() => {
    const page = usePage();
    if (page.props.flash && page.props.flash.success) {
        success.value = true;
        
        // Masquer le message après 5 secondes
        setTimeout(() => {
            success.value = false;
        }, 5000);
    }
});

// Validation de l'email avec une expression régulière
const validateEmail = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
};

// Validation du formulaire côté client avant envoi
const validateForm = () => {
    let isValid = true;
    
    // Réinitialiser les erreurs si le formulaire a déjà été soumis
    if (formSubmitted.value) {
        form.clearErrors();
    }
    
    // Validation du nom
    if (!form.name) {
        form.setError('name', 'Le nom est requis');
        isValid = false;
    }
    
    // Validation de l'email
    if (!form.email) {
        form.setError('email', 'L\'email est requis');
        isValid = false;
    } else if (!validateEmail(form.email)) {
        form.setError('email', 'Veuillez entrer une adresse email valide');
        isValid = false;
    }
    
    // Validation du sujet
    if (!form.subject) {
        form.setError('subject', 'Le sujet est requis');
        isValid = false;
    }
    
    // Validation du message
    if (!form.message) {
        form.setError('message', 'Le message est requis');
        isValid = false;
    } else if (form.message.length < 10) {
        form.setError('message', 'Votre message doit contenir au moins 10 caractères');
        isValid = false;
    }
    
    formSubmitted.value = true;
    return isValid;
};

// Visibilité des champs de formulaire au focus
const focusField = (field) => {
    if (formSubmitted.value && form.hasErrors && form.errors[field]) {
        form.clearErrors(field);
    }
};

// Soumission du formulaire
const submitForm = () => {
    success.value = false;
    
    // Vérification de validation avant envoi
    if (!validateForm()) {
        // Faire défiler jusqu'au premier champ en erreur
        const firstErrorField = document.querySelector('.border-red-500');
        if (firstErrorField) {
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstErrorField.focus();
        }
        return;
    }
    
    // Envoi du formulaire avec Inertia.js
    form.post(route('contact.submit'), {
        preserveScroll: true,
        onSuccess: () => {
            success.value = true;
            formSubmitted.value = false;
            
            // Faire défiler jusqu'au message de succès si nécessaire
            const successMessage = document.querySelector('.bg-green-100');
            if (successMessage) {
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            // Réinitialiser le formulaire après succès
            form.reset();
            
            // Masquer le message de succès après 5 secondes
            setTimeout(() => {
                success.value = false;
            }, 5000);
        },
        onError: (errors) => {
            console.error('Erreurs lors de la soumission:', errors);
            
            // Faire défiler jusqu'au premier champ en erreur
            setTimeout(() => {
                const firstErrorField = document.querySelector('.border-red-500');
                if (firstErrorField) {
                    firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorField.focus();
                }
            }, 100);
        }
    });
};
</script>

<style scoped>
.form-group {
    position: relative;
    transition: all 0.3s ease;
}

.form-group label {
    transition: all 0.2s ease;
}

.form-group:focus-within label {
    color: #d97706; /* yellow-600 */
}

input, textarea {
    transition: all 0.3s ease;
}

input:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.2);
}

button[type="submit"] {
    position: relative;
    overflow: hidden;
}

button[type="submit"]:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 5px;
    height: 5px;
    background: rgba(255, 255, 255, 0.5);
    opacity: 0;
    border-radius: 100%;
    transform: scale(1, 1) translate(-50%, -50%);
    transform-origin: 50% 50%;
}

button[type="submit"]:focus:not(:active)::after {
    animation: ripple 0.8s ease-out;
}

@keyframes ripple {
    0% {
        transform: scale(0, 0);
        opacity: 0.5;
    }
    100% {
        transform: scale(20, 20);
        opacity: 0;
    }
}

.border-red-500 {
    animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}

@keyframes shake {
    10%, 90% {
        transform: translate3d(-1px, 0, 0);
    }
    20%, 80% {
        transform: translate3d(2px, 0, 0);
    }
    30%, 50%, 70% {
        transform: translate3d(-3px, 0, 0);
    }
    40%, 60% {
        transform: translate3d(3px, 0, 0);
    }
}
</style>
