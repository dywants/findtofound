<template>
    <label :for="id" class="inline-flex items-center">
        <input type="radio" :name="name" :value="provider" :id="id" @change="onChange($event)"
               class="h-5 w-5 text-indigo-500 hidden"/>
        <img :src=image alt="" class="object-contain w-20 h-20">
    </label>
</template>

<script>

export default {
    props:{
        image: {
            type: String,
        },
        provider: {
            type: String,
        },
        name: {
            type: String,
        },
        id: {
            type: Number,
        }
    },

    methods: {
         onChange(event) {
            let provider = event.target.value;
            let providerName = event.target.name

            this.$emit('providerValue', provider)
            this.$emit('providerName', providerName)
        }
  }
}


</script>

<style scoped>

</style>
