<template>
    <Head title="Paiement pièce"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Paiement
            </h2>
        </template>
    </HeaderPage>
    {{ amount_check }}
</template>

<script>
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "Paiement",
    components: {HeaderPage,Link},
    props: ['amount_check']
}
</script>

<style scoped>

</style>
