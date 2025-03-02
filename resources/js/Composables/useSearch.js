import { ref, computed, watch } from 'vue';
import Fuse from 'fuse.js';

/**
 * Composable pour gérer la recherche avec Fuse.js
 * 
 * @param {Array} items - Les éléments à rechercher
 * @param {Object} options - Options pour Fuse.js
 * @returns {Object} - Les méthodes et propriétés pour la recherche
 */
export function useSearch(items, options = {}) {
    const searchInput = ref('');
    const term = ref('');
    const isSearching = ref(false);
    const searchTimeout = ref(null);
    const activeFilter = ref('');
    const sortBy = ref('relevance');
    const viewMode = ref('list');
    const recentSearches = ref(
        JSON.parse(localStorage.getItem('recentSearches') || '[]')
    );

    // Configuration par défaut de Fuse.js
    const defaultOptions = {
        threshold: 0.3,
        distance: 100,
        includeScore: true,
        includeMatches: true
    };

    // Initialiser Fuse.js avec les options fusionnées
    const fuse = new Fuse(items, { ...defaultOptions, ...options });

    /**
     * Résultats bruts de la recherche
     */
    const results = computed(() => {
        return term.value ? fuse.search(term.value) : [];
    });

    /**
     * Résultats filtrés par date et triés
     */
    const filteredResults = computed(() => {
        if (!results.value.length) return [];
        
        let filtered = [...results.value];
        
        // Appliquer le filtre de date
        if (activeFilter.value) {
            const now = new Date();
            filtered = filtered.filter(result => {
                const itemDate = new Date(result.item.created_at);
                
                if (activeFilter.value === 'today') {
                    return itemDate.toDateString() === now.toDateString();
                } else if (activeFilter.value === 'week') {
                    const weekAgo = new Date();
                    weekAgo.setDate(now.getDate() - 7);
                    return itemDate > weekAgo;
                } else if (activeFilter.value === 'month') {
                    const monthAgo = new Date();
                    monthAgo.setMonth(now.getMonth() - 1);
                    return itemDate > monthAgo;
                }
                return true;
            });
        }
        
        // Appliquer le tri
        if (sortBy.value === 'dateDesc') {
            filtered.sort((a, b) => new Date(b.item.created_at) - new Date(a.item.created_at));
        } else if (sortBy.value === 'dateAsc') {
            filtered.sort((a, b) => new Date(a.item.created_at) - new Date(b.item.created_at));
        } 
        // Pour 'relevance', on utilise déjà le score de Fuse.js, donc pas besoin de re-trier
        
        return filtered.slice(0, 20); // Limiter à 20 résultats pour la performance
    });

    /**
     * Réinitialiser la recherche
     */
    const reset = () => {
        term.value = null;
        searchInput.value = null;
    };

    /**
     * Recherche avec debounce
     */
    const debouncedSearch = () => {
        isSearching.value = true;
        clearTimeout(searchTimeout.value);
        
        searchTimeout.value = setTimeout(() => {
            term.value = searchInput.value;
            isSearching.value = false;
            
            // Sauvegarder la recherche dans l'historique récent
            if (term.value && term.value.trim()) {
                // Ajouter au début et limiter à 5 recherches
                const updatedSearches = [
                    term.value, 
                    ...recentSearches.value.filter(s => s !== term.value)
                ].slice(0, 5);
                
                recentSearches.value = updatedSearches;
                localStorage.setItem('recentSearches', JSON.stringify(updatedSearches));
                
                // Mettre à jour l'URL pour faciliter le partage
                const url = new URL(window.location);
                url.searchParams.set('q', term.value);
                window.history.pushState({}, '', url);
            }
        }, 300); // Attendre 300ms entre les recherches
    };

    /**
     * Basculer entre les modes d'affichage (liste/grille)
     */
    const toggleView = () => {
        viewMode.value = viewMode.value === 'list' ? 'grid' : 'list';
    };

    /**
     * Formater une date pour l'affichage
     * @param {string} dateString - Date au format ISO
     * @returns {string} - Date formatée
     */
    const formatDate = (dateString) => {
        const options = { day: 'numeric', month: 'short', year: 'numeric' };
        return new Date(dateString).toLocaleDateString('fr-FR', options);
    };

    /**
     * Initialiser avec les paramètres d'URL si disponibles
     */
    const initFromUrl = () => {
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get('q');
        if (searchTerm) {
            searchInput.value = searchTerm;
            term.value = searchTerm;
        }
    };

    // Appeler l'initialisation
    initFromUrl();

    return {
        searchInput,
        term,
        isSearching,
        activeFilter,
        sortBy,
        viewMode,
        recentSearches,
        results,
        filteredResults,
        reset,
        debouncedSearch,
        toggleView,
        formatDate
    };
}
