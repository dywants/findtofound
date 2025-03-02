<template>
    <Layout>

        <Head title="Introduction à l'enregistrement d'objet trouvé" />
        <HeaderPage title="Enregistrer un objet trouvé" />

        <!-- Nouvelle structure avec sections horizontales -->
        <div class="container mx-auto py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
            <!-- Section d'en-tête avec gradient amélioré -->
            <section class="mb-16 text-center">
                <div
                    class="bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 p-8 sm:p-12 rounded-xl shadow-lg transform transition-all">
                    <h1 class="heading-xl text-4xl text-white mb-6 tracking-tight">Enregistrement d'un objet trouvé</h1>
                    <div class="max-w-3xl mx-auto bg-white/10 p-5 sm:p-6 rounded-lg border border-white/20">
                        <p class="paragraph-lg text-white font-medium mb-3">
                            Merci pour votre honnêteté et votre démarche citoyenne !
                        </p>
                        <p class="paragraph-base text-white/90 leading-relaxed">
                            Notre processus simple vous permettra d'enregistrer l'objet que vous avez trouvé
                            et d'aider son propriétaire à le retrouver.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Section des étapes du processus avec illustrations -->
            <section class="mb-20">
                <h2 class="heading-2 text-center text-gray-800 mb-12">Le processus en trois étapes simples</h2>

                <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                    <!-- Étape 1 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transform transition hover:shadow-lg hover:-translate-y-1">
                        <div class="p-6 space-y-4">
                            <div class="flex justify-center mb-4">
                                <div class="w-20 h-20 rounded-full bg-primary-50 flex items-center justify-center">
                                    <Icon name="document" size="32" class="text-primary-600" />
                                </div>
                            </div>
                            <h3 class="heading-3 text-gray-800 text-center">Informations sur l'objet trouvé</h3>
                            <p class="paragraph-base text-gray-600 text-center">
                                Décrivez l'objet que vous avez trouvé et téléchargez des photos pour faciliter son
                                identification.
                            </p>
                            <div
                                class="pt-2 text-sm text-gray-600 border-l-3 border-primary-200 bg-primary-50 pl-4 py-3 rounded-r-md">
                                <Icon name="check" size="16" class="inline-block mr-1 text-primary-600" />
                                Pour faciliter l'identification, prenez des photos claires sous différents angles.
                            </div>
                        </div>
                    </div>

                    <!-- Étape 2 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transform transition hover:shadow-lg hover:-translate-y-1">
                        <div class="p-6 space-y-4">
                            <div class="flex justify-center mb-4">
                                <div class="w-20 h-20 rounded-full bg-primary-50 flex items-center justify-center">
                                    <Icon name="user" size="32" class="text-primary-600" />
                                </div>
                            </div>
                            <h3 class="heading-3 text-gray-800 text-center">Vos informations personnelles</h3>
                            <p class="paragraph-base text-gray-600 text-center">
                                Selon votre choix ci-dessous, nous recueillerons vos informations de contact pour le
                                suivi du processus.
                            </p>
                            <div
                                class="pt-2 text-sm text-gray-600 border-l-3 border-primary-200 bg-primary-50 pl-4 py-3 rounded-r-md">
                                <Icon name="check" size="16" class="inline-block mr-1 text-primary-600" />
                                Vos informations personnelles ne seront jamais partagées publiquement.
                            </div>
                        </div>
                    </div>

                    <!-- Étape 3 -->
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transform transition hover:shadow-lg hover:-translate-y-1">
                        <div class="p-6 space-y-4">
                            <div class="flex justify-center mb-4">
                                <div class="w-20 h-20 rounded-full bg-primary-50 flex items-center justify-center">
                                    <Icon name="check" size="32" class="text-primary-600" />
                                </div>
                            </div>
                            <h3 class="heading-3 text-gray-800 text-center">Validation et confirmation</h3>
                            <p class="paragraph-base text-gray-600 text-center">
                                Vérifiez l'exactitude des informations avant de finaliser l'enregistrement de l'objet
                                trouvé.
                            </p>
                            <div
                                class="pt-2 text-sm text-gray-600 border-l-3 border-primary-200 bg-primary-50 pl-4 py-3 rounded-r-md">
                                <Icon name="check" size="16" class="inline-block mr-1 text-primary-600" />
                                Vous pourrez modifier ces informations jusqu'à la validation finale.
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section des parcours utilisateur avec diagramme de flux visuel -->
            <section class="mb-16">
                <h2 class="heading-2 text-center text-gray-800 mb-8">Deux parcours possibles selon votre choix</h2>

                <!-- Diagramme de flux visuel -->
                <div class="relative mb-12 py-6">
                    <!-- Ligne de connexion centrale -->
                    <div class="absolute w-0.5 bg-gray-200 h-full left-1/2 transform -translate-x-1/2 top-0 z-0"></div>

                    <!-- Étape commune (Étape 1) -->
                    <div class="relative z-10 flex justify-center mb-8">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-100 border-4 border-primary-500 flex items-center justify-center shadow-md">
                            <span class="text-lg font-bold text-primary-600">1</span>
                        </div>
                    </div>

                    <!-- Point de divergence -->
                    <div class="relative z-10 flex justify-center items-center mb-6">
                        <div
                            class="w-28 h-28 rounded-full bg-gray-50 border-2 border-dashed border-gray-300 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-gray-500 font-medium">Votre choix</div>
                                <Icon name="chevron-down" size="20" class="mx-auto mt-1 text-gray-400" />
                            </div>
                        </div>
                    </div>

                    <!-- Les deux chemins divergents -->
                    <div class="grid md:grid-cols-2 gap-8 relative z-10">
                        <!-- Chemin avec récompense (gauche) -->
                        <div class="flex flex-col items-center">
                            <!-- Ligne de connexion spécifique à ce parcours -->
                            <div
                                class="absolute h-full w-0.5 bg-blue-200 left-1/4 transform -translate-x-1/2 top-1/4 z-0">
                            </div>

                            <!-- Étiquette de parcours -->
                            <div class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-medium mb-6">
                                Avec récompense
                            </div>

                            <!-- Étape 2: Création de compte -->
                            <div class="w-full mb-6">
                                <div class="bg-blue-50 rounded-lg border border-blue-200 p-4 flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 border-2 border-blue-500 flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-sm font-bold text-blue-600">2</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-blue-800">Création de compte</h4>
                                        <p class="text-sm text-blue-700 mt-1">Créez un compte ou connectez-vous pour
                                            pouvoir recevoir votre récompense.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Étape 3: Informations personnelles -->
                            <div class="w-full mb-6">
                                <div class="bg-blue-50 rounded-lg border border-blue-200 p-4 flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 border-2 border-blue-500 flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-sm font-bold text-blue-600">3</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-blue-800">Informations personnelles</h4>
                                        <p class="text-sm text-blue-700 mt-1">Vos coordonnées permettront au
                                            propriétaire de vous contacter pour la récompense.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Étape 4: Validation et suivi -->
                            <div class="w-full">
                                <div class="bg-blue-50 rounded-lg border border-blue-200 p-4 flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 border-2 border-blue-500 flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-sm font-bold text-blue-600">4</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-blue-800">Validation et suivi</h4>
                                        <p class="text-sm text-blue-700 mt-1">Suivez l'avancement de votre déclaration
                                            et recevez des notifications.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chemin sans récompense (droite) -->
                        <div class="flex flex-col items-center">
                            <!-- Ligne de connexion spécifique à ce parcours -->
                            <div
                                class="absolute h-full w-0.5 bg-green-200 left-3/4 transform -translate-x-1/2 top-1/4 z-0">
                            </div>

                            <!-- Étiquette de parcours -->
                            <div class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-medium mb-6">
                                Sans récompense
                            </div>

                            <!-- Étape 2: Renseignement de l'emplacement -->
                            <div class="w-full mb-6">
                                <div class="bg-green-50 rounded-lg border border-green-200 p-4 flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 border-2 border-green-500 flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-sm font-bold text-green-600">2</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-green-800">Lieu de dépôt</h4>
                                        <p class="text-sm text-green-700 mt-1">Indiquez où vous avez déposé l'objet
                                            trouvé (commissariat, mairie, etc.).</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Étape 3: Formulaire anonyme -->
                            <div class="w-full mb-6">
                                <div class="bg-green-50 rounded-lg border border-green-200 p-4 flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 border-2 border-green-500 flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-sm font-bold text-green-600">3</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-green-800">Formulaire simplifié</h4>
                                        <p class="text-sm text-green-700 mt-1">Remplissez le formulaire anonyme sans
                                            créer de compte utilisateur.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Étape 4: Confirmation -->
                            <div class="w-full">
                                <div class="bg-green-50 rounded-lg border border-green-200 p-4 flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 border-2 border-green-500 flex items-center justify-center mr-3 flex-shrink-0">
                                        <span class="text-sm font-bold text-green-600">4</span>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-green-800">Confirmation finale</h4>
                                        <p class="text-sm text-green-700 mt-1">Recevez une confirmation que votre action
                                            a bien été enregistrée.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Options de choix -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl shadow-sm p-8 sm:p-10 mt-8">
                    <h3 class="heading-3 text-gray-800 mb-8 text-center">Faites votre choix maintenant</h3>

                    <div class="grid md:grid-cols-2 gap-6 lg:gap-10">
                        <!-- Option avec récompense -->
                        <OptionCard inputId="with-reward" radioGroupName="registration-option" :isSelected="wantReward"
                            title="Je souhaite recevoir une récompense"
                            description="Vous devrez créer un compte pour suivre le processus et recevoir une éventuelle récompense de la part du propriétaire."
                            :features="[
                                'Création d\'un compte personnel',
                                'Suivi complet du processus',
                                'Possibilité de recevoir une récompense',
                                'Notification en cas de réclamation'
                            ]" :optionValue="true" @update:modelValue="wantReward = $event" />

                        <!-- Option sans récompense -->
                        <OptionCard inputId="without-reward" radioGroupName="registration-option"
                            :isSelected="!wantReward" title="Je ne souhaite pas de récompense"
                            description="Vous pouvez enregistrer l'objet de manière anonyme, sans créer de compte sur la plateforme."
                            :features="[
                                'Processus simplifié',
                                'Aucun compte nécessaire',
                                'Option totalement anonyme',
                                'Démarche purement altruiste'
                            ]" :optionValue="false" @update:modelValue="wantReward = $event" />
                    </div>
                </div>
            </section>

            <!-- Section des actions -->
            <section class="text-center mt-10">
                <div class="flex justify-center">
                    <!-- Bouton principal unique avec effet amélioré -->
                    <button type="button" @click="proceedToRegistration"
                        class="button primary ripple with-icon group px-8 sm:px-12 py-4 sm:py-5 rounded-lg shadow-md text-lg font-medium transition-all duration-300 hover:shadow-lg hover:scale-105">
                        <span class="relative z-10">{{ wantReward ? 'Continuer avec récompense' : 'Continuer sans récompense' }}</span>
                        <Icon name="chevron-right"
                            class="ml-2 h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" />
                    </button>
                </div>
            </section>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout";
import HeaderPage from "@/Layouts/HeaderPage";
import ProcessStep from "@/Components/ProcessStep.vue";
import OptionCard from "@/Components/OptionCard.vue";
import Icon from "@/Components/Icon.vue";

// État local pour la préférence de l'utilisateur
const wantReward = ref(true);
const isPageLoaded = ref(false);

// Vérifier si l'utilisateur est authentifié
const { auth } = usePage().props;

// Animer l'entrée des éléments au chargement
onMounted(() => {
    setTimeout(() => {
        isPageLoaded.value = true;
    }, 200);
});

// Fonction pour continuer vers la page d'enregistrement
function proceedToRegistration() {
    // Si l'utilisateur veut une récompense mais n'est pas connecté, le rediriger vers la page d'inscription
    if (wantReward.value && (!auth || !auth.user)) {
        router.visit(route('register.finder'), {
            data: {
                redirectUrl: route('find.register'),
                wantReward: wantReward.value
            },
            method: 'get',
            preserveState: true
        });
    } else {
        // Sinon, rediriger directement vers la page d'enregistrement
        router.visit(route('find.register'), {
            data: {
                wantReward: wantReward.value
            },
            method: 'get',
            preserveState: true
        });
    }
}

// Note: La fonction goToDocumentProtection a été supprimée car elle était identique à proceedToRegistration
</script>

<style scoped>
/* Animations pour la liste d'étapes */
.step-list-enter-active,
.step-list-leave-active {
    transition: all 0.4s ease;
}

.step-list-enter-from,
.step-list-leave-to {
    opacity: 0;
    transform: translateX(-20px);
}

.step-list-move {
    transition: transform 0.5s ease;
}

/* Animation de survol pour les boutons */
.button.with-icon svg {
    transition: all 0.3s ease;
}

.button.with-icon:hover svg {
    transform: translateX(4px);
}

/* Rotation pour l'icône chevron */
.transform.rotate-270 {
    transform: rotate(270deg);
}

/* Animation d'entrée pour les cartes */
.bg-white.rounded-xl {
    animation: fadeInUp 0.7s ease-out;
    animation-fill-mode: both;
}

.bg-white.rounded-xl:nth-child(1) {
    animation-delay: 0.1s;
}

.bg-white.rounded-xl:nth-child(2) {
    animation-delay: 0.3s;
}

.bg-white.rounded-xl:nth-child(3) {
    animation-delay: 0.5s;
}

/* Effet de fondu pour l'en-tête */
.heading-xl,
.heading-2,
.heading-3 {
    animation: fadeScale 0.7s ease-out;
}

@keyframes fadeScale {
    from {
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
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
</style>
