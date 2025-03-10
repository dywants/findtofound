<template>
    <footer class="border-gray-200 border-t p-4 bg-tahiti-dark rounded-lg shadow md:px-6 md:py-8">
        <div class="max-w-screen-xl p-4 mx-auto">
            <div class="sm:flex sm:items-center sm:justify-between">
                <TheLogo />
                <ul class="flex flex-wrap items-center mb-6 text-sm text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6 ">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8">
        <div class="sm:flex sm:items-center sm:justify-between text-sm text-gray-500">
            <p class="mb-4 sm:mb-0">&copy; {{ new Date().getFullYear() }} DocuTrace . Tous droits réservés.</p>
            
            <!-- Sélecteur de devises -->
            <div class="flex items-center justify-center sm:justify-end">
                <span class="mr-2">Devise:</span>
                <CurrencySelector />
            </div>
        </div>
    </footer>
</template>

<script setup>
import TheLogo from "@/Components/TheLogo";
import CurrencySelector from "@/Components/CurrencySelector";
</script>

<style scoped></style>
