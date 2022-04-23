<template>
    <section class="shadow max-w-5xl bg-amber-50 mx-auto mt-8 p-6 rounded-md">
        <div class="card-body mb-4">
            <slot name="body"/>
        </div>
        <div class="footer flex justify-end">
            <slot name="footer"/>
        </div>
    </section>
</template>

<script>
export default {
    name: "TheCard"
}
</script>

<style scoped>

</style>
