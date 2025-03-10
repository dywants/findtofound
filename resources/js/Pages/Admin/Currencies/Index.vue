<template>
    <AdminLayout>
        <div class="dashboard-container">
            <!-- En-tête de la page avec titre et boutons d'action -->
            <div class="page-header">
                <div class="title-container">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1>Gestion des devises</h1>
                </div>
                <div class="action-buttons">
                    <Link :href="route('currencies.sync-rates')" method="post" as="button" type="button" class="secondary-button">
                        <span class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </span>
                        <span>Synchroniser les taux</span>
                    </Link>
                    <Link :href="route('currencies.create')" class="primary-button">
                        <span class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </span>
                        <span>Ajouter une devise</span>
                    </Link>
                </div>
            </div>
            
            <!-- Notifications -->
            <div v-if="$page.props.flash && $page.props.flash.success" class="alert success">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p>{{ $page.props.flash.success }}</p>
            </div>
            <div v-if="$page.props.flash && $page.props.flash.error" class="alert error">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <p>{{ $page.props.flash.error }}</p>
            </div>

            <!-- Panneau de recherche -->
            <div class="search-panel">
                <div class="search-input">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input v-model="search" type="text" placeholder="Rechercher une devise..." />
                </div>
            </div>

            <!-- Card contenant la table des devises -->
            <div class="content-card">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="th-code">Code</th>
                                <th class="th-name">Devise</th>
                                <th class="th-rate">Taux de change</th>
                                <th class="th-status">Statut</th>
                                <th class="th-actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="currency in filteredCurrencies" :key="currency.id" class="data-row">
                                <td>
                                    <div class="code-badge" :class="{'default': currency.is_default}">
                                        {{ currency.code }}
                                    </div>
                                </td>
                                <td>
                                    <div class="currency-info">
                                        <div class="symbol">{{ currency.symbol }}</div>
                                        <div class="details">
                                            <div class="name">{{ currency.name }}</div>
                                            <div class="format">Format: {{ currency.format }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="rate-info">
                                        <span class="value">{{ currency.exchange_rate }}</span>
                                        <span class="decimals">({{ currency.decimal_places }} décimales)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="status-badges">
                                        <span :class="[currency.is_active ? 'status-active' : 'status-inactive']">
                                            {{ currency.is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                        <span v-if="currency.is_default" class="status-default">Par défaut</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <Link :href="route('currencies.edit', currency.id)" class="edit-button" title="Modifier">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </Link>
                                        <button 
                                            @click="confirmDelete(currency)" 
                                            class="delete-button" 
                                            title="Supprimer"
                                            :disabled="currency.is_default"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="filteredCurrencies.length === 0">
                                <td colspan="5" class="empty-state-container">
                                    <div class="empty-state">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <p>Aucune devise trouvée</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal de confirmation pour la suppression -->
        <div v-if="deleteModal" class="modal-overlay" @click="cancelDelete">
            <div class="modal-container" @click.stop>
                <div class="modal-header">
                    <h3>Confirmer la suppression</h3>
                    <button @click="cancelDelete" class="close-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-content">
                    <p>Êtes-vous sûr de vouloir supprimer la devise <strong>{{ selectedCurrency ? selectedCurrency.name : '' }}</strong> ?</p>
                    <p class="warning-text">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button @click="cancelDelete" class="cancel-button">Annuler</button>
                    <Link 
                        v-if="selectedCurrency" 
                        :href="route('currencies.destroy', selectedCurrency.id)" 
                        method="delete" 
                        as="button" 
                        class="confirm-button"
                    >
                        Supprimer
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    currencies: Array,
});

// État de la recherche
const search = ref('');

// Filtrer les devises en fonction de la recherche
const filteredCurrencies = computed(() => {
    if (!search.value) return props.currencies;
    
    const searchLower = search.value.toLowerCase();
    return props.currencies.filter(currency => {
        return currency.name.toLowerCase().includes(searchLower)
            || currency.code.toLowerCase().includes(searchLower)
            || currency.symbol.toLowerCase().includes(searchLower);
    });
});

// État de la modal de confirmation de suppression
const deleteModal = ref(false);
const selectedCurrency = ref(null);

// Ouvrir la modal de confirmation de suppression
function confirmDelete(currency) {
    selectedCurrency.value = currency;
    deleteModal.value = true;
}

// Fermer la modal de confirmation de suppression
function cancelDelete() {
    deleteModal.value = false;
    // Réinitialisation après une courte période pour éviter un changement visuel brusque
    setTimeout(() => {
        selectedCurrency.value = null;
    }, 300);
}
</script>

<style scoped>
/* Styles généraux de la page */
.dashboard-container {
    padding: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* En-tête de la page */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.title-container {
    display: flex;
    align-items: center;
}

.title-container h1 {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    color: #1a202c;
}

.icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    background-color: #ebf5ff;
    color: #3182ce;
    margin-right: 0.75rem;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
}

/* Styles des boutons */
.primary-button, .secondary-button, .edit-button, .delete-button, .cancel-button, .confirm-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
}

.primary-button {
    background-color: #3182ce;
    color: white;
}

.primary-button:hover {
    background-color: #2c5282;
}

.secondary-button {
    background-color: #e2e8f0;
    color: #4a5568;
}

.secondary-button:hover {
    background-color: #cbd5e0;
}

.edit-button, .delete-button {
    width: 2rem;
    height: 2rem;
    padding: 0;
    border-radius: 0.25rem;
}

.edit-button {
    background-color: #ebf8ff;
    color: #3182ce;
}

.edit-button:hover {
    background-color: #bee3f8;
}

.delete-button {
    background-color: #fff5f5;
    color: #e53e3e;
}

.delete-button:hover:not([disabled]) {
    background-color: #fed7d7;
}

.delete-button[disabled] {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Styles des alertes */
.alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
}

.alert.success {
    background-color: #f0fff4;
    color: #276749;
    border-left: 4px solid #48bb78;
}

.alert.error {
    background-color: #fff5f5;
    color: #c53030;
    border-left: 4px solid #f56565;
}

/* Panneau de recherche */
.search-panel {
    margin-bottom: 1rem;
}

.search-input {
    display: flex;
    align-items: center;
    max-width: 320px;
    background-color: white;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    padding: 0.5rem 0.75rem;
}

.search-input svg {
    color: #a0aec0;
    margin-right: 0.5rem;
}

.search-input input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 0.875rem;
}

/* Styles de la carte contenant le tableau */
.content-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.table-container {
    overflow-x: auto;
}

/* Styles du tableau de données */
.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.data-table thead tr {
    background-color: #f7fafc;
    border-bottom: 1px solid #e2e8f0;
}

.data-table th {
    padding: 0.75rem 1rem;
    font-weight: 600;
    text-align: left;
    color: #4a5568;
}

.data-table td {
    padding: 1rem;
    border-bottom: 1px solid #edf2f7;
    vertical-align: middle;
}

.data-row:hover {
    background-color: #f7fafc;
}

/* Styles spécifiques aux colonnes */
.th-code {
    width: 10%;
}

.th-name {
    width: 30%;
}

.th-rate {
    width: 25%;
}

.th-status {
    width: 20%;
}

.th-actions {
    width: 15%;
}

/* Styles des éléments dans les cellules */
.code-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    background-color: #edf2f7;
    color: #4a5568;
    border-radius: 0.25rem;
    font-weight: 600;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

.code-badge.default {
    background-color: #3182ce;
    color: white;
}

.currency-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.currency-info .symbol {
    font-size: 1.25rem;
    font-weight: 600;
    color: #3182ce;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #ebf8ff;
    border-radius: 0.25rem;
}

.currency-info .details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.currency-info .name {
    font-weight: 500;
    color: #2d3748;
}

.currency-info .format {
    font-size: 0.75rem;
    color: #718096;
}

.rate-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.rate-info .value {
    font-weight: 500;
    color: #2d3748;
}

.rate-info .decimals {
    font-size: 0.75rem;
    color: #718096;
}

.status-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.status-active, .status-inactive, .status-default {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-active {
    background-color: #c6f6d5;
    color: #276749;
}

.status-inactive {
    background-color: #feebc8;
    color: #c05621;
}

.status-default {
    background-color: #bee3f8;
    color: #2c5282;
}

.row-actions {
    display: flex;
    gap: 0.5rem;
}

/* État vide */
.empty-state-container {
    padding: 2rem;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    color: #718096;
}

.empty-state svg {
    color: #cbd5e0;
    margin-bottom: 1rem;
}

/* Styles de la modal de confirmation */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}

.modal-container {
    background-color: white;
    border-radius: 0.5rem;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.close-button {
    background: none;
    border: none;
    cursor: pointer;
    color: #a0aec0;
    transition: color 0.2s ease;
}

.close-button:hover {
    color: #4a5568;
}

.modal-content {
    padding: 1.5rem;
}

.warning-text {
    color: #718096;
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background-color: #f7fafc;
    border-top: 1px solid #e2e8f0;
}

.cancel-button {
    background-color: #e2e8f0;
    color: #4a5568;
}

.cancel-button:hover {
    background-color: #cbd5e0;
}

.confirm-button {
    background-color: #f56565;
    color: white;
}

.confirm-button:hover {
    background-color: #e53e3e;
}
</style>
