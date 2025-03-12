<template>
  <div>
    <AdminLayout>
      <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 class="text-2xl font-semibold text-gray-900 mb-6">Gestion des rôles utilisateurs</h1>
          
          <!-- Alerte pour les messages de succès ou d'erreur -->
          <div v-if="$page.props.flash.success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ $page.props.flash.success }}</p>
          </div>
          <div v-if="$page.props.flash.error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ $page.props.flash.error }}</p>
          </div>
          
          <!-- Tableau des utilisateurs et leurs rôles -->
          <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
              <h2 class="text-lg leading-6 font-medium text-gray-900">Liste des utilisateurs</h2>
            </div>
            
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôles</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="user in users" :key="user.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <img class="h-10 w-10 rounded-full" :src="user.avatar || 'https://via.placeholder.com/40'" alt="">
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ user.email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex flex-wrap gap-1">
                        <span v-for="role in user.roles" :key="role.id" 
                              class="px-2 py-1 text-xs font-medium rounded-full"
                              :class="role.name === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'">
                          {{ role.name }}
                        </span>
                        <span v-if="user.roles.length === 0" class="text-gray-500 text-sm">Aucun rôle</span>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <div class="flex space-x-2">
                        <template v-if="!hasRole(user, 'admin')">
                          <Link :href="route('admin.users.make-admin', user.id)" method="post" as="button" 
                                class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-sm">
                            Promouvoir admin
                          </Link>
                        </template>
                        <template v-else>
                          <Link :href="route('admin.users.remove-admin', user.id)" method="post" as="button" 
                                class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-sm">
                            Retirer admin
                          </Link>
                        </template>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </AdminLayout>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

export default {
  components: {
    AdminLayout,
    Link
  },
  
  props: {
    users: Array,
    roles: Array
  },
  
  methods: {
    hasRole(user, roleName) {
      return user.roles.some(role => role.name === roleName);
    }
  }
}
</script>
