<template>
    <Head title="Faqs"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Faqs
            </h2>
        </template>
    </HeaderPage>
    <!-- component -->
    <!-- This is an example component -->
    <div class="max-w-4xl mx-auto bg-white p-16 mt-4 rounded shadow-sm">
        <Accordion v-for="faq in faqs" :key="faq.id" class="mb-4">
            <template v-slot:title>
                <span class="font-medium text-lg">{{ faq.title }}</span>
            </template>
            <template v-slot:content>
                <p class="mb-2 text-gray-500">
                    {{ faq.body }}
                </p>
            </template>
        </Accordion>
    </div>
</template>

<script setup>
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';
import Accordion from "@/Components/Accordion";

let props = defineProps({
    faqs: Object,
})

</script>

<style scoped>

</style>
