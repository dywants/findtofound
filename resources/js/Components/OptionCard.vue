<template>
    <div 
        class="border rounded-lg p-4 sm:p-6 hover:shadow-lg transition-all duration-300"
        :class="{
            'border-primary-500 bg-primary-50 transform scale-[1.02]': isSelected,
            'animate-fade-in-up': true
        }"
    >
        <div class="flex items-start">
            <input 
                :id="inputId" 
                type="radio" 
                :name="radioGroupName" 
                class="h-4 w-4 sm:h-5 sm:w-5 mt-1 text-primary-600 focus:ring-primary-500 cursor-pointer" 
                :checked="isSelected"
                @change="handleChange"
            />
            <div class="ml-2 sm:ml-3">
                <label :for="inputId" class="heading-5 sm:heading-4 mb-0.5 sm:mb-1">{{ title }}</label>
                <p class="paragraph-xs sm:paragraph-sm text-gray-600 mb-2 sm:mb-3">
                    {{ description }}
                </p>
                <ul v-if="features && features.length" class="space-y-2 sm:space-y-3 pl-0 text-gray-600">
                    <li v-for="(feature, index) in features" :key="index" class="text-xs sm:text-sm leading-normal flex items-start">
                        <span class="inline-flex items-center justify-center w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 rounded-full bg-primary-100 text-primary-700">
                            <Icon :name="getIconForFeature(index).name" size="14" class="text-primary-700" />
                        </span>
                        <span class="relative -top-0.5">{{ feature }}</span>
                    </li>
                </ul>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Icon from './Icon.vue';

const props = defineProps({
    inputId: {
        type: String,
        required: true
    },
    radioGroupName: {
        type: String,
        required: true
    },
    isSelected: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    },
    features: {
        type: Array,
        default: () => []
    },
    optionValue: {
        type: [Boolean, String, Number],
        required: true
    },
    featureIcons: {
        type: Array,
        default: () => []
    }
});

const showRipple = ref(false);
const ripplePosition = ref({ x: 0, y: 0 });
const emit = defineEmits(['update:modelValue']);

const hasCustomIcons = computed(() => {
    return props.featureIcons.length > 0;
});

const getIconForFeature = (index) => {
    if (hasCustomIcons.value && props.featureIcons[index]) {
        return props.featureIcons[index];
    }
    // Icône de coche par défaut
    return {
        name: 'check'
    };
};

const handleChange = (event) => {
    // Effet visuel de sélection
    const rect = event.target.getBoundingClientRect();
    ripplePosition.value = {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
    };
    
    showRipple.value = true;
    setTimeout(() => {
        showRipple.value = false;
    }, 600);
    
    // Émettre l'événement de mise à jour
    emit('update:modelValue', props.optionValue);
};
</script>

<style scoped>
.card-enter-active,
.card-leave-active {
  transition: all 0.3s ease-out;
}

.card-enter-from,
.card-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

li {
  position: relative;
  transition: all 0.2s ease;
}

li:hover {
  transform: translateX(2px);
}

li span.inline-flex {
  transition: all 0.2s ease;
}

li:hover span.inline-flex {
  background-color: var(--color-primary-200);
  transform: scale(1.1);
}
</style>
