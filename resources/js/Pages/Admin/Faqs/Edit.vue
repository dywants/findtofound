<template>
    <Head title="Admin - Faq edit" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul>
                <li>
                    <Link :href="route('admin.index')">Admin</Link>
                </li>
                <li>
                    <Link>Faqs edit: {{ faq.title}}</Link>
                </li>
            </ul>
        </template>
    </HeaderAdmin>
    <!-- component -->
    <form method="post" @submit.prevent="submit">
        <ErrorsAndMessages :errors="errors" />
        <div class="bg-indigo-50 mb-4 md:px-20 pt-6">
            <div class=" bg-white rounded-md px-6 mb-4 py-10 max-w-2xl mx-auto">
                <h1 class="text-center text-2xl font-bold text-gray-500 mb-10">Edit Faq</h1>
                <div class="space-y-4">
                    <div>
                        <label for="title" class="text-lx mb-2 font-serif">Titre:</label>
                        <input type="text" placeholder="title" name="title" id="title" v-model="form.title"
                               class="outline-none py-1 px-2 text-md border-2 rounded-md w-full" />
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-lg font-serif">Description:</label>
                        <textarea id="description" cols="30" rows="10" name="body" v-model="form.body" placeholder="whrite here.." class="w-full font-serif p-4 text-gray-600 bg-indigo-50 outline-none rounded-md"></textarea>
                    </div>

                    <button type="submit" class="text-left px-6 py-2 mx-auto block rounded-md text-lg font-semibold text-indigo-100 bg-indigo-600">Modifier</button>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages";
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import {Link, usePage} from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "Edit",
    components: {ErrorsAndMessages,HeaderAdmin, Link},
    layout: AdminLayout,
    props: ['faq','errors'],
    setup(){
        const form = reactive({
            title: null,
            body: null,
            _token: usePage().props.value.csrf_token,
            _method: "PUT"
        });
        // retrieve post prop
        const {title, body, id } = usePage().props.value.faq;
        form.title = title;
        form.body = body;

        function submit() {
            Inertia.post(route('faq.update', {'faq': id}), form, {
                forceFormData: true
            });
        }
        return {
            form, submit
        }
    }
}
</script>

<style scoped>

</style>
