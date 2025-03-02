<template>
    <Layout>
        <Head title="Contacter-nous"/>
        
        <div class="bg-gray-50 py-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section d'introduction -->
                <div class="text-center mb-12">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Comment pouvons-nous vous aider ?</h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Notre équipe est à votre écoute pour répondre à toutes vos questions concernant les objets perdus et trouvés.</p>
                </div>
                
                <!-- Section principale -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden mx-auto max-w-6xl">
                    <div class="flex flex-col lg:flex-row">
                        <!-- Informations de contact -->
                        <div class="bg-yellow-50 p-8 md:p-10 lg:w-2/5">
                            <ContactInfo />
                        </div>
                        
                        <!-- Formulaire de contact -->
                        <div class="p-8 md:p-10 lg:w-3/5">
                            <ContactForm />
                        </div>
                    </div>
                </div>
                
                <!-- Section FAQ -->
                <div class="mt-16 max-w-6xl mx-auto">
                    <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Questions fréquentes</h2>
                    
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                            <h3 class="font-semibold text-lg mb-2 text-yellow-600">Comment signaler un objet trouvé ?</h3>
                            <p class="text-gray-600">Utilisez notre formulaire en ligne pour enregistrer les détails de l'objet que vous avez trouvé.</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                            <h3 class="font-semibold text-lg mb-2 text-yellow-600">Comment rechercher un objet perdu ?</h3>
                            <p class="text-gray-600">Consultez notre page de recherche et utilisez les filtres pour trouver des objets correspondant à votre description.</p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                            <h3 class="font-semibold text-lg mb-2 text-yellow-600">Quand puis-je espérer récupérer mon objet ?</h3>
                            <p class="text-gray-600">Une fois que vous avez identifié votre objet, contactez-nous pour organiser sa récupération dans les meilleurs délais.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
// Imports
import { Head } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout";
import ContactInfo from "@/Components/ContactInfo";
import ContactForm from "@/Components/ContactForm";
</script>

<style scoped>
/* Les styles spécifiques peuvent être ajoutés ici */
</style>
