<template>
    <Head>
        <title>DocuTrace - Protection de Documents</title>
        <meta type="description" content="Protégez vos documents importants avec DocuTrace - Ajoutez des filigranes et protégez vos fichiers importants">
        <meta name="language" content="fr">
        <meta property="og:locale" content="fr_FR">
    </Head>

    <div class="min-h-screen bg-gradient-to-b from-white to-blue-50">
        <!-- En-tête avec illustration et message d'accroche -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white">
            <div class="max-w-7xl mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight md:text-5xl">
                            Protégez vos documents importants
                        </h1>
                        <p class="mt-4 sm:mt-6 text-lg sm:text-xl">
                            DocuTrace vous permet d'ajouter facilement des filigranes à vos documents et images pour prévenir l'utilisation non autorisée.
                        </p>
                        <div class="mt-6 sm:mt-8">
                            <Link :href="route('documents.protect')" class="inline-flex items-center px-5 sm:px-6 py-2 sm:py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transform transition duration-300 hover:scale-105" aria-label="Accéder à la page de protection de documents">
                                Protéger mes documents
                                <Icon name="chevron-right" class="ml-2" aria-hidden="true" />
                            </Link>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-full h-64 fade-in" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Illustration du document protégé -->
                            <rect x="100" y="50" width="200" height="250" rx="8" fill="white" />
                            <rect x="120" y="80" width="160" height="10" rx="2" fill="#E5E7EB" />
                            <rect x="120" y="100" width="160" height="10" rx="2" fill="#E5E7EB" />
                            <rect x="120" y="120" width="160" height="10" rx="2" fill="#E5E7EB" />
                            <rect x="120" y="140" width="100" height="10" rx="2" fill="#E5E7EB" />
                            <!-- Filigrane -->
                            <text transform="translate(200 180) rotate(-30)" class="text-5xl" fill="rgba(37, 99, 235, 0.2)" text-anchor="middle" dominant-baseline="middle" font-weight="bold">PROTÉGÉ</text>
                            <!-- Icône de sécurité -->
                            <circle cx="200" cy="240" r="20" fill="#3B82F6" />
                            <path d="M195 240L198 243L205 236" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section expliquant le concept -->
        <div ref="howItWorksSection" class="py-8 sm:py-12 bg-white opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 id="how-it-works" class="text-2xl sm:text-3xl font-extrabold text-gray-900 md:text-4xl">
                        Comment ça fonctionne
                    </h2>
                    <p class="mt-3 sm:mt-4 text-base sm:text-lg text-gray-500">
                        Un processus simple en trois étapes pour sécuriser vos documents.
                    </p>
                </div>

                <div class="mt-8 sm:mt-12">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <div class="flex flex-col items-center text-center transform transition duration-300 hover:scale-105">
                            <div class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 rounded-full bg-blue-100 text-blue-600 mb-3 sm:mb-4 icon-container" aria-hidden="true">
                                <Icon name="document" size="28" class="icon" aria-hidden="true" />
                            </div>
                            <h3 class="text-lg sm:text-xl font-medium text-gray-900">1. Téléversez votre document</h3>
                            <p class="mt-2 text-sm sm:text-base text-gray-500">
                                Importez vos images ou PDF que vous souhaitez protéger (jusqu'à 10MB).
                            </p>
                        </div>

                        <div class="flex flex-col items-center text-center transform transition duration-300 hover:scale-105">
                            <div class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 rounded-full bg-blue-100 text-blue-600 mb-3 sm:mb-4 icon-container" aria-hidden="true">
                                <Icon name="text" size="28" solid class="icon" aria-hidden="true" />
                            </div>
                            <h3 class="text-lg sm:text-xl font-medium text-gray-900">2. Ajoutez votre filigrane</h3>
                            <p class="mt-2 text-sm sm:text-base text-gray-500">
                                Définissez le texte qui sera visible en filigrane sur votre document.
                            </p>
                        </div>

                        <div class="flex flex-col items-center text-center transform transition duration-300 hover:scale-105">
                            <div class="flex items-center justify-center h-14 w-14 sm:h-16 sm:w-16 rounded-full bg-blue-100 text-blue-600 mb-3 sm:mb-4 icon-container" aria-hidden="true">
                                <Icon name="download" size="28" class="icon" aria-hidden="true" />
                            </div>
                            <h3 class="text-lg sm:text-xl font-medium text-gray-900">3. Téléchargez votre document protégé</h3>
                            <p class="mt-2 text-sm sm:text-base text-gray-500">
                                Récupérez votre document avec filigrane prêt à être partagé en toute sécurité.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section des avantages -->
        <div ref="benefitsSection" class="py-12 bg-gray-50 opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                        Pourquoi utiliser DocuTrace ?
                    </h2>
                </div>

                <div class="mt-12">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                        <div class="bg-white p-6 rounded-lg shadow-sm transform transition duration-300 hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                                <Icon name="shield" solid />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Protection</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Protégez vos documents contre l'utilisation non autorisée et prévenez le vol de propriété intellectuelle.
                            </p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm transform transition duration-300 hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                                <Icon name="fast" solid />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Rapidité</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Ajoutez des filigranes en quelques secondes, sans logiciel complexe à installer.
                            </p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm transform transition duration-300 hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                                <Icon name="device-mobile" solid />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Accessibilité</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Utilisez le service sur n'importe quel appareil, à tout moment et n'importe où.
                            </p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm transform transition duration-300 hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                                <Icon name="storage" solid />
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Archivage</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Gardez tous vos documents protégés organisés et accessibles dans votre espace personnel.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section d'exemple visuel -->
        <div ref="exampleSection" class="py-12 bg-gray-100 opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Voyez la différence</h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        Comment les documents protégés se distinguent des originaux
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="p-4 bg-gray-100 border-b">
                            <h3 class="text-lg font-medium text-gray-900">Document original</h3>
                        </div>
                        <div class="p-6 text-center">
                            <!-- Exemple d'image original -->
                            <div class="bg-gray-200 rounded-lg p-8 mb-4" style="min-height: 200px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-gray-500">Document sans protection</p>
                            </div>
                            <p class="text-red-500">Risque de copie non autorisée</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="p-4 bg-blue-100 border-b">
                            <h3 class="text-lg font-medium text-blue-900">Document protégé</h3>
                        </div>
                        <div class="p-6 text-center">
                            <!-- Exemple d'image protégée -->
                            <div class="bg-gray-200 rounded-lg p-8 mb-4 relative" style="min-height: 200px;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <!-- Filigrane -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-40">
                                    <p class="text-blue-700 font-bold text-xl transform -rotate-45">PROTÉGÉ - DocuTrace</p>
                                </div>
                                <p class="mt-2 text-gray-500">Document avec filigrane</p>
                            </div>
                            <p class="text-green-500 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Protection contre la copie non autorisée
                            </p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-12">
                    <Link :href="route('documents.protect')"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:scale-105">
                        <Icon name="shield" class="h-5 w-5 mr-2" />
                        Commencer la protection maintenant
                    </Link>
                </div>
            </div>
        </div>

        <!-- Section des formats supportés -->
        <div ref="formatsSection" class="py-12 bg-white opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-2xl font-extrabold text-gray-900">Formats supportés</h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                        DocuTrace prend actuellement en charge les formats suivants :
                    </p>
                </div>

                <div class="mt-10">
                    <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                        <div class="flex transition duration-300 hover:text-blue-600">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <Icon name="document-pdf" solid />
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">PDF</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Documents au format PDF jusqu'à 10MB.
                                </p>
                            </div>
                        </div>

                        <div class="flex transition duration-300 hover:text-blue-600">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <Icon name="photograph" solid />
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">JPG / JPEG</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Images au format JPG/JPEG jusqu'à 10MB.
                                </p>
                            </div>
                        </div>

                        <div class="flex transition duration-300 hover:text-blue-600">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                    <Icon name="photograph" solid />
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">PNG</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Images au format PNG jusqu'à 10MB.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div ref="faqSection" class="py-12 bg-gray-50 opacity-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Questions fréquentes</h2>
                    <p class="mt-4 text-lg text-gray-500">
                        Vous avez des questions sur la protection de documents ? Consultez notre FAQ.
                    </p>
                </div>

                <div class="mt-12 space-y-6 divide-y divide-gray-200">
                    <div class="grid gap-6 md:grid-cols-1">
                    <div class="pt-6 transition duration-300 hover:bg-white hover:shadow-sm hover:rounded-lg hover:p-4">
                        <div class="text-lg">
                            <h3 class="font-medium text-gray-900">Mes documents sont-ils stockés de manière sécurisée ?</h3>
                        </div>
                        <div class="mt-2 text-base text-gray-500">
                            <p>Oui, tous vos documents sont stockés de manière sécurisée. Seul vous pouvez y accéder depuis votre compte. Nous utilisons le chiffrement pour protéger vos données.</p>
                        </div>
                    </div>

                    <div class="pt-6 transition duration-300 hover:bg-white hover:shadow-sm hover:rounded-lg hover:p-4">
                        <div class="text-lg">
                            <h3 class="font-medium text-gray-900">Puis-je modifier ou supprimer un filigrane après l'avoir appliqué ?</h3>
                        </div>
                        <div class="mt-2 text-base text-gray-500">
                            <p>Non, une fois le filigrane appliqué, il ne peut pas être modifié. Vous devrez téléverser à nouveau votre document et créer un nouveau filigrane si nécessaire.</p>
                        </div>
                    </div>

                    <div class="pt-6 transition duration-300 hover:bg-white hover:shadow-sm hover:rounded-lg hover:p-4">
                        <div class="text-lg">
                            <h3 class="font-medium text-gray-900">Y a-t-il une limite au nombre de documents que je peux protéger ?</h3>
                        </div>
                        <div class="mt-2 text-base text-gray-500">
                            <p>Non, il n'y a pas de limite au nombre de documents que vous pouvez protéger. Vous pouvez utiliser le service autant que nécessaire.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appel à l'action -->
        <div class="bg-blue-700">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">Prêt à protéger vos documents ?</span>
                    <span class="block text-blue-200">Commencez dès maintenant, c'est simple et rapide.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <Link :href="route('documents.protect')" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 transform transition duration-300 hover:scale-105">
                            Protéger mes documents
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Icon from '@/Components/Icon.vue';
import { onMounted, ref } from 'vue';

// Référence aux sections pour l'animation au défilement
const howItWorksSection = ref(null);
const benefitsSection = ref(null);
const exampleSection = ref(null);
const formatsSection = ref(null);
const faqSection = ref(null);

// Fonction pour initialiser l'observation des sections
onMounted(() => {
    const sections = [
        howItWorksSection.value,
        benefitsSection.value,
        exampleSection.value,
        formatsSection.value,
        faqSection.value
    ];

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('slide-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    sections.forEach(section => {
        if (section) {
            observer.observe(section);
        }
    });
});
</script>

<style scoped>
/* Animation pour l'illustration */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fade-in {
    animation: fadeIn 1s ease-in-out;
}

/* Animation pour les icônes */
.icon-container:hover .icon {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

/* Animation pour les sections */
@keyframes slideInFromBottom {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.slide-in {
    opacity: 1 !important;
    animation: slideInFromBottom 0.7s ease-out forwards;
}

/* Transition pour les éléments au survol */
.hover-grow {
    transition: all 0.3s ease;
}

.hover-grow:hover {
    transform: scale(1.03);
}

/* Animation de fade-in pour les éléments */
[ref="howItWorksSection"],
[ref="benefitsSection"],
[ref="formatsSection"],
[ref="faqSection"] {
    transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    will-change: opacity, transform;
}
</style>
