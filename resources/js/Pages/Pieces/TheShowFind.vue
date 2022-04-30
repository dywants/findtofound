<template>
    <Head title="Pièce retrouvée"/>
    <HeaderPage>
        <template #headerPage>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Recherchez votre pièce perdues
            </h2>
        </template>
    </HeaderPage>
    <h1>{{ thefind.fullName }}</h1>
</template>

<script>
import HeaderPage from "@/Layouts/HeaderPage";

export default {
    name: "TheShowFind",
    components: {HeaderPage},
    props: ['thefind']
}
</script>

<style scoped>

</style>
