<template>
    <Head title="Admin - Users"/>

    <HeaderAdmin>
        <template #HeaderAdmin>
            <ul>
                <li>
                    <Link :href="route('admin.index')">Admin</Link>
                </li>
                <li>
                    <Link :href="route('admin.users')">Users</Link>
                </li>
            </ul>
        </template>
    </HeaderAdmin>

    <!-- Main Content Section -->
    <div class="card rounded-lg shadow-md overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-lg bg-white">
        <!-- Card Header with Search -->
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <span class="rounded-full bg-blue-100 p-2 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
                <h2 class="text-xl font-semibold text-gray-800">Gestion des utilisateurs</h2>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <!-- Search Bar -->
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input 
                        v-model="searchQuery" 
                        type="text" 
                        placeholder="Rechercher un utilisateur..." 
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
                    >
                </div>
                
                <!-- Add User Button -->
                <Link :href="route('admin.new.user')" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors duration-200 whitespace-nowrap w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Ajouter</span>
                </Link>
            </div>
        </div>

        <!-- Role Filter Strip -->
        <div class="bg-gray-50 border-b border-gray-100 px-6 py-3 flex flex-wrap gap-2">
            <span 
                @click="selectedRole = null" 
                :class="{'bg-blue-100 text-blue-800': selectedRole === null, 'bg-gray-100 text-gray-600 hover:bg-gray-200': selectedRole !== null}"
                class="px-3 py-1 rounded-full text-sm font-medium cursor-pointer transition-colors duration-200"
            >
                Tous
            </span>
            <span 
                v-for="role in allRoles" 
                :key="role.id" 
                @click="selectedRole = role.name"
                :class="{'bg-blue-100 text-blue-800': selectedRole === role.name, 'bg-gray-100 text-gray-600 hover:bg-gray-200': selectedRole !== role.name}"
                class="px-3 py-1 rounded-full text-sm font-medium cursor-pointer transition-colors duration-200"
            >
                {{ role.name }}
            </span>
            <span 
                @click="selectedRole = 'no-role'" 
                :class="{'bg-blue-100 text-blue-800': selectedRole === 'no-role', 'bg-gray-100 text-gray-600 hover:bg-gray-200': selectedRole !== 'no-role'}"
                class="px-3 py-1 rounded-full text-sm font-medium cursor-pointer transition-colors duration-200"
            >
                Sans rôle
            </span>
        </div>

        <!-- Users List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inscription</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- User Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img 
                                        class="h-10 w-10 rounded-full object-cover border border-gray-200 shadow-sm" 
                                        :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random&color=fff`" 
                                        :alt="user.name">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Email -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ user.email }}</div>
                        </td>
                        
                        <!-- Role -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div v-if="user.roles && user.roles.length > 0" class="flex flex-wrap gap-1">
                                <span 
                                    v-for="role in user.roles" 
                                    :key="role.id"
                                    :class="getRoleBadgeClass(role.name)" 
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full"
                                >
                                    {{ role.name }}
                                </span>
                            </div>
                            <span v-else class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Aucun rôle
                            </span>
                        </td>
                        
                        <!-- Created Date -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex flex-col">
                                <span>{{ formatDateFR(user.created_at) }}</span>
                                <span class="text-xs text-gray-400">{{ formatTimeAgo(user.created_at) }}</span>
                            </div>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex space-x-2">
                                <button class="p-1 rounded-md text-blue-600 hover:bg-blue-50 transition-colors duration-200" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button class="p-1 rounded-md text-red-600 hover:bg-red-50 transition-colors duration-200" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <button class="p-1 rounded-md text-green-600 hover:bg-green-50 transition-colors duration-200" title="Détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Empty state when no users match filter -->
                    <tr v-if="filteredUsers.length === 0" class="text-center">
                        <td colspan="5" class="px-6 py-12 text-gray-500">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-lg">Aucun utilisateur trouvé</p>
                                <p class="text-sm text-gray-400">Modifiez vos critères de recherche ou ajoutez un nouvel utilisateur</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 bg-white border-t border-gray-200 flex items-center justify-between">
            <div class="hidden sm:block">
                <p class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">{{ Math.min(filteredUsers.length, 10) }}</span> sur <span class="font-medium">{{ filteredUsers.length }}</span> utilisateurs
                </p>
            </div>
            <div class="flex-1 flex justify-between sm:justify-end space-x-2">
                <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    Précédent
                </button>
                <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    Suivant
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AdminLayout from "@/Layouts/AdminLayout";
import HeaderAdmin from "@/Layouts/Admin/HeaderAdmin";
import { ref, computed } from 'vue';

export default {
    name: "Index",
    components: { HeaderAdmin, Link },
    props: ['users', 'allRoles'],
    layout: AdminLayout,

    setup(props) {
        // Search functionality
        const searchQuery = ref('');
        
        // Role filtering
        const selectedRole = ref(null);
        
        // Utiliser directement les rôles du système
        const allRoles = computed(() => {
            return props.allRoles || [];
        });
        
        // Filtered users based on search and role selection
        const filteredUsers = computed(() => {
            return props.users.filter(user => {
                // Filter by search query
                const matchesSearch = searchQuery.value === '' || 
                    user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    user.email.toLowerCase().includes(searchQuery.value.toLowerCase());
                
                // Filter by role
                const matchesRole = selectedRole.value === null || 
                    (selectedRole.value === 'no-role' && (!user.roles || user.roles.length === 0)) ||
                    (user.roles && user.roles.some(role => role.name === selectedRole.value));
                
                return matchesSearch && matchesRole;
            });
        });
        
        // Format date to French locale
        function formatDateFR(date) {
            if (!date) return 'N/A';
            const options = { year: 'numeric', month: 'numeric', day: 'numeric' };
            return new Date(date).toLocaleDateString('fr-FR', options);
        }
        
        // Format time ago (e.g., "Il y a 3 jours")
        function formatTimeAgo(dateString) {
            if (!dateString) return '';
            
            const date = new Date(dateString);
            const now = new Date();
            const diffInMs = now - date;
            const diffInSecs = Math.floor(diffInMs / 1000);
            const diffInMins = Math.floor(diffInSecs / 60);
            const diffInHours = Math.floor(diffInMins / 60);
            const diffInDays = Math.floor(diffInHours / 24);
            const diffInMonths = Math.floor(diffInDays / 30);
            const diffInYears = Math.floor(diffInDays / 365);
            
            if (diffInSecs < 60) return 'Il y a quelques secondes';
            if (diffInMins === 1) return 'Il y a 1 minute';
            if (diffInMins < 60) return `Il y a ${diffInMins} minutes`;
            if (diffInHours === 1) return 'Il y a 1 heure';
            if (diffInHours < 24) return `Il y a ${diffInHours} heures`;
            if (diffInDays === 1) return 'Il y a 1 jour';
            if (diffInDays < 30) return `Il y a ${diffInDays} jours`;
            if (diffInMonths === 1) return 'Il y a 1 mois';
            if (diffInMonths < 12) return `Il y a ${diffInMonths} mois`;
            if (diffInYears === 1) return 'Il y a 1 an';
            return `Il y a ${diffInYears} ans`;
        }
        
        // Get CSS classes for role badges
        function getRoleBadgeClass(roleName) {
            const roleClasses = {
                'admin': 'bg-red-100 text-red-800',
                'moderator': 'bg-orange-100 text-orange-800',
                'user': 'bg-blue-100 text-blue-800',
                'subscriber': 'bg-green-100 text-green-800'
            };
            
            // Convert to lowercase for case-insensitive matching
            const normalizedRole = roleName.toLowerCase();
            
            // Return specific role style or default
            return roleClasses[normalizedRole] || 'bg-purple-100 text-purple-800';
        }
        
        return {
            searchQuery,
            selectedRole,
            allRoles,
            filteredUsers,
            formatDateFR,
            formatTimeAgo,
            getRoleBadgeClass
        };
    }
};
</script>

<style scoped>
/* Transition pour les actions sur hover */
.hover-actions {
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

tr:hover .hover-actions {
    opacity: 1;
}

/* Animation pour les badges */
.rounded-full {
    transition: all 0.2s ease;
}

.rounded-full:hover {
    transform: scale(1.05);
}
</style>
