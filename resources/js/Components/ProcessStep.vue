<template>
    <div 
        class="border-l-4 border-primary-500 pl-3 sm:pl-4 mb-4 sm:mb-6 transition-all duration-300 hover:pl-4 sm:hover:pl-5 hover:border-primary-600 animate-fade-in"
        :style="{ animationDelay: `${delay * 150}ms` }"
        @mouseenter="isHovered = true"
        @mouseleave="isHovered = false"
    >
        <div class="relative">
            <div class="absolute -left-6 sm:-left-7 -top-1 flex items-center justify-center w-4 sm:w-5 h-4 sm:h-5 rounded-full transition-all" 
                :class="[isHovered ? 'bg-primary-600 scale-125' : 'bg-primary-400']">
                <Icon v-if="icon" :name="icon" :solid="isHovered" size="12" class="text-white" />
            </div>
        </div>
        <h3 class="heading-5 sm:heading-4 mb-1 sm:mb-2">{{ title }}</h3>
        <p class="paragraph-xs sm:paragraph-sm text-gray-600">
            {{ description }}
        </p>
        <div class="mt-2 sm:mt-3 overflow-hidden transition-all duration-300" :class="{'max-h-0': !isExpanded && !isForced, 'max-h-96': isExpanded || isForced}">
            <slot></slot>
        </div>
        <button 
            v-if="!isForced && hasSlotContent" 
            @click="isExpanded = !isExpanded"
            class="text-primary-600 text-xs sm:text-sm font-medium flex items-center mt-2 transition-colors hover:text-primary-700"
        >
            {{ isExpanded ? 'Voir moins' : 'Voir plus' }}
            <Icon name="chevron-down" class="h-3 w-3 sm:h-4 sm:w-4 ml-1 transition-transform" :class="{'rotate-180': isExpanded}" />
        </button>
    </div>
</template>

<script setup>
import { ref, useSlots, computed, onMounted } from 'vue';
import Icon from './Icon.vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    forceExpanded: {
        type: Boolean,
        default: false
    },
    delay: {
        type: Number,
        default: 0
    },
    icon: {
        type: String,
        default: 'check'
    }
});

const slots = useSlots();
const isHovered = ref(false);
const isExpanded = ref(false);

// Vérifier si le slot par défaut contient du contenu
const hasSlotContent = computed(() => {
    return slots.default && slots.default().length > 0;
});

const isForced = computed(() => props.forceExpanded);

onMounted(() => {
    // Appliquer un léger délai avant l'animation
    setTimeout(() => {
        if (isForced.value) {
            isExpanded.value = true;
        }
    }, 300);
});
</script>
