<template>

    <Head>
        <title>DocuTrace - Protection de Documents</title>
        <meta type="description" content="Protégez vos documents importants avec DocuTrace">
        <meta name="language" content="fr">
        <meta property="og:locale" content="fr_FR">
    </Head>
    <div class="min-h-screen bg-gradient-to-b from-white to-blue-50">
        <div class="py-6 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Fil d'Ariane -->                
                <div class="mb-4 sm:mb-6">
                    <BreadcrumbNav :items="[
                        { label: 'DocuTrace', href: route('documents.home') },
                        { label: 'Protection de Documents' }
                    ]" />
                </div>
                <!-- Formulaire de protection -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="protect" class="space-y-6">
                            <div>
                                <label for="document-upload" class="block text-sm font-medium text-gray-700">
                                    Document à protéger
                                </label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                            <label
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Téléverser un fichier</span>
                                                <input id="document-upload" type="file" class="sr-only" @change="handleFileUpload"
                                                    accept=".pdf,.jpg,.jpeg,.png" aria-describedby="file-format-info">
                                            </label>
                                        </div>
                                        <p id="file-format-info" class="text-xs text-gray-500 text-center sm:text-left">
                                            PDF, PNG, JPG jusqu'à 10MB
                                        </p>
                                    </div>
                                </div>
                                <div v-if="form.errors.document" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.document }}
                                </div>
                            </div>

                            <div>
                                <label for="watermark" class="block text-sm font-medium text-gray-700">
                                    Texte du filigrane
                                </label>
                                <input type="text" id="watermark" v-model="form.watermark_text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <div v-if="form.errors.watermark_text" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.watermark_text }}
                                </div>
                            </div>

                            <div>
                                <label for="purpose" class="block text-sm font-medium text-gray-700">
                                    Utilisation prévue
                                </label>
                                <input type="text" id="purpose" v-model="form.purpose"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <div v-if="form.errors.purpose" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.purpose }}
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" :disabled="form.processing"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out transform hover:scale-105"
                                    aria-live="polite">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ form.processing ? 'Traitement en cours...' : 'Protéger le document' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des documents protégés -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Mes documents protégés</h3>
                        
                        <!-- Message de succès -->
                        <div v-if="$page.props.flash.success" class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-md flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ $page.props.flash.success }}</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Document
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Utilisation
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="doc in documents" :key="doc.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ doc.original_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ doc.purpose }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ formatDate(doc.created_at) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button @click="downloadDocument(doc)"
                                                class="text-blue-600 hover:text-blue-900 mr-4 inline-flex items-center transition duration-300 hover:scale-105 p-1 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                :aria-label="`Télécharger ${doc.original_name}`">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Télécharger
                                            </button>
                                            <button @click="deleteDocument(doc)"
                                                class="text-red-600 hover:text-red-900 inline-flex items-center transition duration-300 hover:scale-105 p-1 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                :aria-label="`Supprimer ${doc.original_name}`">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useForm, router } from '@inertiajs/vue3';
import TheNavbar from '@/Components/TheNavbar.vue';
import BreadcrumbNav from '@/Components/BreadcrumbNav.vue';

const props = defineProps({
    documents: Array
});

const form = useForm({
    document: null,
    watermark_text: '',
    purpose: '',
});

const selectedFile = ref(null);

const handleFileUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.document = file;
        selectedFile.value = file;
    }
};

const protect = () => {
    if (form.document) {
        form.post(route('documents.protect'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                selectedFile.value = null;
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

const formatDate = (date) => {
    if (!date) return '';
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(date).toLocaleDateString('fr-FR', options);
};
</script>

<style scoped>
.document-list {
    @apply divide-y divide-gray-200;
}

.document-item {
    @apply py-4 flex items-center justify-between;
}

.document-info {
    @apply flex-1 min-w-0;
}

.document-name {
    @apply text-sm font-medium text-gray-900 truncate;
}

.document-date {
    @apply text-sm text-gray-500;
}

.document-actions {
    @apply flex items-center space-x-4;
}

.action-button {
    @apply text-sm font-medium text-blue-600 hover:text-blue-500 transition duration-300 hover:scale-105 p-1 rounded-md hover:bg-blue-50;
}

.delete-button {
    @apply text-sm font-medium text-red-600 hover:text-red-500 transition duration-300 hover:scale-105 p-1 rounded-md hover:bg-red-50;
}
</style>
