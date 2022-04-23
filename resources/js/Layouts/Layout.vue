<template>
    <Head>
        <title>FindTofound</title>
        <meta type="description" content="Plate-forme de recherche de pièce officiel " head-key="description">
    </Head>
    <div class="flex flex-col min-h-screen">
        <header>
            <TheNavbar />
            <!-- Page Heading -->
            <HeaderPage/>
        </header>
        <!--    <client-only>-->
        <main class="flex-grow">
            <slot />
        </main>
        <!--    </client-only>-->
        <TheFooter />
    </div>
</template>

<script setup>
import TheNavbar from "@/Components/TheNavbar";
import TheFooter from "@/Components/TheFooter";
import HeaderPage from "@/Layouts/HeaderPage";

</script>

<style scoped>

</style>
