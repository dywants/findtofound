<template>
    <Head title="Admin - Pieces"/>

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul>
                <li>
                    <Link :href="route('admin.index')">Admin</Link>
                </li>
                <li>
                    <Link :href="route('piece.index')">Pièces</Link>
                </li>
            </ul>
        </template>
    </HeaderAdmin>
    <div class="card has-table">
        <ErrorsAndMessages :errors="errors" />
        <header class="card-header">
            <p class="card-header-title">
                   <span class="icon">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                       </svg>
                   </span>
                Pièces
            </p>

            <Link :href="route('piece.create')" class="card-header-icon h-10 w-10 rounded-sm bg-blue-600 text-white">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
            </Link>
        </header>
        <div class="card-content">
            <table>
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Amount</th>
                    <th>CreatedAt</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="piece in pieces" :key="piece.id">
                    <td>
                        {{ piece.name }}
                    </td>
                    <td data-label="Type">{{ piece.slug}}</td>
                    <td data-label="Name">{{ piece.amount }}</td>
                    <td data-label="Created">
                        <small class="text-gray-500" title="Oct 25, 2021">{{ formatDateFR(piece.created_at) }}</small>
                    </td>
                    <td class="actions-cell">
                        <div class="buttons right nowrap">
                            <Link :href="route('piece.edit', { id: piece.id})" class="button small green --jb-modal" data-target="sample-modal-2" type="button">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </span>
                            </Link>
                            <a href="javascript:void(0)" @click.prevent="deleteFaq(piece.id)"  class="button small red --jb-modal" data-target="sample-modal" type="button">
                                   <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                  </span>
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="table-pagination">
                <div class="flex items-center justify-between">
                    <div class="buttons">
                        <button type="button" class="button active">1</button>
                        <button type="button" class="button">2</button>
                        <button type="button" class="button">3</button>
                    </div>
                    <small>Page 1 of 3</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import {Link} from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Index",
    components: { HeaderAdmin , Link, ErrorsAndMessages},
    props: ['pieces'],
    layout: AdminLayout,

    setup(){
        const deleteFaq = (id) => {
            if (!confirm('are you sure?')) return;
            Inertia.delete(route('piece.destroy', {id}));
        }

        function formatDateFR(date) {
            const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
            return new Date(date).toLocaleDateString('fr-FR', options)
        }

        return {
            deleteFaq,
            formatDateFR
        }
    }

}
</script>

<style scoped>

</style>
