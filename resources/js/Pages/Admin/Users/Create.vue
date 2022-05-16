<template>
    <AdminLayout>
        <Head title="Admin - Create user" />

        <HeaderAdmin>
            <template #HeaderAdmin>
                <ul>
                    <li>
                        <Link :href="route('admin.index')">Admin</Link>
                    </li>
                    <li>
                        <Link :href="route('admin.users')">Users</Link>
                    </li>
                    <li>
                        <Link :href="route('admin.new.user')">Create user</Link>
                    </li>
                </ul>
            </template>
        </HeaderAdmin>
    </AdminLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AdminLayout from "@/Layouts/AdminLayout";
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
export default {
    name: "Create",
    components: {AdminLayout,HeaderAdmin, Link},
}
</script>

<style scoped>

</style>
