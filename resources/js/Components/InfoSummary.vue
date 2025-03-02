<template>
    <div class="border-b border-gray-200 bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="p-6">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Résumé de vos informations</h2>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100">
                <dl class="space-y-4">
                    <div v-for="(item, index) in items" :key="index" 
                         class="grid grid-cols-1 md:grid-cols-6 gap-1 p-2 hover:bg-gray-50 rounded-md transition-colors duration-200"
                    >
                        <dt class="md:col-span-2 flex items-center space-x-2 text-sm text-gray-600">
                            <div class="flex-shrink-0">
                                <component 
                                    :is="getIconComponent(item.label)" 
                                    class="w-4 h-4 text-indigo-500"
                                />
                            </div>
                            <span>{{ item.label }}</span>
                        </dt>
                        <dd class="md:col-span-4 text-sm font-medium text-gray-900 break-words">
                            {{ item.value }}
                        </dd>
                    </div>
                </dl>
            </div>
            
            <div class="mt-4 text-center">
                <div class="text-xs text-gray-500 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Vérifiez que ces informations sont correctes avant de procéder au paiement</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, h } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        required: true,
        // Format attendu: [{ label: 'Nom', value: 'John Doe' }, ...]
    }
});

// Fonction pour obtenir l'icône appropriée en fonction du label
const getIconComponent = (label) => {
    const iconMap = {
        'Nom': () => h('svg', { 
            fill: 'none', 
            stroke: 'currentColor',
            viewBox: '0 0 24 24',
            xmlns: 'http://www.w3.org/2000/svg'
        }, [
            h('path', { 
                'stroke-linecap': 'round', 
                'stroke-linejoin': 'round', 
                'stroke-width': '2', 
                d: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'
            })
        ]),
        'Email': () => h('svg', { 
            fill: 'none', 
            stroke: 'currentColor',
            viewBox: '0 0 24 24',
            xmlns: 'http://www.w3.org/2000/svg'
        }, [
            h('path', { 
                'stroke-linecap': 'round', 
                'stroke-linejoin': 'round', 
                'stroke-width': '2', 
                d: 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'
            })
        ]),
        'Téléphone': () => h('svg', { 
            fill: 'none', 
            stroke: 'currentColor',
            viewBox: '0 0 24 24',
            xmlns: 'http://www.w3.org/2000/svg'
        }, [
            h('path', { 
                'stroke-linecap': 'round', 
                'stroke-linejoin': 'round', 
                'stroke-width': '2', 
                d: 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'
            })
        ]),
        'Ville': () => h('svg', { 
            fill: 'none', 
            stroke: 'currentColor',
            viewBox: '0 0 24 24',
            xmlns: 'http://www.w3.org/2000/svg'
        }, [
            h('path', { 
                'stroke-linecap': 'round', 
                'stroke-linejoin': 'round', 
                'stroke-width': '2', 
                d: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'
            })
        ])
    };
    
    // Icône par défaut si le label n'est pas dans la map
    return iconMap[label] || (() => h('svg', { 
        fill: 'none', 
        stroke: 'currentColor',
        viewBox: '0 0 24 24',
        xmlns: 'http://www.w3.org/2000/svg'
    }, [
        h('path', { 
            'stroke-linecap': 'round', 
            'stroke-linejoin': 'round', 
            'stroke-width': '2', 
            d: 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z'
        })
    ]));
};
</script>
