<template>
    <Head>
        <title>DocuTrace - Protection de Documents</title>
        <meta type="description" content="Protégez vos documents importants avec DocuTrace">
        <meta name="language" content="fr">
        <meta property="og:locale" content="fr_FR">
    </Head>

    <div class="min-h-screen bg-gradient-to-b from-white to-blue-50 pb-12">
        <!-- En-tête avec fond dégradé et titre -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-6 mb-8 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center space-x-4">
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Protection de Documents</h1>
                        <p class="text-blue-100 text-sm mt-1">Sécurisez vos documents importants avec DocuTrace</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Fil d'Ariane -->
            <div class="mb-6">
                <BreadcrumbNav :items="[
                    { label: 'DocuTrace', href: route('documents.home') },
                    { label: 'Protection de Documents' }
                ]" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne de gauche: Formulaire de protection -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Nouveau document
                            </h2>

                            <form @submit.prevent="protect" class="space-y-6">
                                <!-- Zone de téléversement de document -->
                                <document-uploader
                                    v-model="form.document"
                                    @file-selected="handleFileUpload"
                                    :error="form.errors.document"
                                />

                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 shadow-inner">
                                    <div>
                                        <label for="watermark" class="block text-sm font-medium text-gray-700 mb-1">
                                            Texte du filigrane
                                        </label>
                                        <input
                                            type="text"
                                            id="watermark"
                                            v-model="form.watermark_text"
                                            maxlength="255"
                                            placeholder="Exemple: CONFIDENTIEL - [votre nom]"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        />
                                        <div v-if="form.errors.watermark_text" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.watermark_text }}
                                        </div>
                                    </div>

                                    <!-- Composant d'options avancées pour le filigrane -->
                                    <watermark-options
                                        v-model="form.watermark_text"
                                        @update:options="updateWatermarkOptions"
                                    />

                                    <div class="mt-4">
                                        <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">
                                            Utilisation prévue
                                        </label>
                                        <input
                                            type="text"
                                            id="purpose"
                                            v-model="form.purpose"
                                            maxlength="255"
                                            placeholder="Exemple: Document interne, Partage avec les partenaires"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                        />
                                        <div v-if="form.errors.purpose" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.purpose }}
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" :disabled="form.processing"
                                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-75 disabled:cursor-not-allowed transition-colors duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ form.processing ? 'Traitement en cours...' : 'Protéger le document' }}</span>
                                    </button>
                                </div>

                                <!-- Information sur la sécurité -->
                                <div class="mt-4 text-xs text-gray-500 bg-blue-50 p-3 rounded-md border border-blue-100 flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Vos documents sont sécurisés avec un filigrane unique et stockés de manière sécurisée. Seuls vous pouvez y accéder.</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Colonne de droite: Liste des documents protégés -->
                <div class="lg:col-span-2">
                    <protected-document-list
                        :documents="documents"
                        :success-message="$page.props.flash.success"
                        @download="downloadDocument"
                        @delete="deleteDocument"
                        :enable-sort-filter="true"
                        :enable-display-toggle="true"
                        title="Mes documents protégés"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useForm, router } from '@inertiajs/vue3';
import BreadcrumbNav from '@/Components/BreadcrumbNav.vue';
import DocumentUploader from '@/Components/Documents/DocumentUploader.vue';
import ProtectedDocumentList from '@/Components/Documents/ProtectedDocumentList.vue';
import WatermarkOptions from '@/Components/Documents/WatermarkOptions.vue';

const props = defineProps({
    documents: {
        type: Array,
        default: () => []
    }
});

const form = useForm({
    document: null,
    watermark_text: '',
    purpose: '',
    // Nouvelles options pour le filigrane
    opacity: 0.2,
    rotation: 45,
    fontSize: 'auto',
    repetition: true,
    position: 'center',
});

const selectedFile = ref(null);

const handleFileUpload = (file) => {
    // Le composant DocumentUploader nous envoie directement le fichier
    if (file) {
        form.document = file;
        selectedFile.value = file;
    }
};

// Méthode pour mettre à jour les options du filigrane
const updateWatermarkOptions = (options) => {
    form.opacity = options.opacity;
    form.rotation = options.rotation;
    form.fontSize = options.fontSize;
    form.repetition = options.repetition;
    form.position = options.position;
};

const protect = () => {
    if (form.document) {
        form.post(route('documents.protect'), {
            // Ne pas préserver le scroll pour forcer le rechargement complet de la page
            preserveScroll: false,
            preserveState: false,
            // Recharger complètement la page pour afficher la liste mise à jour
            onSuccess: () => {
                form.reset();
                selectedFile.value = null;
                // Forcer un rechargement de la page après le traitement
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            },
            onError: () => {
                // Scroll vers les erreurs pour améliorer l'UX
                setTimeout(() => {
                    const firstErrorEl = document.querySelector('.text-red-500');
                    if (firstErrorEl) {
                        firstErrorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 100);
            }
        });
    }
};

const downloadDocument = (doc) => {
    window.location.href = route('documents.download', { id: doc.id });
};

const deleteDocument = (doc) => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le document "${doc.original_name}" ?
Cette action est irréversible.`)) {
        router.delete(route('documents.destroy', { id: doc.id }), {
            preserveScroll: true,
            onSuccess: () => {
                props.documents = props.documents.filter(d => d.id !== doc.id);
            },
        });
    }
};
</script>

<style scoped>
/* Les styles spécifiques au composant pourraient être ajoutés ici */
</style>
