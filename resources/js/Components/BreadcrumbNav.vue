<template>
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <Link :href="route('home')"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                        </path>
                    </svg>
                    Accueil
                </Link>
            </li>
            
            <li v-for="(item, index) in items" :key="index">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    
                    <!-- Si c'est un lien -->
                    <Link v-if="item.href" :href="item.href"
                        class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                        {{ item.label }}
                    </Link>
                    
                    <!-- Si c'est le dernier élément (non cliquable) -->
                    <span v-else class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ item.label }}</span>
                </div>
            </li>
        </ol>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "BreadcrumbNav",
    components: {
        Link
    },
    props: {
        items: {
            type: Array,
            required: true,
            // Structure attendue:
            // [
            //    { label: 'Rechercher une pièce', href: route('found.search') },
            //    { label: 'Nom de la pièce' }  // Sans href pour le dernier élément
            // ]
        }
    }
}
</script>
