<template>
    <Head title="Admin - Ajouter une pièce d'identité" />

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
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <Link :href="route('piece.index')" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Pièces d'identité</Link>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Ajouter une pièce</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </template>
    </HeaderAdmin>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="flex items-center p-6 border-b border-gray-200">
            <div class="p-2 bg-blue-50 rounded-lg mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-gray-800">Ajouter une nouvelle pièce d'identité</h2>
        </div>
        
        <div class="p-6">
            <form @submit.prevent="submit" class="max-w-2xl mx-auto">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom de la pièce</label>
                        <Input 
                            type="text" 
                            id="name" 
                            name="name" 
                            v-model="form.name" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                            placeholder="Carte Nationale d'Identité" 
                            required 
                        />
                        <InputError :message="form.errors.name" class="mt-1" />
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
                                v-model="form.amount" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-16 p-2.5" 
                                placeholder="1000" 
                                required 
                            />
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Montant à payer pour retrouver cette pièce.</p>
                        <InputError :message="form.errors.amount" class="mt-1" />
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 mt-8">
                    <Button 
                        type="submit" 
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        :disabled="form.processing"
                    >
                        <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ form.processing ? 'Enregistrement...' : 'Enregistrer' }}</span>
                    </Button>
                    
                    <Link 
                        :href="route('piece.index')" 
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200"
                    >
                        Annuler
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import Input from "@/Components/Input";
import Button from "@/Components/Button";
import InputError from "@/Components/InputError";

export default {
    name: "create",
    components: { InputError, HeaderAdmin, Link, Input, Button },
    layout: AdminLayout,

    setup() {
        const form = useForm({
            name: '',
            amount: '',
        });

        const submit = () => {
            form.post(route('piece.store'), {
                onFinish: () => form.reset('name', 'amount'),
            });
        };

        return {
            form,
            submit
        }
    }
}
</script>

<style scoped></style>
