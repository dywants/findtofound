<template>
    <AdminLayout>
        <div class="dashboard-container">
            <div class="header-section">
                <div class="title-container">
                    <span class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </span>
                    <h1 class="page-title">Modifier le plan d'abonnement</h1>
                </div>
                <Link :href="route('subscription-plans.index')" class="back-button">
                    <span class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </span>
                    <span>Retour à la liste</span>
                </Link>
            </div>
            
            <div class="form-card">
                <form @submit.prevent="submit" class="form-container">
                    <div class="field">
                        <label class="label" for="name">Nom</label>
                        <div class="control">
                            <input type="text" id="name" v-model="form.name" class="input" required>
                        </div>
                        <p v-if="errors.name" class="help is-danger">{{ errors.name }}</p>
                    </div>

                    <div class="field">
                        <label class="label" for="slug">Slug</label>
                        <div class="control">
                            <input type="text" id="slug" v-model="form.slug" class="input" required>
                        </div>
                        <p v-if="errors.slug" class="help is-danger">{{ errors.slug }}</p>
                    </div>

                    <div class="field">
                        <label class="label" for="description">Description</label>
                        <div class="control">
                            <textarea id="description" v-model="form.description" class="textarea"></textarea>
                        </div>
                        <p v-if="errors.description" class="help is-danger">{{ errors.description }}</p>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label" for="price_monthly">Prix mensuel</label>
                                <div class="control">
                                    <input type="number" id="price_monthly" v-model="form.price_monthly" class="input" step="0.01" required>
                                </div>
                                <p v-if="errors.price_monthly" class="help is-danger">{{ errors.price_monthly }}</p>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label" for="price_yearly">Prix annuel</label>
                                <div class="control">
                                    <input type="number" id="price_yearly" v-model="form.price_yearly" class="input" step="0.01" required>
                                </div>
                                <p v-if="errors.price_yearly" class="help is-danger">{{ errors.price_yearly }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label" for="currency_id">Devise</label>
                        <div class="control">
                            <div class="select is-fullwidth">
                                <select id="currency_id" v-model="form.currency_id" required>
                                    <option value="">Sélectionnez une devise</option>
                                    <option v-for="currency in currencies" :key="currency.id" :value="currency.id">
                                        {{ currency.name }} ({{ currency.code }})
                                    </option>
                                </select>
                            </div>
                        </div>
                        <p v-if="errors.currency_id" class="help is-danger">{{ errors.currency_id }}</p>
                    </div>

                    <div class="features-section">
                        <h3 class="section-title">Caractéristiques du plan</h3>

                        <!-- Documents protégés -->
                        <div class="field">
                            <label class="label">Documents protégés</label>
                            <div class="control">
                                <div class="field has-addons">
                                    <div class="control is-expanded">
                                        <input type="number" v-model="form.features.monthly_generations" class="input" placeholder="Ex: 5 ou 20 ou 50" :disabled="isUnlimitedDocuments" min="1">
                                    </div>
                                </div>
                                <label class="checkbox mt-2 block">
                                    <input type="checkbox" v-model="isUnlimitedDocuments"> Documents illimités
                                </label>
                            </div>
                            <p class="help">Nombre de documents que l'utilisateur peut protéger par mois. Cochez "Documents illimités" pour offrir un accès sans limite.</p>
                        </div>

                        <!-- Taille des fichiers -->
                        <div class="field">
                            <label class="label">Taille maximale des fichiers (MB)</label>
                            <div class="control">
                                <input type="number" v-model="form.features.max_document_size" class="input" min="1">
                            </div>
                            <p class="help">Taille maximale autorisée pour chaque document en mégaoctets</p>
                        </div>

                        <!-- Types de documents -->
                        <div class="field">
                            <label class="label">Formats de documents supportés</label>
                            <div class="control">
                                <div class="columns is-multiline">
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="documentTypes" value="pdf">
                                            PDF
                                        </label>
                                    </div>
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="documentTypes" value="jpg">
                                            JPG
                                        </label>
                                    </div>
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="documentTypes" value="png">
                                            PNG
                                        </label>
                                    </div>
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="documentTypes" value="gif">
                                            GIF
                                        </label>
                                    </div>
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="documentTypes" value="tiff">
                                            TIFF
                                        </label>
                                    </div>
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="documentTypes" value="webp">
                                            WebP
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jours d'essai -->
                        <div class="field">
                            <label class="label">Nombre de jours d'essai</label>
                            <div class="control">
                                <input type="number" v-model="form.features.trial_days" class="input" min="0">
                            </div>
                            <p class="help">Période d'essai gratuite en jours (0 = pas d'essai gratuit)</p>
                        </div>

                        <!-- Options de filigrane -->
                        <div class="field">
                            <label class="label">Options de filigrane disponibles</label>
                            <div class="control">
                                <div class="columns is-multiline">
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="watermarkOptions" value="text">
                                            Texte
                                        </label>
                                    </div>
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="watermarkOptions" value="image">
                                            Image
                                        </label>
                                    </div>
                                    <div class="column is-narrow">
                                        <label class="checkbox">
                                            <input type="checkbox" v-model="watermarkOptions" value="qr">
                                            QR Code
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Durée de stockage -->
                        <div class="field">
                            <label class="label">Durée de stockage (jours)</label>
                            <div class="control">
                                <input type="number" v-model="form.features.storage_duration" class="input" min="1">
                            </div>
                            <p class="help">Nombre de jours pendant lesquels les documents protégés restent disponibles</p>
                        </div>

                        <!-- Nombre de partages -->
                        <div class="field">
                            <label class="label">Nombre maximum de partages</label>
                            <div class="control">
                                <input type="number" v-model="form.features.max_shares" class="input" min="1">
                            </div>
                            <p class="help">Nombre maximum de fois qu'un document peut être partagé</p>
                        </div>

                        <!-- Traitement par lots -->
                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" v-model="form.features.batch_processing">
                                    Traitement par lots
                                </label>
                            </div>
                            <p class="help">Permet de traiter plusieurs documents en une seule fois</p>
                        </div>

                        <!-- Protection par mot de passe -->
                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" v-model="form.features.password_protection">
                                    Protection par mot de passe
                                </label>
                            </div>
                        </div>

                        <!-- Suivi d'accès -->
                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" v-model="form.features.tracking">
                                    Suivi d'accès
                                </label>
                            </div>
                        </div>

                        <!-- Date d'expiration -->
                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" v-model="form.features.expiration">
                                    Configuration de date d'expiration
                                </label>
                            </div>
                        </div>

                        <!-- Support -->
                        <div class="field">
                            <label class="label">Niveau de support</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select v-model="form.features.support">
                                        <option value="">Aucun</option>
                                        <option value="email_48h">Email (48h)</option>
                                        <option value="email_24h">Email (24h)</option>
                                        <option value="chat">Chat en direct</option>
                                        <option value="dedicated">Support dédié</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- API Access -->
                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" v-model="form.features.api_access">
                                    Accès API
                                </label>
                            </div>
                        </div>

                        <!-- Rapports avancés -->
                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" v-model="form.features.reports">
                                    Rapports avancés
                                </label>
                            </div>
                        </div>

                        <!-- Utilisateurs par compte -->
                        <div class="field">
                            <label class="label">Utilisateurs par compte</label>
                            <div class="control">
                                <input type="number" v-model="form.features.users_per_account" class="input" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label" for="trial_days">Jours d'essai</label>
                                <div class="control">
                                    <input type="number" id="trial_days" v-model="form.trial_days" class="input" min="0">
                                </div>
                                <p v-if="errors.trial_days" class="help is-danger">{{ errors.trial_days }}</p>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label" for="sort_order">Ordre d'affichage</label>
                                <div class="control">
                                    <input type="number" id="sort_order" v-model="form.sort_order" class="input" min="0">
                                </div>
                                <p v-if="errors.sort_order" class="help is-danger">{{ errors.sort_order }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" v-model="form.is_active">
                                Plan actif
                            </label>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                                <input type="checkbox" v-model="form.is_featured">
                                Plan mis en avant
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-button" :class="{ 'is-loading': form.processing }">
                            <span class="icon-wrapper" v-if="!form.processing">
                                <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span>Mettre à jour</span>
                        </button>
                        <Link :href="route('subscription-plans.index')" class="cancel-button">
                            <span>Annuler</span>
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    plan: Object,
    currencies: Array,
    errors: Object,
});

// Initialiser les variables pour les cases à cocher
const documentTypes = ref([]);
const watermarkOptions = ref([]);
const isUnlimitedDocuments = ref(false);

// Préparer les fonctionnalités par défaut
const defaultFeatures = {
    monthly_generations: 5,
    max_document_size: 10,
    document_types: ['pdf'], 
    watermark_options: ['text'],
    storage_duration: 7,
    max_shares: 3,
    batch_processing: false,
    password_protection: false,
    tracking: false,
    expiration: false,
    support: 'email_48h',
    api_access: false,
    reports: false,
    users_per_account: 1,
    trial_days: 14 // Nombre de jours d'essai par défaut
};

// Fusionner les fonctionnalités du plan existant avec les valeurs par défaut
const planFeatures = typeof props.plan.features === 'string' 
    ? JSON.parse(props.plan.features) 
    : (props.plan.features || defaultFeatures);

// Initialiser le formulaire
const form = useForm({
    name: props.plan.name,
    slug: props.plan.slug,
    description: props.plan.description || '',
    price_monthly: props.plan.price_monthly || props.plan.monthly_price,
    price_yearly: props.plan.price_yearly || props.plan.yearly_price,
    currency_id: props.plan.currency_id,
    features: {
        ...defaultFeatures,
        ...planFeatures,
        // Migrer trial_days de la racine vers features si existant
        trial_days: props.plan.trial_days || (planFeatures.trial_days || defaultFeatures.trial_days)
    },
    sort_order: props.plan.sort_order || 0,
    is_active: props.plan.is_active || false,
    is_featured: props.plan.is_featured || false,
});

// Vérifier si les documents sont illimités (-1) et initialiser la case à cocher en conséquence
onMounted(() => {
    if (form.features.monthly_generations === -1) {
        isUnlimitedDocuments.value = true;
    }
});

// Observer les changements sur la case à cocher "Documents illimités"
watch(isUnlimitedDocuments, (newValue) => {
    if (newValue) {
        // Si la case est cochée, définir la valeur à -1 (illimité)
        form.features.monthly_generations = -1;
    } else {
        // Si la case est décochée, réinitialiser à une valeur par défaut raisonnable
        form.features.monthly_generations = 10;
    }
});

// Initialiser les types de documents et options de filigrane depuis les fonctionnalités du plan
onMounted(() => {
    if (form.features.document_types && Array.isArray(form.features.document_types)) {
        documentTypes.value = [...form.features.document_types];
    }
    
    if (form.features.watermark_options && Array.isArray(form.features.watermark_options)) {
        watermarkOptions.value = [...form.features.watermark_options];
    }
});

// Observer les changements sur documentTypes et mettre à jour form.features.document_types
watch(documentTypes, (newValue) => {
    form.features.document_types = [...newValue];
});

// Observer les changements sur watermarkOptions et mettre à jour form.features.watermark_options
watch(watermarkOptions, (newValue) => {
    form.features.watermark_options = [...newValue];
});

const submit = () => {
    form.put(route('subscription-plans.update', props.plan.id));
};
</script>

<style scoped>
/* Layout principal */
.dashboard-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* En-tête avec titre et bouton retour */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.title-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.icon-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon {
    width: 1.75rem;
    height: 1.75rem;
    color: #3b82f6;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.back-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: #f3f4f6;
    color: #4b5563;
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.25rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.back-button:hover {
    background-color: #e5e7eb;
    color: #1f2937;
}

.button-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* Carte du formulaire */
.form-card {
    background-color: white;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
}

.form-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Champs du formulaire */
.field {
    margin-bottom: 1.5rem;
}

.field:last-of-type {
    margin-bottom: 0;
}

.label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 0.5rem;
}

.control {
    position: relative;
}

.input, .textarea, .select select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 1rem;
    color: #1f2937;
    background-color: #ffffff;
    transition: all 0.2s ease;
}

.input:focus, .textarea:focus, .select select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.textarea {
    min-height: 8rem;
    resize: vertical;
}

.select {
    position: relative;
    width: 100%;
}

.select select {
    appearance: none;
    padding-right: 2.5rem;
}

.select::after {
    content: '';
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 0.75rem;
    height: 0.75rem;
    border-right: 2px solid #6b7280;
    border-bottom: 2px solid #6b7280;
    pointer-events: none;
    transform: translateY(-50%) rotate(45deg);
}

.help {
    font-size: 0.75rem;
    margin-top: 0.375rem;
}

.help.is-danger {
    color: #ef4444;
}

.columns {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.column {
    flex: 1;
    min-width: 250px;
}

.checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    user-select: none;
}

.checkbox input[type="checkbox"] {
    appearance: none;
    width: 1.25rem;
    height: 1.25rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    background-color: #ffffff;
    position: relative;
}

.checkbox input[type="checkbox"]:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.checkbox input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    top: 0.3rem;
    left: 0.4rem;
    width: 0.4rem;
    height: 0.4rem;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

/* Section des caractéristiques */
.features-section {
    background-color: #f9fafb;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin: 1.5rem 0;
    border: 1px solid #e5e7eb;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-top: 0;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e5e7eb;
}

/* Boutons d'action */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.submit-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: #3b82f6;
    color: white;
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
    cursor: pointer;
}

.submit-button:hover {
    background-color: #2563eb;
}

.submit-button.is-loading {
    position: relative;
    color: transparent;
}

.submit-button.is-loading::after {
    content: '';
    position: absolute;
    width: 1.25rem;
    height: 1.25rem;
    top: calc(50% - 0.625rem);
    left: calc(50% - 0.625rem);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.cancel-button {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f3f4f6;
    color: #4b5563;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.cancel-button:hover {
    background-color: #e5e7eb;
    color: #1f2937;
}

/* Responsive */
@media (max-width: 768px) {
    .header-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .back-button {
        width: 100%;
        justify-content: center;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .submit-button, .cancel-button {
        width: 100%;
        justify-content: center;
    }
}
</style>
