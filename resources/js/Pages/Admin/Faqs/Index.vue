<template>

    <Head title="Admin - Faqs" />

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul>
                <li>
                    <Link :href="route('admin.index')">Admin</Link>
                </li>
                <li>
                    <Link :href="route('faq.index')">Faqs</Link>
                </li>
            </ul>
        </template>
    </HeaderAdmin>

    <div class="card has-table">
        <ErrorsAndMessages :errors="errors" />
        <header class="card-header">
            <p class="card-header-title space-x-1">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                    </svg>
                </span>
                Faqs
            </p>
            <Link :href="route('faq.create')" class="card-header-icon h-10 w-10 rounded-sm bg-blue-600 text-white">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </span>
            </Link>
        </header>
        <div class="card has-table">
            <div class="card-content">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Titre</th>
                            <th>Text</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="faq in faqs.data" :key="faq.id">
                            <td class="image-cell">
                                <div class="image">
                                    <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg"
                                        class="rounded-full">
                                </div>
                            </td>
                            <td data-label="Name">{{ faq.title }}</td>
                            <td data-label="Company">{{ faq.body }}</td>

                            <td class="actions-cell">
                                <div class="buttons right nowrap">
                                    <Link :href="route('faq.edit', { faq: faq.id })" class="button small green --jb-modal"
                                        data-target="sample-modal-2" type="button">
                                    <span class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </span>
                                    </Link>
                                    <a href="javascript:void(0)" @click.prevent="deleteFaq(faq.id)"
                                        class="button small red --jb-modal" data-target="sample-modal" type="button">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        <ul class="buttons">
                            <li :class="faqs.links[0].url == null ? ' active' : 'disabled'"
                                :disabled="faqs.links[0].url == null" class="button">
                                <Link :href="faqs.links[0].url == null ? '#' : faqs.links[0].url"
                                    v-html="faqs.links[0].label" />
                            </li>
                            <li v-for="item in numberLinks" :class="item.active ? ' active' : ' disabled'"
                                class="button">
                                <Link :href="!item.active ? '#' : item.url" v-html="item.label" />
                            </li>
                            <li :class="faqs.links[faqs.links.length - 1].url == null ? ' active' : ' disabled'"
                                class="button">
                                <Link
                                    :href="faqs.links[faqs.links.length - 1].url == null ? '#' : faqs.links[faqs.links.length - 1].url"
                                    v-html="faqs.links[faqs.links.length - 1].label" />
                            </li>
                        </ul>
                        <small>Page {{ faqs.current_page }} of {{ numberLinks.length }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import HeaderAdmin from '@/Layouts/Admin/HeaderAdmin.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ErrorsAndMessages from "@/Components/Elements/ErrorsAndMessages.vue";
import { computed, inject } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    name: "Index",
    components: {
        Head,
        Link,
        HeaderAdmin,
        ErrorsAndMessages
    },
    layout: AdminLayout,
    props: ['faqs', 'errors'],

    setup() {
        const deleteFaq = (id) => {
            if (!confirm('are you sure?')) return;
            Inertia.delete(route('faq.destroy', { id }));
        }

        const faqs = computed(() => usePage().props.value.faqs);

        const numberLinks = faqs.value.links.filter((v, i) => i > 0 && i < faqs.value.links.length - 1);
        return {
            faqs,
            deleteFaq,
            numberLinks
        }
    }
}
</script>

<style scoped></style>
