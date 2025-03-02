<template>
    <div class="button-showcase">
        <h2 class="heading-3 mb-6">Showcase des boutons</h2>
        
        <section class="mb-8">
            <h3 class="heading-4 mb-4">Styles de base</h3>
            <div class="flex flex-wrap gap-4">
                <button class="button primary">Bouton principal</button>
                <button class="button secondary">Bouton secondaire</button>
                <button class="button accent">Bouton accent</button>
                <button class="button success">Bouton succès</button>
                <button class="button warning">Bouton avertissement</button>
                <button class="button error">Bouton erreur</button>
            </div>
        </section>
        
        <section class="mb-8">
            <h3 class="heading-4 mb-4">Variantes outline</h3>
            <div class="flex flex-wrap gap-4">
                <button class="button primary outline">Principal outline</button>
                <button class="button secondary outline">Secondaire outline</button>
            </div>
        </section>
        
        <section class="mb-8">
            <h3 class="heading-4 mb-4">Tailles</h3>
            <div class="flex flex-wrap items-center gap-4">
                <button class="button primary xs">XS</button>
                <button class="button primary sm">SM</button>
                <button class="button primary">Défaut</button>
                <button class="button primary lg">Large</button>
                <button class="button primary xl">Extra large</button>
            </div>
        </section>
        
        <section class="mb-8">
            <h3 class="heading-4 mb-4">États</h3>
            <div class="flex flex-wrap gap-4">
                <button class="button primary">Normal</button>
                <button class="button primary disabled" disabled>Désactivé</button>
                <button class="button primary loading">Chargement</button>
                <button class="button primary loading dots">Chargement (dots)</button>
            </div>
        </section>
        
        <section class="mb-8">
            <h3 class="heading-4 mb-4">Boutons avec icônes</h3>
            <div class="flex flex-wrap gap-4">
                <button class="button primary with-icon icon-left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    Icône gauche
                </button>
                <button class="button secondary with-icon icon-right">
                    Icône droite
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </section>
        
        <section class="mb-8">
            <h3 class="heading-4 mb-4">Boutons avec animations</h3>
            <div class="flex flex-wrap gap-4">
                <button class="button primary ripple">Effet ripple</button>
                <button class="button primary with-bounce">Effet rebond</button>
                <button class="button primary with-shake">Effet secousse</button>
                <button class="button primary pulse">Effet pulse</button>
                <button class="button primary fade-in">Fade in</button>
            </div>
        </section>
        
        <section class="mb-8">
            <h3 class="heading-4 mb-4">Boutons circulaires</h3>
            <div class="flex flex-wrap items-center gap-4">
                <button class="button primary circle sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="button primary circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="button primary circle lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </section>
    </div>
</template>

<script setup>
// Ce composant est uniquement pour la démonstration des styles de boutons
</script>

<style scoped>
.button-showcase section {
    background-color: rgba(0, 0, 0, 0.02);
    border-radius: 0.5rem;
    padding: 1.5rem;
}
</style>
