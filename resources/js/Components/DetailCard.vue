<template>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
        <div class="flex flex-col lg:flex-row">
            <!-- Section Image -->
            <div v-if="hasImageSection && !icon" class="lg:w-1/2">
                <div class="relative h-full">
                    <slot name="imageSection"></slot>
                </div>
            </div>

            <!-- Section Informations -->
            <div :class="hasImageSection && !icon ? 'lg:w-1/2' : 'w-full'" class="p-8">
                <div class="space-y-6">
                    <!-- En-tête -->
                    <div v-if="title || subtitle || $slots.header || icon">
                        <slot name="header">
                            <div class="flex items-start">
                                <div v-if="icon" class="mr-4 p-2 bg-indigo-50 rounded-lg">
                                    <Icon :name="icon" class="h-8 w-8 text-indigo-600" />
                                </div>
                                <div class="flex-1">
                                    <h1 v-if="title" class="text-xl font-bold text-gray-900">
                                        {{ title }}
                                    </h1>
                                    <div v-if="subtitle" class="mt-2 flex items-center space-x-2 text-gray-500">
                                        <slot name="subtitleIcon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </slot>
                                        <span>{{ subtitle }}</span>
                                    </div>
                                </div>
                            </div>
                        </slot>
                    </div>

                    <!-- Contenu principal -->
                    <slot></slot>

                    <!-- Détails -->
                    <div v-if="description || $slots.description" class="prose prose-blue max-w-none">
                        <slot name="description">
                            <p class="text-gray-600">{{ description }}</p>
                        </slot>
                    </div>

                    <!-- Information supplémentaire -->
                    <slot name="additionalInfo"></slot>

                    <!-- Prix / Montant -->
                    <div v-if="amount || $slots.amount" class="border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-gray-900">Montant de la récompense</span>
                            <slot name="amount">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold bg-green-50 text-green-700">
                                    {{ amount }}
                                </span>
                            </slot>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div v-if="actionText || actionLink || $slots.actions" class="mt-6">
                        <slot name="actions">
                            <Link v-if="actionText && actionLink" :href="actionLink" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ actionText }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </Link>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Icon from '@/Components/Icon.vue';

export default {
    name: "DetailCard",
    components: {
        Link,
        Icon
    },
    props: {
        title: {
            type: String,
            default: ''
        },
        subtitle: {
            type: String,
            default: ''
        },
        description: {
            type: String,
            default: ''
        },
        amount: {
            type: String,
            default: ''
        },
        icon: {
            type: String,
            default: ''
        },
        actionText: {
            type: String,
            default: ''
        },
        actionLink: {
            type: [String, Object],
            default: ''
        },
        hasImageSection: {
            type: Boolean,
            default: true
        }
    }
}
</script>
