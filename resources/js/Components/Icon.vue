<template>
    <svg 
        :width="size" 
        :height="size" 
        viewBox="0 0 24 24" 
        :class="computedClass"
        fill="none" 
        xmlns="http://www.w3.org/2000/svg"
        role="img"
        :aria-label="name"
        stroke="currentColor"
    >
        <title v-if="showTitle">{{ name }}</title>
        
        <!-- Check Icon -->
        <path v-if="name === 'check' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M5 13l4 4L19 7" 
        />
        <path v-if="name === 'check' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
            clip-rule="evenodd" 
        />
        
        <!-- User Icon -->
        <path v-if="name === 'user' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" 
        />
        <path v-if="name === 'user' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" 
            clip-rule="evenodd" 
        />
        
        <!-- Document Icon -->
        <path v-if="name === 'document' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" 
        />
        <path v-if="name === 'document' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" 
            clip-rule="evenodd" 
        />
        
        <!-- Search Icon -->
        <path v-if="name === 'search' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" 
        />
        <path v-if="name === 'search' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" 
            clip-rule="evenodd" 
        />
        
        <!-- Map Pin Icon -->
        <template v-if="name === 'map-pin' && !solid">
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" 
            />
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" 
            />
        </template>
        <path v-if="name === 'map-pin' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M5.05 4.05a7 7 0 119.9 9.9l-4.95 4.95a.999.999 0 01-1.414 0l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" 
            clip-rule="evenodd" 
        />
        
        <!-- Bell Icon -->
        <path v-if="name === 'bell' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" 
        />
        <path v-if="name === 'bell' && solid" 
            fill="currentColor"
            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" 
        />
        
        <!-- Chevron Down Icon -->
        <path v-if="name === 'chevron-down' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M19 9l-7 7-7-7" 
        />
        <path v-if="name === 'chevron-down' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" 
            clip-rule="evenodd" 
        />
        
        <!-- Chevron Right Icon -->
        <path v-if="name === 'chevron-right' && !solid" 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M9 5l7 7-7 7" 
        />
        <path v-if="name === 'chevron-right' && solid" 
            fill="currentColor"
            fill-rule="evenodd" 
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" 
            clip-rule="evenodd" 
        />
        
        <!-- Fallback pour les icônes non définies -->
        <g v-if="!hasIcon">
            <rect width="24" height="24" fill="none" stroke="currentColor" stroke-width="1" rx="4"></rect>
            <text x="12" y="16" font-size="8" text-anchor="middle" fill="currentColor">{{ name }}</text>
        </g>
    </svg>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true
    },
    size: {
        type: [Number, String],
        default: 24
    },
    color: {
        type: String,
        default: 'currentColor'
    },
    solid: {
        type: Boolean,
        default: false
    },
    customClass: {
        type: String,
        default: ''
    },
    showTitle: {
        type: Boolean,
        default: false
    }
});

// Classes CSS calculées
const computedClass = computed(() => {
    return [
        'icon',
        `icon-${props.name}`,
        {
            'icon-solid': props.solid,
        },
        props.customClass
    ];
});

// Vérifie si l'icône existe
const hasIcon = computed(() => {
    const iconName = props.name.toLowerCase();
    return ['check', 'user', 'document', 'search', 'map-pin', 'bell', 'chevron-down', 'chevron-right'].includes(iconName);
});
</script>

<style>
.icon {
    display: inline-block;
    stroke: currentColor;
    fill: none;
    vertical-align: middle;
    transition: transform 0.2s ease;
}

.icon-solid {
    fill: currentColor;
    stroke: none;
}

.icon.spin {
    animation: spin 1s linear infinite;
}

.icon.pulse {
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
