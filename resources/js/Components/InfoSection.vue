<template>
    <div :class="['border-t border-gray-200 pt-5', containerClass]">
        <div class="flex items-start">
            <!-- Icône -->
            <div v-if="icon" class="flex-shrink-0 mt-1">
                <div :class="['p-2 rounded-lg', iconBgClass]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="iconClass" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon" />
                    </svg>
                </div>
            </div>
            
            <div :class="icon ? 'ml-4 flex-1' : 'flex-1'">
                <!-- Titre et badges -->
                <div class="flex items-center justify-between">
                    <h3 :id="headingId" class="text-lg font-semibold text-gray-900">{{ title }}</h3>
                    <div v-if="badge" 
                         :class="['px-3 py-1 rounded-full text-sm font-medium', badgeClass]"
                         role="status"
                         aria-live="polite">
                        {{ badge }}
                    </div>
                </div>
                
                <!-- Contenu -->
                <div class="mt-2 text-gray-600" :aria-labelledby="headingId">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'InfoSection',
    computed: {
        headingId() {
            // Génère un ID unique pour l'en-tête pour l'accessibilité
            return `info-section-heading-${this._uid}`;
        }
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
        iconClass: {
            type: String,
            default: 'text-blue-600'
        },
        iconBgClass: {
            type: String,
            default: 'bg-blue-50'
        },
        badge: {
            type: String,
            default: ''
        },
        badgeClass: {
            type: String,
            default: 'bg-green-50 text-green-700'
        },
        containerClass: {
            type: String,
            default: ''
        }
    }
}
</script>
