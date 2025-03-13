<template>
    <Head title="Admin - Pièces d'identité"/>

    <HeaderAdmin>
        <template #HeaderAdmin>
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <Link :href="route('admin.index')" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Tableau de bord
                        </Link>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Pièces d'identité</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </template>
    </HeaderAdmin>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <ErrorsAndMessages :errors="errors" />
        
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <div class="flex items-center">
                <div class="p-2 bg-blue-50 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Gestion des pièces d'identité</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" id="search" class="block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Rechercher une pièce..." v-model="search">
                </div>
                
                <button @click="openCreateModal()" class="flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Identifiant (Slug)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="piece in filteredPieces" :key="piece.id" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ piece.name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ piece.slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ formatCurrency(piece.amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ formatDateFR(piece.created_at) }}</div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex justify-end space-x-2">
                                    <button @click="openEditModal(piece)" class="text-blue-600 hover:text-blue-900 p-1 rounded-md hover:bg-blue-50 transition-colors" title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button @click="deleteFaq(piece.id)" class="text-red-600 hover:text-red-900 p-1 rounded-md hover:bg-red-50 transition-colors" title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="filteredPieces.length === 0">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 text-sm">
                                Aucune pièce d'identité trouvée
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">{{ filteredPieces.length }}</span> sur <span class="font-medium">{{ pieces.length }}</span> pièces
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none" disabled>
                        Précédent
                    </button>
                    <button class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none" disabled>
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modale pour créer une pièce d'identité -->
    <TransitionRoot appear :show="isCreateModalOpen" as="template">
        <Dialog as="div" @close="closeCreateModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-50" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-lg bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="div" class="flex items-center pb-4 mb-4 border-b border-gray-200">
                                <div class="p-2 bg-blue-50 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Ajouter une nouvelle pièce d'identité</h3>
                            </DialogTitle>

                            <form @submit.prevent="submitCreate">
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom de la pièce</label>
                                        <Input 
                                            type="text" 
                                            id="name" 
                                            name="name" 
                                            v-model="createForm.name" 
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                                            placeholder="Carte Nationale d'Identité" 
                                            required 
                                        />
                                        <InputError :message="createForm.errors.name" class="mt-1" />
                                    </div>
                                    
                                    <div class="col-span-2">
                                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900">Montant de la récompense (FCFA)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <span class="text-gray-500">FCFA</span>
                                            </div>
                                            <Input 
                                                type="number" 
                                                id="amount" 
                                                name="amount" 
                                                v-model="createForm.amount" 
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-16 p-2.5" 
                                                placeholder="1000" 
                                                required 
                                            />
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">Montant à payer pour retrouver cette pièce.</p>
                                        <InputError :message="createForm.errors.amount" class="mt-1" />
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4 mt-8">
                                    <Button 
                                        type="submit" 
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                        :disabled="createForm.processing"
                                    >
                                        <svg v-if="createForm.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>{{ createForm.processing ? 'Enregistrement...' : 'Enregistrer' }}</span>
                                    </Button>
                                    
                                    <button 
                                        type="button"
                                        @click="closeCreateModal" 
                                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
                                    >
                                        Annuler
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    
    <!-- Modale pour modifier une pièce d'identité -->
    <TransitionRoot appear :show="isEditModalOpen" as="template">
        <Dialog as="div" @close="closeEditModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-50" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-lg bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="div" class="flex items-center pb-4 mb-4 border-b border-gray-200">
                                <div class="p-2 bg-blue-50 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-800">Modifier une pièce d'identité</h3>
                            </DialogTitle>

                            <form @submit.prevent="submitEdit">
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900">Nom de la pièce</label>
                                        <Input 
                                            type="text" 
                                            id="edit_name" 
                                            name="name" 
                                            v-model="editForm.name" 
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                                            placeholder="Carte Nationale d'Identité" 
                                            required 
                                        />
                                        <InputError :message="editForm.errors.name" class="mt-1" />
                                    </div>
                                    
                                    <div class="col-span-2">
                                        <label for="edit_amount" class="block mb-2 text-sm font-medium text-gray-900">Montant de la récompense (FCFA)</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <span class="text-gray-500">FCFA</span>
                                            </div>
                                            <Input 
                                                type="number" 
                                                id="edit_amount" 
                                                name="amount" 
                                                v-model="editForm.amount" 
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-16 p-2.5" 
                                                placeholder="1000" 
                                                required 
                                            />
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">Montant à payer pour retrouver cette pièce.</p>
                                        <InputError :message="editForm.errors.amount" class="mt-1" />
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4 mt-8">
                                    <Button 
                                        type="submit" 
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                        :disabled="editForm.processing"
                                    >
                                        <svg v-if="editForm.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Mettre à jour
                                    </Button>
                                    
                                    <button 
                                        type="button"
                                        @click="closeEditModal" 
                                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
                                    >
                                        Annuler
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import {Link, useForm} from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages";
import {Inertia} from "@inertiajs/inertia";
import { ref, computed, reactive } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import Input from "@/Components/Input";
import Button from "@/Components/Button";
import InputError from "@/Components/InputError";

export default {
    name: "Index",
    components: { 
        HeaderAdmin, 
        Link, 
        ErrorsAndMessages, 
        Dialog, 
        DialogPanel, 
        DialogTitle, 
        TransitionChild, 
        TransitionRoot,
        Input,
        Button,
        InputError
    },
    props: ['pieces', 'errors'],
    layout: AdminLayout,

    setup(props) {
        const search = ref('');
        
        // État pour les modales
        const isCreateModalOpen = ref(false);
        const isEditModalOpen = ref(false);
        const currentPieceId = ref(null);
        
        // Formulaire de création
        const createForm = useForm({
            name: '',
            amount: ''
        });
        
        // Formulaire d'édition
        const editForm = useForm({
            name: '',
            amount: '',
            _method: 'PUT'
        });
        
        // Ouvrir la modale de création
        const openCreateModal = () => {
            createForm.reset();
            isCreateModalOpen.value = true;
        };
        
        // Fermer la modale de création
        const closeCreateModal = () => {
            isCreateModalOpen.value = false;
        };
        
        // Ouvrir la modale d'édition
        const openEditModal = (piece) => {
            currentPieceId.value = piece.id;
            editForm.name = piece.name;
            editForm.amount = piece.amount;
            isEditModalOpen.value = true;
        };
        
        // Fermer la modale d'édition
        const closeEditModal = () => {
            isEditModalOpen.value = false;
            currentPieceId.value = null;
        };
        
        // Soumettre le formulaire de création
        const submitCreate = () => {
            createForm.post(route('piece.store'), {
                onSuccess: () => {
                    closeCreateModal();
                    createForm.reset();
                }
            });
        };
        
        // Soumettre le formulaire d'édition
        const submitEdit = () => {
            editForm.post(route('piece.update', { piece: currentPieceId.value }), {
                onSuccess: () => {
                    closeEditModal();
                }
            });
        };
        
        // Filtre les pièces en fonction de la recherche
        const filteredPieces = computed(() => {
            if (!search.value) return props.pieces;
            
            const searchLower = search.value.toLowerCase();
            return props.pieces.filter(piece => {
                return (
                    piece.name.toLowerCase().includes(searchLower) ||
                    piece.slug.toLowerCase().includes(searchLower)
                );
            });
        });
        
        // Suppression d'une pièce d'identité
        const deleteFaq = (id) => {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette pièce d\'identité ?')) return;
            Inertia.delete(route('piece.destroy', {id}));
        };
        
        // Formatage de la date en français
        function formatDateFR(date) {
            if (!date) return '';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('fr-FR', options);
        }
        
        // Formatage du montant en FCFA
        function formatCurrency(amount) {
            if (!amount && amount !== 0) return '0 FCFA';
            return new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'XAF',
                minimumFractionDigits: 0
            }).format(amount);
        }

        return {
            search,
            filteredPieces,
            deleteFaq,
            formatDateFR,
            formatCurrency,
            isCreateModalOpen,
            isEditModalOpen,
            createForm,
            editForm,
            openCreateModal,
            closeCreateModal,
            openEditModal,
            closeEditModal,
            submitCreate,
            submitEdit
        };
    }
};
</script>

<style scoped>

</style>
