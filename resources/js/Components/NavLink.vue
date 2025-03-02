<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  href: {
    type: String,
    required: true
  },
  active: {
    type: Boolean,
    default: false
  }
})

const classes = computed(() => {
  return props.active
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-gray-200 focus:outline-none focus:text-gray-200 transition duration-150 ease-in-out'
})

</script>

<template>
  <Link v-if="href" :href="href" :class="classes">
    <slot />
  </Link>
  <span v-else :class="classes">
    <slot />
  </span>
</template>
