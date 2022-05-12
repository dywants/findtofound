<template>
    <Dashboard>
        <!-- component -->
        <div class="h-full bg-gradient-to-r from-neutral-400 via-neutral-200 to-white">
            <div class="grid grid-cols-12 gap-0">
                <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8 xxl:col-span-8 px-6 py-6">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200 block">
                                <h1>Bienvenue, <em class="text-[17px] font-semibold text-gray-700">{{
                                        $page.props.auth.user.name
                                    }}</em></h1>
                                <div v-if="$page.props.flash.message" class="text-[14px] text-gray-600 ">
                                    Votre mot de passe est: <em class="font-semibold">{{
                                        $page.props.flash.message
                                    }}</em>
                                </div>

                                <div v-if="$page.props.flash.success" class="mb-4 font-medium text-sm text-green-600">
                                    {{ $page.props.flash.success }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-4 xxl:col-span-4 px-6 py-6">
                    <!-- Start profile Card -->
                    <div class="bg-white rounded-xl p-4 shadow-xl">
                        <div class="flex flex-col justify-center items-center">
                            <div class="w-full bg-cover bg-center h-32">
                                <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center justify-center">
                                    <div>
                                        <h3 class="text-center text-lg">
                                            Solde à percevoir
                                        </h3>
                                        <h3 class="text-center text-3xl mt-2 font-bold">
                                            RM 2000.00
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-xl mt-4">
                        <div class="flex flex-col justify-center items-center">
                            <div class="w-full bg-cover bg-center h-32">
                                <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center justify-center">
                                    <div>
                                        <h3 class="text-center text-lg">
                                            Solde presumé à percevoir
                                        </h3>
                                        <h3  class="text-center text-3xl mt-2 font-bold">
                                            {{ total_amount.formatted }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Dashboard>
</template>

<script setup>
import Dashboard from '@/Pages/Dashboard'

let props = defineProps({
    total_amount: Object,
});
</script>

<style scoped>

</style>
