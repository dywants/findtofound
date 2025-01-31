<template>

    <Head>
        <title>DocuTrace - Protection et Recherche de Documents</title>
        <meta type="description" content="Protégez et retrouvez vos documents importants avec DocuTrace">
    </Head>
    <Layout>
        <div class="min-h-screen bg-gradient-to-b from-white to-blue-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="w-full md:w-1/2 space-y-6">
                        <div class="animate-fade-in-up">
                            <p class="text-blue-600 font-semibold text-lg">— Protection & Récupération</p>
                            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mt-4">
                                Sécurisez et retrouvez vos documents importants
                            </h1>
                        </div>
                        <div class="prose prose-lg text-gray-600 animate-fade-in-up delay-100">
                            <p class="text-lg">
                                <span class="font-bold">Docu<span class="text-blue-600">Trace</span></span> est votre
                                solution complète pour la gestion de documents. Protégez vos pièces avec des filigranes
                                sécurisés et retrouvez facilement vos documents égarés.
                            </p>
                            <p class="mt-4">
                                Double protection : Sécurisez vos documents sensibles avec des filigranes professionnels
                                et
                                bénéficiez de notre système de recherche efficace en cas de perte.
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 animate-fade-in-up delay-200">
                            <NavLink
                                class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                :href="route('find.register')">
                                <span>Signaler un document trouvé</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </NavLink>
                            <NavLink
                                class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-600 bg-white border-2 border-blue-600 rounded-lg hover:bg-blue-50 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                :href="route('found.search')">
                                <span>Protéger mes documents</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </NavLink>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 animate-fade-in-up delay-300">
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-blue-200 rounded-full filter blur-3xl opacity-20 transform rotate-12">
                            </div>
                            <img class="relative rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-300"
                                alt="hero" src="images/pieces.png">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Services -->
            <div class="py-24 bg-gradient-to-b from-blue-50 to-white">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-3xl mx-auto animate-fade-in-up">
                        <span class="text-blue-600 font-semibold text-lg">Nos Services</span>
                        <h2 class="mt-4 text-3xl sm:text-4xl font-bold text-gray-900">Protection et Récupération</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-2 lg:grid-cols-3">
                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            <img src="/images/services/protection.svg" alt="Protection de documents"
                                class="w-16 h-16 mx-auto mb-4">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Protection de Documents</h3>
                            <p class="text-gray-600">Sécurisez vos documents importants avec notre système de filigrane
                                personnalisé.</p>
                        </div>

                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            <img src="/images/services/search.svg" alt="Recherche efficace"
                                class="w-16 h-16 mx-auto mb-4">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Recherche Efficace</h3>
                            <p class="text-gray-600">Retrouvez rapidement vos documents perdus grâce à notre système de
                                recherche avancé.</p>
                        </div>

                        <div class="p-6 bg-white rounded-lg shadow-lg">
                            <img src="/images/services/connect.svg" alt="Mise en relation"
                                class="w-16 h-16 mx-auto mb-4">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Mise en Relation Sécurisée</h3>
                            <p class="text-gray-600">Connectez-vous en toute sécurité avec les personnes qui ont trouvé
                                vos
                                documents.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Statistiques -->
            <div class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                        <div class="p-6">
                            <div class="text-4xl font-bold text-blue-600">{{ stats.finds }}+</div>
                            <div class="mt-2 text-gray-600">Documents trouvés</div>
                        </div>
                        <div class="p-6">
                            <div class="text-4xl font-bold text-blue-600">{{ stats.success }}%</div>
                            <div class="mt-2 text-gray-600">Taux de succès</div>
                        </div>
                        <div class="p-6">
                            <div class="text-4xl font-bold text-blue-600">{{ stats.users }}+</div>
                            <div class="mt-2 text-gray-600">Utilisateurs actifs</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Témoignages -->
            <div class="py-24 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900">Ce que disent nos utilisateurs</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div v-for="testimonial in testimonials" :key="testimonial.id"
                            class="bg-white p-6 rounded-lg shadow-lg">
                            <div class="flex items-center mb-4">
                                <div :class="testimonial.bgColor"
                                    class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ testimonial.initials }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-semibold">{{ testimonial.name }}</div>
                                    <div class="text-sm text-gray-600">{{ testimonial.role }}</div>
                                </div>
                            </div>
                            <p class="text-gray-600">{{ testimonial.content }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section FAQ -->
            <div class="py-24 bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold text-gray-900">Questions fréquentes</h2>
                    </div>
                    <div class="max-w-3xl mx-auto">
                        <div v-for="faq in faqs" :key="faq.id" class="mb-8">
                            <button @click="faq.isOpen = !faq.isOpen"
                                class="flex justify-between items-center w-full text-left p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                <span class="text-lg font-semibold">{{ faq.question }}</span>
                                <svg class="w-6 h-6 transition-transform duration-200"
                                    :class="{ 'transform rotate-180': faq.isOpen }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div v-show="faq.isOpen" class="mt-4 text-gray-600 p-4 bg-white rounded-lg shadow-inner">
                                {{ faq.answer }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import NavLink from "@/Components/NavLink";
import Layout from "@/Layouts/Layout";
import axios from 'axios';

const stats = ref({
    finds: 0,
    success: 0,
    users: 0
});

const testimonials = ref([
    {
        id: 1,
        name: "Marie L.",
        role: "Utilisatrice",
        initials: "ML",
        bgColor: "bg-blue-500",
        content: "J'ai retrouvé ma carte d'identité grâce à DocuTrace. Le service est rapide et efficace !"
    },
    {
        id: 2,
        name: "Thomas M.",
        role: "Finder",
        initials: "TM",
        bgColor: "bg-green-500",
        content: "Une excellente plateforme qui permet d'aider les autres tout en étant récompensé."
    },
    {
        id: 3,
        name: "Sophie K.",
        role: "Utilisatrice",
        initials: "SK",
        bgColor: "bg-purple-500",
        content: "J'ai perdu mon passeport et grâce à DocuTrace, je l'ai récupéré en moins de 24h !"
    }
]);

const faqs = ref([
    {
        id: 1,
        question: "Comment fonctionne la récompense ?",
        answer: "La récompense est fixée à 10% de la valeur de la pièce trouvée. Elle est versée automatiquement au finder une fois que le propriétaire confirme avoir récupéré sa pièce.",
        isOpen: false
    },
    {
        id: 2,
        question: "Comment être sûr de la fiabilité des finders ?",
        answer: "Tous nos finders sont vérifiés et notés par la communauté. Vous pouvez consulter leurs évaluations et commentaires avant d'entrer en contact.",
        isOpen: false
    },
    {
        id: 3,
        question: "Combien de temps pour récupérer ma pièce ?",
        answer: "Le délai dépend de plusieurs facteurs, mais généralement, si votre pièce a été trouvée, vous pouvez la récupérer dans les 24 à 48 heures suivant sa déclaration sur notre plateforme.",
        isOpen: false
    }
]);

onMounted(async () => {
    try {
        const response = await axios.get('/api/stats');
        stats.value = response.data;
    } catch (error) {
        console.error('Erreur lors du chargement des statistiques:', error);
    }
});
</script>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
    opacity: 0;
}

.delay-100 {
    animation-delay: 0.1s;
}

.delay-200 {
    animation-delay: 0.2s;
}

.delay-300 {
    animation-delay: 0.3s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.slide-fade-enter-active {
    transition: all 0.3s ease;
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(20px);
    opacity: 0;
}

.bounce-enter-active {
    animation: bounce-in 0.5s;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }
}
</style>
