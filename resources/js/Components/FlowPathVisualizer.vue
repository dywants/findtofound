<template>
  <div class="flow-path-container">
    <div class="flow-steps">
      <!-- Étape 1 commune à tous les parcours -->
      <div class="flow-step" :class="{ 'active': activeStep === 1 }">
        <div class="flow-step-connector" v-if="steps.length > 1"></div>
        <div class="flow-step-content">
          <div class="flow-step-icon">
            <div class="flow-step-number">1</div>
            <slot name="step-1-icon">
              <Icon name="document-text" :solid="activeStep >= 1" 
                   :customClass="activeStep >= 1 ? 'text-primary-600' : 'text-gray-400'" />
            </slot>
          </div>
          <div class="flow-step-details">
            <h3 class="flow-step-title">{{ steps[0]?.title || 'Étape 1' }}</h3>
            <p class="flow-step-description">{{ steps[0]?.description || 'Description de l\'étape 1' }}</p>
          </div>
        </div>
      </div>

      <!-- Affichage des chemins différents basés sur le choix de l'utilisateur -->
      <div class="flow-branches" v-if="showBranches">
        <div class="flow-branches-divider">
          <div class="flow-branches-divider-line"></div>
          <div class="flow-branches-divider-label">{{ branchLabel }}</div>
          <div class="flow-branches-divider-line"></div>
        </div>
        
        <div class="flow-branches-options">
          <!-- Option de gauche (sans récompense) -->
          <div class="flow-branch" 
               :class="{ 'active': !selectedBranch, 'selected': selectedBranch === false }"
               @click="$emit('branch-selected', false)">
            <div class="flow-branch-content">
              <div class="flow-branch-icon">
                <slot name="branch-left-icon">
                  <Icon name="user-circle" :solid="selectedBranch === false" 
                       :customClass="selectedBranch === false ? 'text-blue-500' : 'text-gray-400'" />
                </slot>
              </div>
              <h4 class="flow-branch-title">{{ branchOptions[0]?.title || 'Option 1' }}</h4>
              <p class="flow-branch-description">{{ branchOptions[0]?.description || 'Description de l\'option 1' }}</p>
            </div>
          </div>
          
          <!-- Option de droite (avec récompense) -->
          <div class="flow-branch" 
               :class="{ 'active': selectedBranch, 'selected': selectedBranch === true }"
               @click="$emit('branch-selected', true)">
            <div class="flow-branch-content">
              <div class="flow-branch-icon">
                <slot name="branch-right-icon">
                  <Icon name="cash" :solid="selectedBranch === true" 
                       :customClass="selectedBranch === true ? 'text-green-500' : 'text-gray-400'" />
                </slot>
              </div>
              <h4 class="flow-branch-title">{{ branchOptions[1]?.title || 'Option 2' }}</h4>
              <p class="flow-branch-description">{{ branchOptions[1]?.description || 'Description de l\'option 2' }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Étapes suivantes basées sur le choix de branche -->
      <template v-for="(step, index) in relevantSteps" :key="'step-' + (index + 2)">
        <div class="flow-step" :class="{ 'active': activeStep === index + 2 }">
          <div class="flow-step-connector" v-if="index < relevantSteps.length - 1"></div>
          <div class="flow-step-content">
            <div class="flow-step-icon">
              <div class="flow-step-number">{{ index + 2 }}</div>
              <slot :name="`step-${index + 2}-icon`">
                <Icon :name="step.icon || 'document-text'" :solid="activeStep >= index + 2" 
                     :customClass="activeStep >= index + 2 ? (selectedBranch ? 'text-green-500' : 'text-blue-500') : 'text-gray-400'" />
              </slot>
            </div>
            <div class="flow-step-details">
              <h3 class="flow-step-title">{{ step.title }}</h3>
              <p class="flow-step-description">{{ step.description }}</p>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import Icon from '@/Components/Icon.vue';

const props = defineProps({
  steps: {
    type: Array,
    default: () => []
  },
  branchSteps: {
    type: Object,
    default: () => ({
      true: [], // Étapes pour le choix "avec récompense"
      false: []  // Étapes pour le choix "sans récompense"
    })
  },
  branchLabel: {
    type: String,
    default: 'Choisissez votre préférence'
  },
  branchOptions: {
    type: Array,
    default: () => [
      { title: 'Sans récompense', description: 'Processus anonyme' },
      { title: 'Avec récompense', description: 'Suivi complet' }
    ]
  },
  activeStep: {
    type: Number,
    default: 1
  },
  selectedBranch: {
    type: Boolean,
    default: null
  },
  showBranches: {
    type: Boolean,
    default: true
  }
});

const relevantSteps = computed(() => {
  if (props.selectedBranch === null) return [];
  return props.branchSteps[props.selectedBranch] || [];
});

defineEmits(['branch-selected']);
</script>

<style scoped>
.flow-path-container {
  width: 100%;
  padding: 1.5rem 0;
}

.flow-steps {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}

.flow-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  position: relative;
  transition: all 0.3s ease;
}

.flow-step-connector {
  width: 2px;
  height: 40px;
  background-color: #E5E7EB;
  margin: 0.5rem 0;
}

.flow-step.active .flow-step-connector {
  background: linear-gradient(180deg, #4F46E5 0%, #E5E7EB 100%);
}

.flow-step-content {
  display: flex;
  align-items: flex-start;
  width: 100%;
  max-width: 600px;
  padding: 1rem;
  border-radius: 0.5rem;
  background-color: white;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.flow-step.active .flow-step-content {
  box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
  border-left: 3px solid #4F46E5;
}

.flow-step-icon {
  position: relative;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background-color: #F3F4F6;
  margin-right: 1rem;
}

.flow-step.active .flow-step-icon {
  background-color: #EEF2FF;
}

.flow-step-number {
  position: absolute;
  top: -8px;
  right: -8px;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background-color: #4F46E5;
  color: white;
  font-size: 0.75rem;
  font-weight: 600;
}

.flow-step-details {
  flex-grow: 1;
}

.flow-step-title {
  font-size: 1rem;
  font-weight: 600;
  color: #1F2937;
  margin-bottom: 0.25rem;
}

.flow-step-description {
  font-size: 0.875rem;
  color: #6B7280;
}

/* Styles pour les branches */
.flow-branches {
  width: 100%;
  max-width: 700px;
  margin: 1rem 0;
}

.flow-branches-divider {
  display: flex;
  align-items: center;
  margin: 1rem 0;
}

.flow-branches-divider-line {
  flex-grow: 1;
  height: 1px;
  background-color: #E5E7EB;
}

.flow-branches-divider-label {
  padding: 0 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  color: #6B7280;
  text-align: center;
}

.flow-branches-options {
  display: flex;
  justify-content: space-between;
  gap: 1.5rem;
}

.flow-branch {
  flex: 1;
  padding: 1.25rem;
  border-radius: 0.5rem;
  background-color: white;
  border: 1px solid #E5E7EB;
  cursor: pointer;
  transition: all 0.2s ease;
}

.flow-branch:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transform: translateY(-2px);
}

.flow-branch.active {
  border-color: #93C5FD;
  background-color: #EFF6FF;
}

.flow-branch.active.selected {
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.flow-branch:nth-child(2).active {
  border-color: #86EFAC;
  background-color: #F0FDF4;
}

.flow-branch:nth-child(2).active.selected {
  box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
}

.flow-branch-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}

.flow-branch-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 54px;
  height: 54px;
  border-radius: 50%;
  background-color: #F3F4F6;
  margin-bottom: 1rem;
}

.flow-branch:nth-child(1).active .flow-branch-icon {
  background-color: #DBEAFE;
}

.flow-branch:nth-child(2).active .flow-branch-icon {
  background-color: #DCFCE7;
}

.flow-branch-title {
  font-size: 1rem;
  font-weight: 600;
  color: #1F2937;
  margin-bottom: 0.5rem;
}

.flow-branch-description {
  font-size: 0.875rem;
  color: #6B7280;
}

@media (max-width: 640px) {
  .flow-branches-options {
    flex-direction: column;
  }
  
  .flow-branch {
    max-width: 100%;
  }
}
</style>
