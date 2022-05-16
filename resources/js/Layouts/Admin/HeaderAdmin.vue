<template>
    <header class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
            <slot name="HeaderAdmin"/>
        </div>
    </header>
</template>

<script>
export default {
    name: "HeaderAdmin"
}
</script>

<style scoped>

</style>
