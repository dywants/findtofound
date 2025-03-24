<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
        <div class="p-6">
            <div class="flex items-start">
                <div v-if="icon" 
                    class="flex-shrink-0 rounded-full p-3 mr-4"
                    :class="{
                        'bg-blue-100 text-blue-600': color === 'blue' || !color,
                        'bg-green-100 text-green-600': color === 'green',
                        'bg-red-100 text-red-600': color === 'red',
                        'bg-amber-100 text-amber-600': color === 'amber',
                        'bg-purple-100 text-purple-600': color === 'purple',
                        'bg-indigo-100 text-indigo-600': color === 'indigo',
                        'bg-teal-100 text-teal-600': color === 'teal',
                    }">
                    <Icon :name="icon" class="h-6 w-6" />
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
                        <div v-if="value" class="text-2xl font-bold"
                            :class="{
                                'text-blue-600': color === 'blue' || !color,
                                'text-green-600': color === 'green',
                                'text-red-600': color === 'red',
                                'text-amber-600': color === 'amber',
                                'text-purple-600': color === 'purple',
                                'text-indigo-600': color === 'indigo',
                                'text-teal-600': color === 'teal',
                            }">
                            {{ value }}
                        </div>
                    </div>
                    <p class="text-gray-600" v-if="$slots.default">
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
        icon: {
            type: String,
            default: ''
        },
        iconName: {
            type: String,
            default: ''
        },
        value: {
            type: String,
            default: ''
        },
        color: {
            type: String,
            default: 'blue',
            validator: (value) => [
                'blue', 'green', 'red', 'amber', 
                'purple', 'indigo', 'teal'
            ].includes(value)
        }
    },
    computed: {
        // Pour la rétrocompatibilité
        iconToUse() {
            return this.icon || this.iconName;
        }
    }
}
</script>
