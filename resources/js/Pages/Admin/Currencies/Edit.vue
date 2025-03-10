<template>
    <AdminLayout>
        <div class="dashboard-container">
            <!-- En-tête de la page avec titre et navigation retour -->
            <div class="page-header">
                <div class="title-container">
                    <div class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h1>Modifier la devise</h1>
                </div>
                <div class="navigation">
                    <Link :href="route('currencies.index')" class="back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Retour à la liste</span>
                    </Link>
                </div>
            </div>

            <!-- Formulaire d'édition de devise -->
            <div class="content-card">
                <form @submit.prevent="submit" class="currency-form">
                    <div class="form-section">
                        <h2 class="section-title">Informations générales</h2>
                        
                        <div class="form-grid">
                            <!-- Nom de la devise -->
                            <div class="form-group">
                                <label for="name" class="form-label">Nom <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input 
                                        type="text" 
                                        id="name" 
                                        v-model="form.name" 
                                        class="form-input" 
                                        :class="{'error': errors.name}" 
                                        required 
                                        placeholder="Euro, Dollar américain, etc."
                                    >
                                </div>
                                <p v-if="errors.name" class="error-message">{{ errors.name }}</p>
                            </div>

                            <!-- Code de la devise -->
                            <div class="form-group">
                                <label for="code" class="form-label">Code <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input 
                                        type="text" 
                                        id="code" 
                                        v-model="form.code" 
                                        class="form-input" 
                                        :class="{'error': errors.code}" 
                                        required 
                                        placeholder="EUR, USD, etc."
                                    >
                                </div>
                                <p v-if="errors.code" class="error-message">{{ errors.code }}</p>
                            </div>

                            <!-- Symbole de la devise -->
                            <div class="form-group">
                                <label for="symbol" class="form-label">Symbole <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input 
                                        type="text" 
                                        id="symbol" 
                                        v-model="form.symbol" 
                                        class="form-input" 
                                        :class="{'error': errors.symbol}" 
                                        required 
                                        placeholder="€, $, etc."
                                    >
                                </div>
                                <p v-if="errors.symbol" class="error-message">{{ errors.symbol }}</p>
                            </div>

                            <!-- Format d'affichage -->
                            <div class="form-group">
                                <label for="format" class="form-label">Format d'affichage <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input 
                                        type="text" 
                                        id="format" 
                                        v-model="form.format" 
                                        class="form-input" 
                                        :class="{'error': errors.format}" 
                                        required 
                                        placeholder="%s %v"
                                    >
                                    <div class="help-text">%s = symbole, %v = valeur (ex: "%s %v" pour "€ 10.00" ou "%v %s" pour "10.00 €")</div>
                                </div>
                                <p v-if="errors.format" class="error-message">{{ errors.format }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="section-title">Paramètres de conversion</h2>
                        
                        <div class="form-grid">
                            <!-- Taux de change -->
                            <div class="form-group">
                                <label for="exchange_rate" class="form-label">Taux de change <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input 
                                        type="number" 
                                        id="exchange_rate" 
                                        v-model="form.exchange_rate" 
                                        class="form-input" 
                                        :class="{'error': errors.exchange_rate}" 
                                        step="0.000001" 
                                        required 
                                        placeholder="1.0"
                                        :disabled="form.is_default"
                                    >
                                    <div class="help-text">Taux par rapport à la devise par défaut. Utilisez 1.0 pour la devise par défaut.</div>
                                </div>
                                <p v-if="errors.exchange_rate" class="error-message">{{ errors.exchange_rate }}</p>
                            </div>

                            <!-- Nombre de décimales -->
                            <div class="form-group">
                                <label for="decimal_places" class="form-label">Nombre de décimales <span class="required">*</span></label>
                                <div class="input-wrapper">
                                    <input 
                                        type="number" 
                                        id="decimal_places" 
                                        v-model="form.decimal_places" 
                                        class="form-input" 
                                        :class="{'error': errors.decimal_places}" 
                                        min="0" 
                                        max="6" 
                                        required
                                    >
                                    <div class="help-text">Nombre de chiffres après la virgule (généralement 2).</div>
                                </div>
                                <p v-if="errors.decimal_places" class="error-message">{{ errors.decimal_places }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="section-title">Options</h2>
                        
                        <div class="form-options">
                            <!-- Activer la devise -->
                            <div class="checkbox-group">
                                <label class="checkbox-container">
                                    <input type="checkbox" v-model="form.is_active" :disabled="form.is_default">
                                    <div class="checkbox-custom"></div>
                                    <span>Devise active</span>
                                </label>
                                <p v-if="form.is_default" class="help-text">La devise par défaut doit toujours être active.</p>
                            </div>

                            <!-- Définir comme devise par défaut -->
                            <div class="checkbox-group">
                                <label class="checkbox-container">
                                    <input type="checkbox" v-model="form.is_default" @change="handleDefaultChange">
                                    <div class="checkbox-custom"></div>
                                    <span>Devise par défaut</span>
                                </label>
                                <div v-if="!form.is_default" class="help-text default-help">
                                    Si vous définissez cette devise comme devise par défaut, toutes les autres devises perdront ce statut.
                                </div>
                                <div v-else class="help-text default-help">
                                    Cette devise est actuellement définie comme devise par défaut. Tous les taux de change sont relatifs à cette devise.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="primary-button" :class="{'loading': form.processing}">
                            <span v-if="!form.processing">Mettre à jour</span>
                            <span v-else>Traitement en cours...</span>
                        </button>
                        <Link :href="route('currencies.index')" class="secondary-button">Annuler</Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { watch } from 'vue';

const props = defineProps({
    currency: Object,
    errors: Object,
});

const form = useForm({
    name: props.currency.name,
    code: props.currency.code,
    symbol: props.currency.symbol,
    exchange_rate: props.currency.exchange_rate,
    decimal_places: props.currency.decimal_places || 2,
    format: props.currency.format || '%s %v',
    is_active: props.currency.is_active,
    is_default: props.currency.is_default,
});

// Si c'est la devise par défaut, s'assurer qu'elle reste active
watch(() => form.is_default, (value) => {
    if (value) {
        form.is_active = true;
        form.exchange_rate = 1.0;
    }
});

const handleDefaultChange = (e) => {
    if (form.is_default) {
        form.exchange_rate = 1.0;
        form.is_active = true;
    }
};

const submit = () => {
    form.put(route('currencies.update', props.currency.id));
};
</script>

<style scoped>
/* Styles généraux de la page */
.dashboard-container {
    padding: 1.5rem;
    max-width: 1200px;
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

.navigation {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.back-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.2s ease;
}

.back-link:hover {
    color: #3182ce;
}

.back-link svg {
    width: 1rem;
    height: 1rem;
}

/* Carte de contenu */
.content-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    overflow: hidden;
    padding: 1.5rem;
}

/* Formulaire */
.currency-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-section {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #edf2f7;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #4a5568;
}

.required {
    color: #e53e3e;
}

.input-wrapper {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.form-input {
    padding: 0.625rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: #3182ce;
    box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.15);
}

.form-input.error {
    border-color: #e53e3e;
}

.form-input:disabled {
    background-color: #f7fafc;
    cursor: not-allowed;
}

.error-message {
    font-size: 0.75rem;
    color: #e53e3e;
    margin: 0;
}

.help-text {
    font-size: 0.75rem;
    color: #718096;
}

/* Options de formulaire */
.form-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.875rem;
    user-select: none;
}

.checkbox-container input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.checkbox-container input[type="checkbox"]:disabled + .checkbox-custom {
    opacity: 0.5;
    cursor: not-allowed;
}

.checkbox-custom {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #e2e8f0;
    border-radius: 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    position: relative;
}

.checkbox-container input[type="checkbox"]:checked + .checkbox-custom {
    background-color: #3182ce;
    border-color: #3182ce;
}

.checkbox-container input[type="checkbox"]:checked + .checkbox-custom::after {
    content: '';
    display: block;
    width: 0.5rem;
    height: 0.25rem;
    border-left: 2px solid white;
    border-bottom: 2px solid white;
    transform: rotate(-45deg) translate(1px, -1px);
}

.default-help {
    margin-left: 2rem;
}

/* Actions de formulaire */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #edf2f7;
    margin-top: 1rem;
}

.primary-button, .secondary-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
    border: none;
    font-size: 0.875rem;
}

.primary-button {
    background-color: #3182ce;
    color: white;
}

.primary-button:hover:not(.loading) {
    background-color: #2c5282;
}

.secondary-button {
    background-color: #e2e8f0;
    color: #4a5568;
    text-decoration: none;
}

.secondary-button:hover {
    background-color: #cbd5e0;
}

.loading {
    opacity: 0.7;
    cursor: not-allowed;
    position: relative;
}

.loading:after {
    content: '';
    display: block;
    width: 1rem;
    height: 1rem;
    border: 2px solid transparent;
    border-radius: 50%;
    border-top-color: white;
    position: absolute;
    right: 0.75rem;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
