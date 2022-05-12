<template>
    <section class="shadow-md max-w-5xl bg-white mx-auto mt-8 p-6 rounded-md">
        <div class="navStep">
            <slot name="nav"/>
        </div>
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
