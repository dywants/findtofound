<template>
    <article class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm p-8">
        <!-- En-tête du formulaire -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">'Informations de la pièce'</h2>
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
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <ErrorMessage name="piece_id" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Nom sur la pièce -->
                <div class="space-y-4">
                    <label for="fullName" class="block text-sm font-medium text-gray-700">Nom inscrit sur la
                        pièce</label>
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
                    <label for="findCity" class="block text-sm font-medium text-gray-700">Ville où la pièce a été
                        retrouvée</label>
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
                            <option v-for="condition in pieceConditions" :key="condition.value"
                                :value="condition.value">
                                {{ condition.value }}
                            </option>
                        </Field>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
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
                }" @dragenter.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @dragover.prevent
                @drop.prevent="handleDrop($event)">

                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path
                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-4h.01"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>

                    <div class="mt-4">
                        <label class="relative cursor-pointer" :class="{ 'cursor-not-allowed': imgUrl.length >= 2 }">
                            <span
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                :class="{ 'opacity-50': imgUrl.length >= 2 }">
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
                <div v-for="(img, index) in imgUrl" :key="index" class="relative rounded-lg overflow-hidden group">
                    <img :src="img.url || img" class="w-full h-32 object-cover">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                        <button @click="removeImage(index)"
                            class="p-2 bg-red-500 rounded-full text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <span
                        class="absolute bottom-2 left-2 text-white text-sm font-medium bg-black bg-opacity-50 px-2 py-1 rounded">
                        {{ index === 0 ? 'Recto' : 'Verso' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Details supplémentaires -->
        <div class="mt-8 space-y-4">
            <label class="block text-sm font-medium text-gray-700">Détails supplémentaires</label>
            <div class="mt-1">
                <QuillEditor v-model:content="additionalDetailsValue" :options="editorConfig"
                    class="border border-gray-300 rounded-lg shadow-sm" style="min-height: 200px;" />
            </div>
            <ErrorMessage name="additionalDetails" class="mt-2 text-sm text-red-600" />
        </div>
    </article>
</template>

<script>
import { Field, ErrorMessage } from "vee-validate";
import { ref, reactive, watch, onMounted } from 'vue';
import axios from 'axios';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    name: "InforObject",
    components: {
        Field,
        ErrorMessage,
        QuillEditor
    },
    emits: ['updateImages', 'amount', 'update:additionalDetails', 'form-data-change'],
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
            required: false,
            default: 0
        },
        additionalDetails: {
            type: [String, Object],
            default: ''
        },
        initialData: {
            type: Object,
            default() {
                return {};
            }
        }
    },
    setup(props, { emit }) {
        // Initialiser les données avec les valeurs sauvegardées
        const formValues = reactive({
            ...props.initialData
        });
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

                // S'assurer que additionalDetailsValue est initialisé avec une chaîne vide si null ou undefined
        const additionalDetailsValue = ref(props.additionalDetails || '');
        const editorConfig = {
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            theme: 'snow',
            placeholder: 'Ajoutez des détails supplémentaires ici...'
        };

        // Surveiller les changements dans les props storedImages
        // Utiliser immediate: false pour éviter une récursion lors de l'initialisation
        watch(() => props.storedImages, (newImages, oldImages) => {
            // Vérifier que les données ont changé pour éviter les mises à jour récursives
            if (newImages && newImages.length > 0 && JSON.stringify(newImages) !== JSON.stringify(imgUrl.value)) {
                console.log('storedImages changed in InforObject', newImages);
                imgUrl.value = [...newImages];
            }
        }, { deep: true, immediate: false });

        // Utiliser un débat pour éviter les mises à jour trop fréquentes
        watch(additionalDetailsValue, (newValue, oldValue) => {
            // Éviter d'émettre si la valeur n'a pas changé
            if (JSON.stringify(newValue) !== JSON.stringify(oldValue)) {
                console.log('additionalDetails changed', newValue);
                emit('update:additionalDetails', newValue);
            }
        });

        onMounted(() => {
            // Initialiser imgUrl avec les images stockées sans déclencher de watcher
            if (props.storedImages && props.storedImages.length > 0) {
                console.log('Initializing imgUrl with storedImages', props.storedImages);
                imgUrl.value = [...props.storedImages];
            }
            
            // Initialiser formValues avec les données initiales si présentes
            if (props.initialData && Object.keys(props.initialData).length > 0) {
                Object.assign(formValues, props.initialData);
            }
            
            // Émettre l'objet form-data-change une seule fois pour initialiser les données
            setTimeout(() => {
                emit('form-data-change', formValues);
            }, 0);
        });
        
        // Surveiller les changements dans les données du formulaire
        watch(formValues, (newValues) => {
            emit('form-data-change', newValues);
        }, { deep: true });

        // Eviter de surveiller imgUrl directement pour éviter une récursion infinie
        // À la place, nous émettrons des événements manuellement après les modifications

        const onChange = (event) => {
            let pieceId = event.target.value;
            const pieceSelect = props.pieces.find(piece => piece.id == pieceId);
            
            // Mettre à jour la valeur dans formValues
            formValues.piece_id = pieceId;
            
            if (pieceSelect) {
                emit("amount", pieceSelect.amount);
            }
        };

        const handleImageUpload = async (file) => {
            if (imgUrl.value.length >= 2) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                // Préparer l'objet image avec l'URL et le fichier
                const imageObject = {
                    url: e.target.result,
                    file: file // Stocker le fichier lui-même pour l'envoi au serveur
                };
                
                // Créer une nouvelle copie du tableau pour éviter les problèmes de réactivité
                const newImgUrls = [...imgUrl.value, imageObject];
                imgUrl.value = newImgUrls;
                
                // Émettre l'événement manuellement après la modification
                emit('updateImages', newImgUrls);
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
            // Créer une nouvelle copie du tableau pour éviter les problèmes de réactivité
            const newImgUrls = [...imgUrl.value];
            newImgUrls.splice(index, 1);
            imgUrl.value = newImgUrls;
            
            // Émettre l'événement manuellement après la modification
            emit('updateImages', newImgUrls);
        };

        return {
            imgUrl,
            isDragging,
            isLoading,
            rotations,
            pieceConditions,
            additionalDetailsValue,
            editorConfig,
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
.form-input:focus,
.form-select:focus {
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
