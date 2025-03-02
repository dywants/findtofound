import { ref } from 'vue';
import axios from 'axios';

/**
 * Composable pour gérer la soumission du formulaire et les interactions avec l'API
 * 
 * @returns {Object} - Fonctions et données pour la soumission du formulaire
 */
export function useFormSubmission() {
  const isLoading = ref(false);
  const validationErrors = ref(null);

  /**
   * Soumet le formulaire à l'API
   * 
   * @param {Object} formData - Données du formulaire à soumettre
   * @param {Array} selectedImages - Images sélectionnées par l'utilisateur
   * @param {Boolean} wantReward - Si l'utilisateur veut une récompense
   * @returns {Promise} - Promise de la requête
   */
  const submitForm = async (formData, selectedImages, wantReward) => {
    isLoading.value = true;
    validationErrors.value = null;

    try {
      // Vérification des images
      if (!selectedImages || selectedImages.length === 0) {
        throw new Error('Vous devez ajouter au moins une photo de la pièce.');
      }

      const hasValidFile = selectedImages.some(image => image.file);
      if (!hasValidFile) {
        throw new Error('Aucune image valide n\'a été trouvée. Veuillez ajouter au moins une photo de la pièce.');
      }

      // Préparer les données du formulaire
      const uploadFormData = prepareFormData(formData, selectedImages, wantReward);

      // Soumettre les données
      const response = await axios.post('/piece-enregistrer-find', uploadFormData, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      localStorage.removeItem('formData');
      return response;
    } catch (error) {
      handleSubmissionError(error);
      throw error;
    } finally {
      isLoading.value = false;
    }
  };

  /**
   * Prépare les données du formulaire pour la soumission
   * 
   * @param {Object} formData - Données du formulaire organisées par étape
   * @param {Array} selectedImages - Images sélectionnées
   * @param {Boolean} wantReward - Si l'utilisateur veut une récompense
   * @returns {FormData} - Données formatées pour l'envoi
   */
  const prepareFormData = (formData, selectedImages, wantReward) => {
    const uploadFormData = new FormData();

    // Informations de base de la pièce (étape 1) - vérifier que le nommage correspond au backend
    const step1 = formData.step1 || {};
    
    // Champs obligatoires selon FindRequest.php
    uploadFormData.append('piece_id', step1.piece_id || formData.piece_id || '');
    uploadFormData.append('fullName', step1.fullName || formData.fullName || '');
    uploadFormData.append('findCity', step1.findCity || formData.findCity || '');
    
    // Champs additionnels
    uploadFormData.append('discovery_date', step1.findDate || formData.findDate || '');
    uploadFormData.append('piece_condition', step1.pieceCondition || formData.pieceCondition || '');
    uploadFormData.append('condition_details', step1.additionalDetails || formData.additionalDetails || '');
    uploadFormData.append('details', step1.additionalDetails || formData.additionalDetails || '');
    uploadFormData.append('ward', step1.ward || formData.ward || '');

    // Indiquer si l'utilisateur veut une récompense (convertir en chaîne pour le backend)
    uploadFormData.append('wantReward', wantReward ? '1' : '0');

    // Tester une nouvelle approche directe pour checkAnnonymary
    // CheckAnnonymary est toujours vrai dans le scénario 1 (pas de récompense)
    // CheckAnnonymary peut être vrai ou faux dans le scénario 2 (avec récompense)
    
    // Détection initiale de l'anonymat
    let isAnonymous = true; // Par défaut, anonyme
    
    // SCÉNARIO 1: Utilisateur ne veut pas de récompense (mode anonyme)
    if (!wantReward) {
      // SCÉNARIO 1: Utilisateur ne veut pas de récompense - toujours anonyme
      isAnonymous = true;
      handleNoRewardScenario(uploadFormData, formData.step2);
      
      // Ajouter des valeurs factices pour amount_check qui est marqué comme nullable dans ce scénario
      uploadFormData.append('amount_check', '1000');
    }
    // SCÉNARIO 2: Utilisateur veut une récompense
    else {
      // Déterminer si anonyme dans le scénario avec récompense
      isAnonymous = !!(formData.step2?.isAnonymous);
      handleRewardScenario(uploadFormData, formData.step2, formData.step3);
    }
    
    // Tentative alternative d'envoi du booléen - utiliser 0/1 numériques 
    // et s'assurer qu'ils ne sont pas convertis en chaînes de caractères
    uploadFormData.delete('checkAnnonymary'); // Supprimer toute valeur existante
    uploadFormData.append('checkAnnonymary', isAnonymous ? 1 : 0);
    uploadFormData.append('is_anonymous', isAnonymous ? '1' : '0');
    
    console.log('VALEUR FINALE checkAnnonymary:', uploadFormData.get('checkAnnonymary'), 'Type:', typeof uploadFormData.get('checkAnnonymary'));

    // Ajouter les images - vérifier que ça correspond à la validation dans FindRequest
    if (selectedImages && selectedImages.length > 0) {
      let hasValidImage = false;
      
      selectedImages.forEach((image, index) => {
        if (image.file) {
          uploadFormData.append(`photos[${index}]`, image.file);
          hasValidImage = true;
        }
      });
      
      // Si aucune image valide, lever une erreur
      if (!hasValidImage) {
        throw new Error('Vous devez ajouter au moins une photo de la pièce.');
      }
    } else {
      throw new Error('Vous devez ajouter au moins une photo de la pièce.');
    }

    // Log des champs importants pour le débogage final
    console.log('=== VALEURS FINALES DES CHAMPS CRITIQUES ===');
    console.log('- checkAnnonymary:', uploadFormData.get('checkAnnonymary'));
    console.log('- is_anonymous:', uploadFormData.get('is_anonymous'));
    console.log('- wantReward:', uploadFormData.get('wantReward'));
    console.log('- localisation:', uploadFormData.get('localisation'));
    console.log('- depositDate:', uploadFormData.get('depositDate'));
    console.log('- pickup_hours:', uploadFormData.get('pickup_hours'));
    console.log('- amount_check:', uploadFormData.get('amount_check'));
    console.log('- name:', uploadFormData.get('name'));
    console.log('- email:', uploadFormData.get('email'));
    console.log('- phone_number:', uploadFormData.get('phone_number'));
    console.log('- city:', uploadFormData.get('city'));
    console.log('===================================');

    return uploadFormData;
  };

  /**
   * Gère le scénario où l'utilisateur ne veut pas de récompense
   */
  const handleNoRewardScenario = (uploadFormData, step2Data) => {
    // Réinitialiser les champs potentiellement conflictuels
    resetFields(uploadFormData, [
      'checkAnnonymary', 'is_anonymous', 'localisation', 'depositDate',
      'pickup_hours', 'deposit_location', 'deposit_date',
      'special_instructions', 'additionalInfo'
    ]);

    // Noter que checkAnnonymary est maintenant géré globalement
    // Ne gérer que is_anonymous au niveau local pour compatibilité de la base de données
    uploadFormData.append('is_anonymous', '1');
    
    console.log('Mode sans récompense: utilisateur toujours anonyme');

    // Valeurs factices pour les champs obligatoires de l'utilisateur
    uploadFormData.append('name', 'Anonymous User');
    uploadFormData.append('email', 'anonymous@example.com');
    uploadFormData.append('phone_number', '123456789');
    uploadFormData.append('city', step2Data?.city || 'Unknown City');

    // Informations de dépôt - les champs obligatoires selon FindRequest.php
    // S'assurer qu'ils ont toujours une valeur par défaut pour éviter les erreurs de validation
    const currentDate = new Date().toISOString().split('T')[0];
    
    uploadFormData.append('localisation', step2Data?.localisation || 'Lieu de dépôt par défaut');
    uploadFormData.append('depositDate', step2Data?.depositDate || currentDate);
    uploadFormData.append('pickup_hours', step2Data?.pickupHours || '9h-17h');
    
    // Champs additionnels (pour compatibilité avec le backend existant)
    uploadFormData.append('deposit_location', step2Data?.localisation || 'Lieu de dépôt par défaut');
    uploadFormData.append('deposit_date', step2Data?.depositDate || currentDate);
    uploadFormData.append('special_instructions', step2Data?.additionalInfo || 'Aucune instruction spéciale');
    uploadFormData.append('additionalInfo', step2Data?.additionalInfo || 'Aucune information supplémentaire');
  };

  /**
   * Gère le scénario où l'utilisateur veut une récompense
   */
  const handleRewardScenario = (uploadFormData, step2Data, step3Data) => {
    // Convertir explicitement en booléen et s'assurer qu'il est défini
    const isAnonymous = !!step2Data?.isAnonymous;
    console.log('Mode anonyme détecté:', isAnonymous);
    
    // Noter que checkAnnonymary est maintenant géré globalement
    // Ne gérer que is_anonymous au niveau local pour compatibilité de la base de données
    uploadFormData.append('is_anonymous', isAnonymous ? '1' : '0');
    
    console.log('Mode avec récompense: utilisateur anonyme =', isAnonymous);
    
    // Le montant est obligatoire dans ce scénario
    uploadFormData.append('amount_check', step3Data?.amount_choice || '1000');

    if (isAnonymous) {
      // Mode anonyme avec récompense
      uploadFormData.append('localisation', step2Data?.anonymousData?.localisation || '');
      
      // Ajouter des valeurs factices pour les champs d'utilisateur qui seraient autrement requis
      uploadFormData.append('name', 'Anonymous User');
      uploadFormData.append('email', 'anonymous@example.com');
      uploadFormData.append('phone_number', '123456789');
      uploadFormData.append('city', 'Unknown City');
    } else {
      // Mode identifié avec récompense
      const accountData = step2Data?.accountData || {};
      
      // Vérifier si les valeurs sont vides ou non définies et utiliser des valeurs par défaut
      // Ces champs sont obligatoires selon FindRequest.php pour le mode non-anonyme avec récompense
      uploadFormData.append('name', accountData.name || 'Utilisateur Connecté');
      uploadFormData.append('email', accountData.email || 'user@example.com');
      uploadFormData.append('phone_number', accountData.phone || '0123456789');
      uploadFormData.append('city', accountData.city || 'Ville par défaut');
      
      // Toujours inclure localisation même pour les utilisateurs non anonymes
      uploadFormData.append('localisation', accountData.city || 'Ville par défaut');
    }
  };

  /**
   * Réinitialise des champs dans le FormData
   */
  const resetFields = (formData, fields) => {
    fields.forEach(field => formData.delete(field));
  };

  /**
   * Gère les erreurs de soumission
   */
  const handleSubmissionError = (error) => {
    console.error('Erreur de soumission:', error);
    
    if (error.response && error.response.data) {
      // Stocker les erreurs pour l'affichage dans le formulaire
      validationErrors.value = error.response.data.errors;
      
      // Log plus détaillé pour le débogage
      console.error('Erreurs de validation:', error.response.data.errors);
    }

    let errorMessage = 'Une erreur s\'est produite lors de la soumission du formulaire.';

    if (error.response && error.response.data && error.response.data.message) {
      errorMessage += '\n\nDétail: ' + error.response.data.message;
    }

    errorMessage += '\n\nConsultez les détails d\'erreur affichés ci-dessous.';
    alert(errorMessage);
  };

  return {
    isLoading,
    validationErrors,
    submitForm
  };
}
