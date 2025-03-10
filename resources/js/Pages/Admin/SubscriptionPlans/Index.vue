<template>
    <AdminLayout>
        <div class="dashboard-container">
            <div class="header-section">
                <div class="title-container">
                    <span class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </span>
                    <h1 class="page-title">Plans d'abonnement</h1>
                </div>
                <Link :href="route('subscription-plans.create')" class="add-button">
                    <span class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="button-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </span>
                    <span>Ajouter un plan</span>
                </Link>
            </div>

            <div class="notifications">
                <div v-if="$page.props.flash && $page.props.flash.success" class="notification success">
                    <span class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="notification-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash && $page.props.flash.error" class="notification error">
                    <span class="icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" class="notification-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </span>
                    {{ $page.props.flash.error }}
                </div>
            </div>

            <div v-if="plans.length === 0" class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" class="empty-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="empty-text">Aucun plan d'abonnement trouvé</p>
                <Link :href="route('subscription-plans.create')" class="empty-action">
                    Créer un premier plan
                </Link>
            </div>

            <div v-else class="plans-grid">
                <div v-for="plan in plans" :key="plan.id" class="plan-card" :class="{ 'featured': plan.is_featured }">
                    <div class="plan-header">
                        <div>
                            <span v-if="plan.is_featured" class="featured-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" class="star-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                Recommandé
                            </span>
                            <h3 class="plan-name">{{ plan.name }}</h3>
                        </div>
                        <span :class="['status-badge', { 'active': plan.is_active, 'inactive': !plan.is_active }]">
                            {{ plan.is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>

                    <div class="plan-info">
                        <div class="info-row">
                            <span class="info-label">Slug :</span>
                            <span class="info-value">{{ plan.slug }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Prix mensuel :</span>
                            <span class="info-value price">{{ plan.formatted_monthly_price }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Prix annuel :</span>
                            <span class="info-value price">{{ plan.formatted_yearly_price }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Devise :</span>
                            <span class="info-value">{{ plan.currency ? plan.currency.code : '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Ordre d'affichage :</span>
                            <span class="info-value">{{ plan.sort_order }}</span>
                        </div>
                    </div>

                    <div class="plan-actions">
                        <Link :href="route('subscription-plans.edit', plan.id)" class="action-button edit" title="Modifier">
                            <span class="icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </span>
                            <span>Modifier</span>
                        </Link>
                        <Link :href="route('subscription-plans.destroy', plan.id)" method="delete" as="button" type="button" class="action-button delete" title="Supprimer">
                            <span class="icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="action-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </span>
                            <span>Supprimer</span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    plans: Array,
});
</script>

<style scoped>
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f7fafc;
    padding: 1rem;
}

.card-header-title {
    display: flex;
    align-items: center;
    font-size: 1.25rem;
    font-weight: bold;
}

.card-header-actions {
    display: flex;
    gap: 0.5rem;
}

.actions {
    width: 120px;
}

/* Layout principal */
.dashboard-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

/* En-tête avec titre et bouton d'ajout */
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

.add-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: #3b82f6;
    color: white;
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.25rem;
    font-weight: 600;
    transition: all 0.2s ease;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2), 0 2px 4px -1px rgba(59, 130, 246, 0.1);
}

.add-button:hover {
    background-color: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.2), 0 4px 6px -2px rgba(59, 130, 246, 0.1);
}

.button-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* Notifications */
.notifications {
    margin-bottom: 2rem;
}

.notification {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from { transform: translateY(-10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.notification.success {
    background-color: #ecfdf5;
    color: #047857;
    border-left: 4px solid #10b981;
}

.notification.error {
    background-color: #fef2f2;
    color: #b91c1c;
    border-left: 4px solid #ef4444;
}

.notification-icon {
    width: 1.25rem;
    height: 1.25rem;
}

/* État vide */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4rem 2rem;
    background-color: #f9fafb;
    border-radius: 0.75rem;
    text-align: center;
}

.empty-icon {
    width: 4rem;
    height: 4rem;
    color: #9ca3af;
    margin-bottom: 1.5rem;
}

.empty-text {
    font-size: 1.125rem;
    color: #4b5563;
    margin-bottom: 1.5rem;
}

.empty-action {
    padding: 0.75rem 1.5rem;
    background-color: #3b82f6;
    color: white;
    border-radius: 0.5rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.empty-action:hover {
    background-color: #2563eb;
}

/* Grille des plans */
.plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.plan-card {
    background-color: white;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.plan-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.plan-card.featured {
    border: 2px solid #3b82f6;
    position: relative;
}

.plan-header {
    padding: 1.25rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.featured-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #3b82f6;
    background-color: #eff6ff;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    margin-bottom: 0.5rem;
}

.star-icon {
    width: 0.75rem;
    height: 0.75rem;
}

.plan-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.status-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
}

.status-badge.active {
    background-color: #dcfce7;
    color: #16a34a;
}

.status-badge.inactive {
    background-color: #fef3c7;
    color: #d97706;
}

.plan-info {
    padding: 1.25rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
}

.info-row:last-child {
    margin-bottom: 0;
}

.info-label {
    color: #6b7280;
    font-weight: 500;
}

.info-value {
    color: #1f2937;
    font-weight: 600;
}

.info-value.price {
    color: #3b82f6;
}

.plan-actions {
    padding: 1.25rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 0.75rem;
}

.action-button {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.2s ease;
    flex: 1;
    justify-content: center;
}

.action-button.edit {
    background-color: #eff6ff;
    color: #3b82f6;
}

.action-button.edit:hover {
    background-color: #dbeafe;
}

.action-button.delete {
    background-color: #fef2f2;
    color: #ef4444;
}

.action-button.delete:hover {
    background-color: #fee2e2;
}

.action-icon {
    width: 1rem;
    height: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .header-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .add-button {
        width: 100%;
        justify-content: center;
    }
    
    .plans-grid {
        grid-template-columns: 1fr;
    }
}
</style>
