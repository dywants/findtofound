import { computed, ref, watch } from 'vue';
import * as yup from 'yup';

/**
 * Composable pour gérer la validation du formulaire avec Yup
 * 
 * @param {Boolean} wantReward - Si l'utilisateur veut une récompense
 * @returns {Object} - Schémas de validation et fonctions utilitaires
 */
export function useFormValidation(wantReward) {
  const showRewardStep = ref(wantReward);
  const showPersonalInfoStep = ref(!wantReward);

  // Mettre à jour les étapes visibles en fonction de wantReward
  watch(() => wantReward, (newValue) => {
    showRewardStep.value = newValue;
    showPersonalInfoStep.value = !newValue;
  }, { immediate: true });

  /**
   * Schéma de validation de l'étape 1 - Informations de la pièce
   */
  const step1Schema = yup.object({
    fullName: yup.string().required('Le nom inscrit sur la pièce est une information importante'),
    findCity: yup.string().required("La ville où la pièce a été retrouvée est une information importante"),
    piece_id: yup.number().required("Le choix du type de pièce est important").positive().integer(),
    findDate: yup.date()
      .required("La date de découverte est importante")
      .max(new Date(), "La date ne peut pas être dans le futur"),
    pieceCondition: yup.string()
      .required("L'état de la pièce est important")
      .oneOf(['Excellent', 'Bon', 'Moyen', 'Mauvais'], "Veuillez sélectionner un état valide"),
    additionalDetails: yup.string().nullable()
  });

  /**
   * Schéma de validation dynamique basé sur les préférences utilisateur
   */
  const validationSchema = computed(() => {
    // Deuxième étape - conditionnelle
    const step2Schema = showPersonalInfoStep.value
      ? yup.object({
          localisation: yup.string().required('Veuillez indiquer le lieu où vous avez déposé le document'),
          depositDate: yup.string().required('La date de dépôt est requise'),
          pickupHours: yup.string().required('Les horaires de récupération sont requis'),
          additionalInfo: yup.string().nullable()
        })
      : yup.object({});

    // Troisième étape - conditionnelle
    const step3Schema = showRewardStep.value
      ? yup.object({
          amount_check: yup.string().required('La validation de la rémunération est importante')
        })
      : yup.object({});

    // Construire un tableau avec seulement les schémas nécessaires
    const schema = [step1Schema, step2Schema];

    // Ajouter le schéma de récompense seulement si nécessaire
    if (showRewardStep.value) {
      schema.push(step3Schema);
    }

    return schema;
  });

  return {
    validationSchema,
    showRewardStep,
    showPersonalInfoStep
  };
}
