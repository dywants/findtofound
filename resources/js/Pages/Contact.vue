<template>
    <Layout>
        <Head title="Contacter-nous"/>
        
        <div class="bg-gray-50 py-12 overflow-hidden" role="main">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section d'introduction avec décoration -->
                <div class="text-center mb-12 relative">
                    <!-- Éléments décoratifs de fond -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-full h-64 -z-10 overflow-hidden opacity-10">
                        <div class="absolute w-40 h-40 bg-yellow-300 rounded-full -top-20 left-1/4 animate-float-slow"></div>
                        <div class="absolute w-32 h-32 bg-yellow-200 rounded-full -bottom-10 right-1/4 animate-float"></div>
                        <div class="absolute w-24 h-24 bg-yellow-400 rounded-full top-20 left-3/4 animate-float-fast"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6" id="contact-title">Comment pouvons-nous vous aider ?</h1>
                        <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Notre équipe est à votre écoute pour répondre à toutes vos questions concernant les objets perdus et trouvés.</p>
                    </div>
                </div>
                
                <!-- Section principale -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mx-auto max-w-6xl transform transition-all duration-500 hover:shadow-xl">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Informations de contact -->
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 md:p-10 lg:w-2/5 relative overflow-hidden">
                            <ContactInfo />
                        </div>
                        
                        <!-- Formulaire de contact -->
                        <div class="p-8 md:p-10 lg:w-3/5 relative overflow-hidden">
                            <!-- Élément décoratif d'arrière-plan -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-yellow-100 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
                            <div class="relative z-10">
                                <ContactForm />
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Section FAQ interactive -->
                <div class="mt-20 max-w-6xl mx-auto">
                    <h2 class="text-2xl font-bold text-center text-gray-900 mb-10 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Questions fréquentes
                    </h2>
                    
                    <!-- Accordion FAQ -->
                    <div class="space-y-4 max-w-4xl mx-auto">
                        <div v-for="(item, index) in faqItems" :key="index" class="bg-white rounded-lg shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                            <button 
                                class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2"
                                @click="toggleFaq(index)"
                                :aria-expanded="openFaqIndex === index"
                                :aria-controls="`faq-content-${index}`"
                            >
                                <h3 class="font-semibold text-lg text-gray-800 flex items-center">
                                    <span class="text-yellow-600 mr-2 font-bold">Q:</span>
                                    {{ item.question }}
                                </h3>
                                <svg 
                                    class="w-5 h-5 text-yellow-500 transform transition-transform duration-300"
                                    :class="{'rotate-180': openFaqIndex === index}"
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24" 
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div 
                                :id="`faq-content-${index}`"
                                class="px-6 overflow-hidden transition-all duration-300 ease-in-out"
                                :class="{'max-h-0 py-0': openFaqIndex !== index, 'max-h-96 py-4': openFaqIndex === index}"
                                role="region"
                                :aria-labelledby="`faq-question-${index}`"
                            >
                                <p class="text-gray-600">
                                    <span class="text-yellow-500 font-bold">R:</span>
                                    {{ item.answer }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bouton pour poser une autre question -->
                    <div class="mt-8 text-center">
                        <a 
                            href="#contact-form-title" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-300"
                            aria-label="Poser une autre question via notre formulaire de contact"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Poser une autre question
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
// Imports
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Layout from "@/Layouts/Layout";
import ContactInfo from "@/Components/ContactInfo";
import ContactForm from "@/Components/ContactForm";

// État pour le contrôle de l'accordéon FAQ
const openFaqIndex = ref(null);

// Fonction pour basculer l'état d'ouverture/fermeture des questions
const toggleFaq = (index) => {
    openFaqIndex.value = openFaqIndex.value === index ? null : index;
};

// Données des questions fréquentes
const faqItems = [
    {
        question: "Comment signaler un objet trouvé ?",
        answer: "Pour signaler un objet que vous avez trouvé, connectez-vous à votre compte et cliquez sur 'Déclarer un objet trouvé'. Remplissez le formulaire avec autant de détails que possible, y compris des photos si disponibles. Une fois soumis, votre signalement sera visible pour les personnes recherchant des objets perdus."
    },
    {
        question: "Comment rechercher un objet perdu ?",
        answer: "Utilisez notre fonction de recherche avancée pour trouver des objets correspondant à votre description. Vous pouvez filtrer par catégorie, date, lieu et caractéristiques spécifiques. Parcourez les résultats et si vous trouvez votre objet, contactez-nous via le formulaire de réclamation associé à l'annonce."
    },
    {
        question: "Quand puis-je espérer récupérer mon objet ?",
        answer: "Une fois que vous avez identifié votre objet dans notre base de données, contactez-nous directement. Nous vérifierons votre identité et propriété, puis organiserons la récupération dans un délai généralement inférieur à 48 heures. Des pièces justificatives peuvent être nécessaires pour prouver que l'objet vous appartient."
    },
    {
        question: "Combien de temps gardez-vous les objets trouvés ?",
        answer: "Nous conservons les objets trouvés pendant une période de 6 mois conformément à la législation locale. Au-delà de cette période, les objets non réclamés peuvent être donnés à des œuvres caritatives ou recyclés selon leur nature."
    },
    {
        question: "Y a-t-il des frais pour utiliser vos services ?",
        answer: "L'inscription et la recherche d'objets perdus sont entièrement gratuites. Nous ne facturons aucun frais pour le signalement d'objets trouvés. Dans certains cas, des frais administratifs minimes peuvent s'appliquer lors de la récupération d'objets de grande valeur, pour couvrir les coûts de vérification et de stockage sécurisé."
    }
];
</script>

<style scoped>
/* Animations pour les éléments décoratifs */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}

@keyframes floatSlow {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

@keyframes floatFast {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-30px); }
    100% { transform: translateY(0px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-slow {
    animation: floatSlow 8s ease-in-out infinite;
}

.animate-float-fast {
    animation: floatFast 4s ease-in-out infinite;
}

/* Styles pour les éléments FAQ */
.max-h-0 {
    max-height: 0;
}

.max-h-96 {
    max-height: 24rem;
}
</style>
