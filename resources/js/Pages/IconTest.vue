<template>
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-6">Test des icônes</h1>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Icônes outline -->
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="check" size="24" class="mb-2" />
                <span class="text-sm">check</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="user" size="24" class="mb-2" />
                <span class="text-sm">user</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="document" size="24" class="mb-2" />
                <span class="text-sm">document</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="search" size="24" class="mb-2" />
                <span class="text-sm">search</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="map-pin" size="24" class="mb-2" />
                <span class="text-sm">map-pin</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="bell" size="24" class="mb-2" />
                <span class="text-sm">bell</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="chevron-down" size="24" class="mb-2" />
                <span class="text-sm">chevron-down</span>
            </div>
            
            <!-- Icônes solid -->
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="check" solid size="24" class="mb-2" />
                <span class="text-sm">check (solid)</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="user" solid size="24" class="mb-2" />
                <span class="text-sm">user (solid)</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="document" solid size="24" class="mb-2" />
                <span class="text-sm">document (solid)</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="search" solid size="24" class="mb-2" />
                <span class="text-sm">search (solid)</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="map-pin" solid size="24" class="mb-2" />
                <span class="text-sm">map-pin (solid)</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="bell" solid size="24" class="mb-2" />
                <span class="text-sm">bell (solid)</span>
            </div>
            
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="chevron-down" solid size="24" class="mb-2" />
                <span class="text-sm">chevron-down (solid)</span>
            </div>
            
            <!-- Test d'une icône non définie -->
            <div class="p-4 border rounded-lg flex flex-col items-center">
                <Icon name="non-existent" size="24" class="mb-2" />
                <span class="text-sm">non-existent</span>
            </div>
        </div>
        
        <!-- Test avec OptionCard -->
        <h2 class="text-xl font-bold mt-8 mb-4">Test avec OptionCard</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <OptionCard
                inputId="test-card"
                radioGroupName="test-group"
                :isSelected="true"
                title="Carte de test"
                description="Cette carte est utilisée pour tester l'affichage des icônes dans OptionCard."
                :features="[
                    'Fonctionnalité 1',
                    'Fonctionnalité 2',
                    'Fonctionnalité 3',
                    'Fonctionnalité 4'
                ]"
                :optionValue="true"
            />
            
            <OptionCard
                inputId="test-card-custom"
                radioGroupName="test-group"
                :isSelected="false"
                title="Carte avec icônes personnalisées"
                description="Cette carte utilise des icônes personnalisées pour les fonctionnalités."
                :features="[
                    'Fonctionnalité avec user',
                    'Fonctionnalité avec document',
                    'Fonctionnalité avec search',
                    'Fonctionnalité avec bell'
                ]"
                :featureIcons="[
                    { name: 'user' },
                    { name: 'document' },
                    { name: 'search' },
                    { name: 'bell' }
                ]"
                :optionValue="false"
            />
        </div>
    </div>
</template>

<script setup>
import Icon from "@/Components/Icon.vue";
import OptionCard from "@/Components/OptionCard.vue";
</script>
