<template>
    <!-- Conteneur principal avec animation d'apparition -->
<div class="w-full max-w-2xl mx-auto relative animate-fade-in" role="form" aria-labelledby="contact-form-title">
        <h3 id="contact-form-title" class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
    <svg class="w-6 h-6 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
    </svg>
    Envoyez-nous un message
</h3>
        
        <form @submit.prevent="submitForm">
            <div class="space-y-6">
                <!-- Nom -->
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
    </svg>
    Nom
</label>
                    <input 
                        type="text" 
                        id="name" 
                        v-model="form.name" 
                        @focus="focusField('name')"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-300"
                        :class="{'border-red-500 shake': form.errors.name, 'border-yellow-300 ring-1 ring-yellow-200': isFocused === 'name'}" 
                        placeholder="Votre nom"
                        aria-required="true"
                        autocomplete="name"
                    />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
    </svg>
    Email
</label>
                    <input 
                        type="email" 
                        id="email" 
                        v-model="form.email" 
                        @focus="focusField('email')"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-300"
                        :class="{'border-red-500 shake': form.errors.email, 'border-yellow-300 ring-1 ring-yellow-200': isFocused === 'email'}" 
                        placeholder="votre@email.com"
                        aria-required="true"
                        autocomplete="email"
                    />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>
                
                <!-- Sujet -->
                <div class="form-group">
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"></path>
    </svg>
    Sujet
</label>
                    <input 
                        type="text" 
                        id="subject" 
                        v-model="form.subject" 
                        @focus="focusField('subject')"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-300"
                        :class="{'border-red-500 shake': form.errors.subject, 'border-yellow-300 ring-1 ring-yellow-200': isFocused === 'subject'}" 
                        placeholder="Sujet de votre message"
                        aria-required="true"
                    />
                    <p v-if="form.errors.subject" class="mt-1 text-sm text-red-600">{{ form.errors.subject }}</p>
                </div>
                
                <!-- Message -->
                <div class="form-group">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
    </svg>
    Message
</label>
                    <textarea 
                        id="message" 
                        v-model="form.message" 
                        @focus="focusField('message')"
                        rows="5" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-300"
                        :class="{'border-red-500 shake': form.errors.message, 'border-yellow-300 ring-1 ring-yellow-200': isFocused === 'message'}" 
                        placeholder="Votre message..."
                        aria-required="true"
                    ></textarea>
                    <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2"
                    :disabled="form.processing"
                >
                    <div v-if="form.processing" class="flex items-center justify-center" aria-live="polite">
                        <svg class="animate-spin h-5 w-5 mr-3 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Envoi en cours...</span>
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
            <div v-if="success" class="mt-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-md flex items-start" role="alert" aria-live="polite">
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
const isFocused = ref(null); // Pour suivre le champ actuellement en focus

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
    // Définir le champ actuellement en focus
    isFocused.value = field;
    
    // Effacer les erreurs si le formulaire a été soumis et contient des erreurs
    if (formSubmitted.value && form.hasErrors && form.errors[field]) {
        form.clearErrors(field);
    }
    
    // Ajouter un gestionnaire d'événement pour le blur
    setTimeout(() => {
        const element = document.getElementById(field);
        if (element) {
            element.addEventListener('blur', () => {
                isFocused.value = null;
            }, { once: true });
        }
    }, 0);
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
/* Animation d'apparition */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

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
