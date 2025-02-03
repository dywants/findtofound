<template>
    <article class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm p-8">
        <!-- En-tête du formulaire -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Informations de la pièce</h2>
            <p class="text-gray-600">Veuillez remplir les informations concernant la pièce trouvée</p>
        </div>

        <!-- Grid layout pour une meilleure organisation -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informations principales -->
            <div class="space-y-8">
                <!-- Type de pièce -->
                <div class="space-y-4">
                    <label for="piece_id" class="block text-sm font-medium text-gray-700">Type de pièce</label>
                    <div class="mt-1 relative">
                        <Field @change="onChange($event)" id="piece_id" name="piece_id" as="select"
                            class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-xl transition-shadow duration-200 bg-white shadow-sm hover:shadow-md">
                            <option value="">Sélectionnez le type de pièce</option>
                            <option v-for="piece in pieces" :key="piece.id" :value="piece.id">
                                {{ piece.name }}
                            </option>
                        </Field>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <ErrorMessage name="piece_id" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Nom sur la pièce -->
                <div class="space-y-4">
                    <label for="fullName" class="block text-sm font-medium text-gray-700">Nom inscrit sur la pièce</label>
                    <div class="mt-1 relative rounded-xl shadow-sm">
                        <Field type="text" id="fullName" name="fullName"
                            class="block w-full px-4 py-3 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 bg-white shadow-sm hover:shadow-md"
                            placeholder="Ex: Jean Dupont" />
                    </div>
                    <ErrorMessage name="fullName" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Date de découverte -->
                <div class="space-y-4">
                    <label for="findDate" class="block text-sm font-medium text-gray-700">Date de découverte</label>
                    <div class="mt-1 relative rounded-xl shadow-sm">
                        <Field type="date" id="findDate" name="findDate"
                            class="block w-full px-4 py-3 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 bg-white shadow-sm hover:shadow-md" />
                    </div>
                    <ErrorMessage name="findDate" class="mt-2 text-sm text-red-600" />
                </div>
            </div>

            <!-- Localisation -->
            <div class="space-y-8">
                <!-- Ville de découverte -->
                <div class="space-y-4">
                    <label for="findCity" class="block text-sm font-medium text-gray-700">Ville où la pièce a été retrouvée</label>
                    <div class="mt-1 relative rounded-xl shadow-sm">
                        <Field type="text" id="findCity" name="findCity"
                            class="block w-full px-4 py-3 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 bg-white shadow-sm hover:shadow-md"
                            placeholder="Ex: Paris" />
                    </div>
                    <ErrorMessage name="findCity" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- État de la pièce -->
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700">État de la pièce</label>
                    <div class="mt-1 relative">
                        <Field name="pieceCondition" as="select"
                            class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 rounded-xl transition-shadow duration-200 bg-white shadow-sm hover:shadow-md">
                            <option value="">Sélectionnez l'état</option>
                            <option v-for="condition in pieceConditions" :key="condition.value" :value="condition.value">
                                {{ condition.value }}
                            </option>
                        </Field>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <ErrorMessage name="pieceCondition" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Quartier -->
                <div class="space-y-4">
                    <label for="ward" class="block text-sm font-medium text-gray-700">Quartier</label>
                    <div class="mt-1 relative rounded-xl shadow-sm">
                        <Field type="text" id="ward" name="ward"
                            class="block w-full px-4 py-3 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow duration-200 bg-white shadow-sm hover:shadow-md"
                            placeholder="Ex: Akwa" />
                    </div>
                    <ErrorMessage name="ward" class="mt-2 text-sm text-red-600" />
                </div>
            </div>
        </div>

        <!-- Section des photos -->
        <div class="mt-8 space-y-4">
            <div class="flex justify-between items-center">
                <label class="block text-sm font-medium text-gray-700">Photos de la pièce</label>
                <span class="text-sm text-gray-500">
                    {{ imgUrl.length }}/2 photos
                </span>
            </div>

            <!-- Zone de dépôt -->
            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 transition-all duration-200"
                :class="{
                    'bg-gray-50 border-blue-500': isDragging,
                    'hover:border-blue-500': imgUrl.length < 2,
                    'opacity-50 cursor-not-allowed': imgUrl.length >= 2
                }"
                @dragenter.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @dragover.prevent
                @drop.prevent="handleDrop($event)">
                
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-4h.01" 
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    
                    <div class="mt-4">
                        <label class="relative cursor-pointer"
                            :class="{'cursor-not-allowed': imgUrl.length >= 2}">
                            <span class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                :class="{'opacity-50': imgUrl.length >= 2}">
                                Sélectionner des photos
                            </span>
                            <input type="file" class="sr-only" @change="onFileChange" accept="image/*" multiple
                                :disabled="imgUrl.length >= 2">
                        </label>
                    </div>
                    
                    <p class="mt-2 text-sm text-gray-500">
                        ou glissez-déposez vos images ici
                    </p>
                    
                    <p class="mt-2 text-xs text-gray-400">
                        PNG, JPG jusqu'à 10MB
                    </p>

                    <!-- Message d'aide dynamique -->
                    <p class="mt-3 text-sm" :class="{
                        'text-yellow-600': imgUrl.length === 0,
                        'text-blue-600': imgUrl.length === 1,
                        'text-green-600': imgUrl.length === 2
                    }">
                        <template v-if="imgUrl.length === 0">
                            Veuillez ajouter une photo du recto et du verso de la pièce
                        </template>
                        <template v-if="imgUrl.length === 1">
                            N'oubliez pas d'ajouter une photo du verso de la pièce
                        </template>
                        <template v-if="imgUrl.length === 2">
                            ✓ Les deux photos ont été ajoutées
                        </template>
                    </p>
                </div>
            </div>

            <!-- Aperçu des images -->
            <div v-if="imgUrl.length > 0" class="grid grid-cols-2 gap-4 mt-4">
                <div v-for="(url, index) in imgUrl" :key="index" 
                    class="relative rounded-lg overflow-hidden group">
                    <img :src="url" class="w-full h-32 object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                        <button @click="removeImage(index)"
                            class="p-2 bg-red-500 rounded-full text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <span class="absolute bottom-2 left-2 text-white text-sm font-medium bg-black bg-opacity-50 px-2 py-1 rounded">
                        {{ index === 0 ? 'Recto' : 'Verso' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Details supplémentaires -->
        <div class="mt-8 space-y-4">
            <label class="block text-sm font-medium text-gray-700">Détails supplémentaires</label>
            <div class="mt-1">
                <Editor
                    v-model="additionalDetailsValue"
                    :api-key="'no-api-key'"
                    :init="{
                        height: 300,
                        menubar: false,
                        plugins: [
                            'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
                            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                            'insertdatetime', 'media', 'table', 'help', 'wordcount'
                        ],
                        toolbar: 'undo redo | formatselect | ' +
                            'bold italic backcolor | alignleft aligncenter ' +
                            'alignright alignjustify | bullist numlist outdent indent | ' +
                            'removeformat',
                        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
                        skin: 'oxide',
                        content_css: 'default',
                        branding: false,
                        placeholder: 'Ajoutez des détails supplémentaires ici...',
                        statusbar: false
                    }"
                    class="mt-1 block w-full rounded-xl shadow-sm"
                />
            </div>
            <ErrorMessage name="additionalDetails" class="mt-2 text-sm text-red-600" />
        </div>
    </article>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";
import { ref, reactive, watch, onMounted } from 'vue';
import axios from 'axios';
import Editor from '@tinymce/tinymce-vue';

export default {
    name: "InforObject",
    components: { Field, ErrorMessage, Editor },
    emits: ['updateImages', 'amount', 'update:additionalDetails'],
    props: {
        pieces: {
            type: Array,
            required: true
        },
        storedImages: {
            type: Array,
            default() {
                return [];
            }
        },
        amount: {
            type: Number,
            required: true
        },
        additionalDetails: {
            type: String,
            default: ''
        }
    },
    setup(props, { emit }) {
        const imgUrl = ref([]);
        const isDragging = ref(false);
        const isLoading = ref([]);
        const rotations = ref([0, 0]);
        const pieceConditions = ref([
            { value: 'Excellent' },
            { value: 'Bon' },
            { value: 'Moyen' },
            { value: 'Mauvais' }
        ]);

        const additionalDetailsValue = ref(props.additionalDetails);

        watch(additionalDetailsValue, (newValue) => {
            emit('update:additionalDetails', newValue);
        });

        onMounted(async () => {
            if (props.storedImages && props.storedImages.length > 0) {
                imgUrl.value = [...props.storedImages];
            }
        });

        // Surveiller les changements d'images et émettre les mises à jour
        watch(imgUrl, (newImages) => {
            emit('updateImages', newImages);
        }, { deep: true });

        const onChange = (event) => {
            let pieceId = event.target.value;
            const pieceSelect = props.pieces.find(piece => piece.id == pieceId)
            if (pieceSelect) {
                emit("amount", pieceSelect.amount)
            }
        };

        const handleImageUpload = async (file) => {
            if (imgUrl.value.length >= 2) return;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                imgUrl.value.push(e.target.result);
            };
            reader.readAsDataURL(file);
        };

        const onFileChange = async (e) => {
            const files = Array.from(e.target.files);
            if (imgUrl.value.length + files.length > 2) {
                alert('Vous ne pouvez télécharger que 2 photos maximum');
                return;
            }
            
            for (const file of files) {
                if (file.type.startsWith('image/')) {
                    await handleImageUpload(file);
                }
            }
        };

        const handleDrop = async (e) => {
            e.preventDefault();
            isDragging.value = false;
            
            const files = Array.from(e.dataTransfer.files);
            if (imgUrl.value.length + files.length > 2) {
                alert('Vous ne pouvez télécharger que 2 photos maximum');
                return;
            }
            
            for (const file of files) {
                if (file.type.startsWith('image/')) {
                    await handleImageUpload(file);
                }
            }
        };

        const removeImage = (index) => {
            imgUrl.value.splice(index, 1);
        };

        return {
            imgUrl,
            isDragging,
            isLoading,
            rotations,
            pieceConditions,
            additionalDetailsValue,
            onChange,
            onFileChange,
            handleDrop,
            removeImage,
            handleImageUpload
        };
    }
};
</script>

<style scoped>
.form-input:focus, .form-select:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

.radio-group label:hover {
    background-color: rgba(59, 130, 246, 0.05);
}

.file-upload {
    transition: all 0.2s ease-in-out;
}

.file-upload:hover {
    border-color: rgba(59, 130, 246, 0.5);
    background-color: rgba(59, 130, 246, 0.05);
}

.preview-image {
    transition: transform 0.2s ease-in-out;
}

.preview-image:hover {
    transform: scale(1.05);
}
</style>
