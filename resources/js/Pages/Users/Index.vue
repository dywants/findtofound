<template>
    <Dashboard>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 block">
                        <h1>Bienvenue, <em class="text-[17px] font-semibold text-gray-700">{{ $page.props.auth.user.name }}</em></h1>
                        <div v-if="$page.props.flash.message" class="text-[14px] text-gray-600 ">
                            Votre mot de passe est: <em class="font-semibold">{{ $page.props.flash.message }}</em>
                        </div>

                        <div v-if="$page.props.flash.success" class="mb-4 font-medium text-sm text-green-600">
                            {{ $page.props.flash.success }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Pages/Dashboard'
</script>

<style scoped>

</style>
