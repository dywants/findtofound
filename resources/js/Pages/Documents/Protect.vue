<template>

    <Head>
        <title>DocuTrace - Protection de Documents</title>
        <meta type="description" content="Protégez vos documents importants avec DocuTrace">
    </Head>
    <div class="min-h-screen bg-gradient-to-b from-white to-blue-50">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Formulaire de protection -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="protect" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
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
                                        <div class="flex text-sm text-gray-600">
                                            <label
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Téléverser un fichier</span>
                                                <input type="file" class="sr-only" @change="handleFileUpload"
                                                    accept=".pdf,.jpg,.jpeg,.png">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">
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
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Protéger le document
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des documents protégés -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Mes documents protégés</h3>

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
                                                class="text-blue-600 hover:text-blue-900 mr-4">
                                                Télécharger
                                            </button>
                                            <button @click="deleteDocument(doc)"
                                                class="text-red-600 hover:text-red-900">
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
        });
    }
};

const downloadDocument = (doc) => {
    window.location.href = route('documents.download', { id: doc.id });
};

const deleteDocument = (doc) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
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
    @apply text-sm font-medium text-blue-600 hover:text-blue-500;
}

.delete-button {
    @apply text-sm font-medium text-red-600 hover:text-red-500;
}
</style>
