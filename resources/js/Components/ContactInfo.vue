<template>
    <div class="flex flex-col w-full px-4">
        <h2 class="text-3xl md:text-5xl text-yellow-500 my-4 leading-relaxed md:leading-snug">
            Contacter notre equipe
        </h2>
        
        <div class="space-y-4 mt-4">
            <div class="contact-item flex items-start group">
                <svg class="flex-shrink-0 w-6 h-6 fill-current text-yellow-500 mr-3 mt-1 transition-all duration-300 group-hover:text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                   <path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z" />
                </svg>
                <div class="relative flex-grow">
                    <span class="font-sans text-sm md:text-lg">
                        Lycée de la cité des palmiers
                    </span>
                    <button @click="copyToClipboard('Lycée de la cité des palmiers')" class="ml-2 text-gray-400 hover:text-yellow-500 focus:outline-none transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                            <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                        </svg>
                    </button>
                    <span v-if="copiedText === 'Lycée de la cité des palmiers'" class="absolute top-full left-0 mt-1 text-xs text-green-600 transition-opacity duration-1000" :class="{ 'opacity-0': hideTooltip }">
                        Copié !
                    </span>
                </div>
            </div>
            
            <div class="contact-item flex items-start group">
                <svg class="flex-shrink-0 w-6 h-6 fill-current text-yellow-500 mr-3 mt-1 transition-all duration-300 group-hover:text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                   <path d="M12 12.713l-11.985-9.713h23.971l-11.986 9.713zm-5.425-1.822l-6.575-5.329v12.501l6.575-7.172zm10.85 0l6.575 7.172v-12.501l-6.575 5.329zm-1.557 1.261l-3.868 3.135-3.868-3.135-8.11 8.848h23.956l-8.11-8.848z" />
                </svg>
                <div class="relative flex-grow">
                    <a href="mailto:contact@findtofound.com" class="font-sans text-sm md:text-lg hover:text-yellow-500 transition-colors duration-300">
                        contact@findtofound.com
                    </a>
                    <button @click="copyToClipboard('contact@findtofound.com')" class="ml-2 text-gray-400 hover:text-yellow-500 focus:outline-none transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                            <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                        </svg>
                    </button>
                    <span v-if="copiedText === 'contact@findtofound.com'" class="absolute top-full left-0 mt-1 text-xs text-green-600 transition-opacity duration-1000" :class="{ 'opacity-0': hideTooltip }">
                        Copié !
                    </span>
                </div>
            </div>
            
            <div class="contact-item flex items-start group">
                <svg class="flex-shrink-0 w-6 h-6 fill-current text-yellow-500 mr-3 mt-1 transition-all duration-300 group-hover:text-yellow-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M20 22.621l-3.521-6.795c-.008.004-1.974.97-2.064 1.011-2.24 1.086-6.799-7.82-4.609-8.994l2.083-1.026-3.493-6.817-2.106 1.039c-7.202 3.755 4.233 25.982 11.6 22.615.121-.055 2.102-1.029 2.11-1.033z" />
                </svg>
                <div class="relative flex-grow">
                    <a href="tel:+237675068045" class="font-sans text-sm md:text-lg hover:text-yellow-500 transition-colors duration-300">
                        +237 675068045
                    </a>
                    <button @click="copyToClipboard('+237675068045')" class="ml-2 text-gray-400 hover:text-yellow-500 focus:outline-none transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                            <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                        </svg>
                    </button>
                    <span v-if="copiedText === '+237675068045'" class="absolute top-full left-0 mt-1 text-xs text-green-600 transition-opacity duration-1000" :class="{ 'opacity-0': hideTooltip }">
                        Copié !
                    </span>
                </div>
            </div>
        </div>
        
        <div class="mt-8 p-4 bg-yellow-50 rounded-lg border border-yellow-100 shadow-sm">
            <p class="font-sans text-sm md:text-lg">
                Notre équipe est à votre écoute pour tous vos questions et préoccupations concernant les objets perdus et trouvés.
            </p>
            <div class="flex items-center mt-4">
                <span class="inline-flex bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-semibold">
                    Horaires d'ouverture: Lun-Ven, 8h-18h
                </span>
            </div>
        </div>

        <!-- Widget de carte - À activer si nécessaire -->
        <div class="mt-6 hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Notre emplacement</h3>
            <div class="h-48 bg-gray-200 rounded-lg border border-gray-300">
                <!-- Intégration de carte à implémenter ici -->
                <div class="flex items-center justify-center h-full text-gray-500">
                    <span>Carte interactive</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// État pour suivre le texte qui a été copié
const copiedText = ref('');
const hideTooltip = ref(false);

// Fonction pour copier du texte dans le presse-papiers
const copyToClipboard = (text) => {
    // Utiliser l'API Clipboard pour copier le texte
    navigator.clipboard.writeText(text)
        .then(() => {
            // Mettre à jour l'état pour afficher la notification
            copiedText.value = text;
            hideTooltip.value = false;
            
            // Masquer la notification après un délai
            setTimeout(() => {
                hideTooltip.value = true;
                
                // Réinitialiser après la transition d'opacité
                setTimeout(() => {
                    copiedText.value = '';
                    hideTooltip.value = false;
                }, 1000);
            }, 2000);
        })
        .catch(err => {
            console.error('Erreur lors de la copie : ', err);
        });
};
</script>

<style scoped>
.contact-item {
    position: relative;
    transition: transform 0.2s ease;
}

.contact-item:hover {
    transform: translateX(5px);
}

/* Animation de rebond pour les boutons de copie */
button:active svg {
    transform: scale(0.9);
}
</style>
