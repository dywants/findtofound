<template>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <!-- Section Image -->
            <div v-if="hasImageSection" class="lg:w-1/2">
                <div class="relative h-full">
                    <slot name="imageSection"></slot>
                </div>
            </div>

            <!-- Section Informations -->
            <div :class="hasImageSection ? 'lg:w-1/2' : 'w-full'" class="p-8">
                <div class="space-y-6">
                    <!-- En-tête -->
                    <div v-if="title || subtitle || $slots.header">
                        <slot name="header">
                            <h1 v-if="title" class="text-3xl font-bold text-gray-900">
                                {{ title }}
                            </h1>
                            <div v-if="subtitle" class="mt-4 flex items-center space-x-2 text-gray-500">
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
                        </slot>
                    </div>

                    <!-- Contenu principal -->
                    <slot></slot>

                    <!-- Détails -->
                    <div v-if="description || $slots.description" class="prose prose-blue max-w-none">
                        <slot name="description">
                            <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                            <p class="mt-2 text-gray-600">{{ description }}</p>
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

                    <!-- Actions -->
                    <div v-if="$slots.actions" class="mt-8">
                        <slot name="actions"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "DetailCard",
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
        hasImageSection: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        
    }
}
</script>
