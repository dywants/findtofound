import { ref, computed, watch } from 'vue';

/**
 * Composable pour gérer les étapes d'un formulaire multi-étapes (wizard)
 * 
 * @param {Number} initialStep - Étape initiale (0-indexed)
 * @param {Array} stepsConfig - Configuration des étapes du formulaire
 * @returns {Object} - Fonctions et données pour la gestion des étapes
 */
export function useWizardSteps(initialStep = 0, stepsConfig = []) {
  const currentStep = ref(initialStep);
  const progressWidth = ref('0%');
  const steps = ref(stepsConfig);
  
  /**
   * Met à jour l'étape courante et la barre de progression
   */
  const updateStep = (step) => {
    currentStep.value = step;
    updateProgressBar();
  };
  
  /**
   * Met à jour la largeur de la barre de progression
   */
  const updateProgressBar = () => {
    if (steps.value.length <= 1) {
      progressWidth.value = '100%';
    } else {
      progressWidth.value = `${(currentStep.value / (steps.value.length - 1)) * 100}%`;
    }
  };
  
  /**
   * Passe à l'étape suivante
   */
  const nextStep = () => {
    if (currentStep.value < steps.value.length - 1) {
      currentStep.value++;
      updateProgressBar();
    }
  };
  
  /**
   * Revient à l'étape précédente
   */
  const prevStep = () => {
    if (currentStep.value > 0) {
      currentStep.value--;
      updateProgressBar();
    }
  };
  
  /**
   * Met à jour la configuration des étapes
   */
  const setSteps = (newSteps) => {
    steps.value = newSteps;
    updateProgressBar();
  };
  
  /**
   * Nom de la section actuelle
   */
  const currentSectionName = computed(() => {
    return steps.value[currentStep.value]?.name || "Validation";
  });
  
  /**
   * Vérifie si l'utilisateur peut naviguer vers l'étape spécifiée
   * Par défaut, permet de naviguer en arrière ou vers l'étape actuelle
   */
  const canNavigateToStep = (stepIndex) => {
    // Toujours autoriser la navigation vers les étapes antérieures ou l'étape courante
    return stepIndex <= currentStep.value;
  };
  
  /**
   * Navigue directement vers une étape spécifique si possible
   */
  const goToStep = (stepIndex) => {
    if (canNavigateToStep(stepIndex) && stepIndex >= 0 && stepIndex < steps.value.length) {
      currentStep.value = stepIndex;
      updateProgressBar();
      return true;
    }
    return false;
  };
  
  // S'assurer que la progression est mise à jour si les étapes changent
  watch(steps, updateProgressBar);
  
  // S'assurer que la progression est toujours correcte quand l'étape change
  watch(currentStep, updateProgressBar, { immediate: true });
  
  return {
    currentStep,
    progressWidth,
    steps,
    updateStep,
    nextStep,
    prevStep,
    setSteps,
    currentSectionName,
    canNavigateToStep,
    goToStep
  };
}
