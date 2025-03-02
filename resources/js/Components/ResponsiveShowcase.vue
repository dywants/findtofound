<template>
    <div class="responsive-showcase">
        <h2 class="heading-3 mb-6">Adaptabilité mobile</h2>
        
        <section class="mb-8 bg-white p-4 sm:p-6 rounded-lg shadow-sm">
            <h3 class="heading-4 mb-3">Éléments responsifs</h3>
            
            <div class="mb-6">
                <h4 class="heading-5 mb-2">Grille responsive</h4>
                <div class="responsive-grid">
                    <div class="bg-primary-50 p-4 rounded-lg border border-primary-100 text-center">Élément 1</div>
                    <div class="bg-primary-50 p-4 rounded-lg border border-primary-100 text-center">Élément 2</div>
                    <div class="bg-primary-50 p-4 rounded-lg border border-primary-100 text-center">Élément 3</div>
                    <div class="bg-primary-50 p-4 rounded-lg border border-primary-100 text-center">Élément 4</div>
                </div>
            </div>
            
            <div class="mb-6">
                <h4 class="heading-5 mb-2">Typographie responsive</h4>
                <div class="space-y-2 mb-4">
                    <h2 class="heading-1">Titre niveau 1</h2>
                    <h2 class="heading-2">Titre niveau 2</h2>
                    <h3 class="heading-3">Titre niveau 3</h3>
                    <h4 class="heading-4">Titre niveau 4</h4>
                    <h5 class="heading-5">Titre niveau 5</h5>
                </div>
                <div class="space-y-2">
                    <p class="paragraph-lg">Paragraphe large</p>
                    <p class="paragraph-base">Paragraphe normal</p>
                    <p class="paragraph-sm">Petit paragraphe</p>
                    <p class="paragraph-xs">Très petit paragraphe</p>
                </div>
            </div>
            
            <div class="mb-6">
                <h4 class="heading-5 mb-2">Visibilité conditionnelle</h4>
                <div class="space-y-2">
                    <div class="hide-on-mobile p-3 bg-blue-100 rounded-lg text-center">
                        Cet élément n'est visible que sur tablette et desktop
                    </div>
                    <div class="hide-on-desktop p-3 bg-green-100 rounded-lg text-center">
                        Cet élément n'est visible que sur mobile
                    </div>
                    <div class="hide-on-tablet p-3 bg-purple-100 rounded-lg text-center">
                        Cet élément est masqué sur les tablettes
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <h4 class="heading-5 mb-2">Formulaire responsive</h4>
                <form class="space-y-4">
                    <div class="form-group">
                        <label class="paragraph-sm font-medium mb-1 block">Nom complet</label>
                        <input type="text" class="w-full border border-gray-300 rounded-lg p-2 sm:p-3" placeholder="Votre nom">
                    </div>
                    
                    <div class="form-group">
                        <label class="paragraph-sm font-medium mb-1 block">Email</label>
                        <input type="email" class="w-full border border-gray-300 rounded-lg p-2 sm:p-3" placeholder="votre@email.com">
                    </div>
                    
                    <div class="input-group flex flex-col sm:flex-row sm:items-center gap-2">
                        <input type="text" class="flex-1 border border-gray-300 rounded-lg p-2 sm:p-3" placeholder="Code postal">
                        <input type="text" class="flex-1 border border-gray-300 rounded-lg p-2 sm:p-3" placeholder="Ville">
                    </div>
                    
                    <div class="mt-4">
                        <button class="button primary">Soumettre</button>
                    </div>
                </form>
            </div>
            
            <div>
                <h4 class="heading-5 mb-2">Images responsives</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="paragraph-sm mb-2">Image cover</p>
                        <div class="h-40 bg-gray-100 rounded-lg overflow-hidden">
                            <img src="https://picsum.photos/600/400" alt="Exemple" class="img-responsive">
                        </div>
                    </div>
                    <div>
                        <p class="paragraph-sm mb-2">Image contain</p>
                        <div class="h-40 bg-gray-100 rounded-lg overflow-hidden">
                            <img src="https://picsum.photos/400/600" alt="Exemple" class="img-responsive contain">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <div class="text-center paragraph-sm text-gray-600 mt-8">
            Redimensionnez la fenêtre pour observer l'adaptabilité des éléments à différentes tailles d'écran
        </div>
    </div>
</template>

<script setup>
// Ce composant est uniquement pour la démonstration des fonctionnalités responsive
</script>

<style scoped>
.responsive-showcase section {
    border: 1px solid #e5e7eb;
}
</style>
