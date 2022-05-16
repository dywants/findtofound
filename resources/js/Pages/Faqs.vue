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
        <Accordion class="mb-4">
            <template v-slot:title>
                <span class="font-medium text-lg">Accordion 1</span>
            </template>
            <template v-slot:content>
                <p class="mb-2 text-gray-500">
                    <b>Lorem</b>, ipsum dolor sit amet consectetur adipisicing elit. Quia,
                    porro. Non a excepturi, voluptatibus ipsam magnam, eligendi,
                    accusantium ipsa quae quis praesentium voluptate saepe ullam sint ea
                    itaque consectetur impedit?
                </p>
            </template>
        </Accordion>
        <Accordion class="mb-4">
            <template v-slot:title>
                <span class="font-medium text-lg">Accordion 2</span>
            </template>
            <template v-slot:content>
                <p>
                    <b>Lorem</b>, ipsum dolor sit amet consectetur adipisicing elit. Quia,
                    porro. Non a excepturi, voluptatibus ipsam magnam, eligendi,
                    accusantium ipsa quae quis praesentium voluptate saepe ullam sint ea
                    itaque consectetur impedit?
                </p>
            </template>
        </Accordion>
    </div>
</template>

<script setup>
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';
import Accordion from "@/Components/Accordion";

</script>

<style scoped>

</style>
