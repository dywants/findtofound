<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
        <div class="p-6">
            <div class="flex items-start">
                <div v-if="iconName" class="flex-shrink-0 bg-blue-100 rounded-full p-3 mr-4">
                    <Icon :name="iconName" class="h-6 w-6 text-blue-600" />
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ title }}</h3>
                    <p class="text-gray-600">
                        <slot></slot>
                    </p>
                    <div v-if="$slots.footer" class="mt-4 pt-4 border-t border-gray-100">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Icon from '@/Components/Icon.vue';

export default {
    name: 'InfoCard',
    components: {
        Icon
    },
    props: {
        title: {
            type: String,
            required: true
        },
        iconName: {
            type: String,
            default: ''
        }
    }
}
</script>
