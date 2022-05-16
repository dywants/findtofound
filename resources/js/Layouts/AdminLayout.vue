<template>
    <div class="app">
        <TheNavAdmin />
        <Aside/>
        <main class="section main-section">
            <slot/>
        </main>
    </div>
</template>

<script>
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import Aside from "@/Layouts/Admin/Aside";
import TheNavAdmin from "@/Layouts/Admin/TheNavAdmin";
import {ref} from "vue";
export default {
    name: "AdminLayout",
    components: {TheNavAdmin, HeaderAdmin,Aside},

    setup(){
        const showingNavigationDropdown = ref(false);
    }
}
</script>

<style scoped>

</style>
