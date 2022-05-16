<template>
    <AdminLayout>
        <Head title="Admin - Users" />

        <HeaderAdmin>
            <template #HeaderAdmin>
                <ul>
                    <li>
                        <Link :href="route('admin.index')">Admin</Link>
                    </li>
                    <li>
                        <Link :href="route('admin.users')">Users</Link>
                    </li>
                </ul>
            </template>
        </HeaderAdmin>
        <div class="card has-table">
            <header class="card-header">
                <p class="card-header-title">
                <span class="icon">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                   </svg>
                </span>
                    Users
                </p>
                <Link :href="route('admin.new.user')" class="card-header-icon">
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
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td class="image-cell">
                            <div class="image">
                                <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg" class="rounded-full">
                            </div>
                        </td>
                        <td data-label="Name">{{ user.name }}</td>
                        <td data-label="Company">{{ user.email }}</td>
                        <td data-label="City">{{ user.role.name }}</td>

                        <td data-label="Created">
                            <small class="text-gray-500" title="Oct 25, 2021">{{ formatDateFR(user.created_at) }}</small>
                        </td>
                        <td class="actions-cell">
                            <div class="buttons right nowrap">
                                <button class="button small green --jb-modal"  data-target="sample-modal-2" type="button">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </span>
                                </button>
                                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                                <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </span>
                                </button>
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
    </AdminLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AdminLayout from "@/Layouts/AdminLayout";
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
export default {
    name: "Index",
    components: {AdminLayout,HeaderAdmin, Link},
    props: ['users'],

    setup(){
        function formatDateFR(date) {
            const options = { year: 'numeric', month: 'numeric', day: 'numeric' }
            return new Date(date).toLocaleDateString('fr-FR', options)
        }

        return {
            formatDateFR
        }
    }
}
</script>

<style scoped>

</style>
