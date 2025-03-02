import { ref, onMounted } from 'vue';

/**
 * Composable pour gérer le stockage et la récupération des données du formulaire dans localStorage
 * 
 * @param {Object} initialValue - Structure initiale des données du formulaire
 * @param {String} storageKey - Clé utilisée pour stocker les données dans localStorage
 * @returns {Object} - Fonctions et données pour la gestion du stockage
 */
export function useFormStorage(initialValue, storageKey = 'formData') {
  const data = ref(initialValue);
  
  /**
   * Sauvegarde les données actuelles dans localStorage
   */
  const saveData = () => {
    localStorage.setItem(storageKey, JSON.stringify(data.value));
  };
  
  /**
   * Charge les données depuis localStorage
   * Garantit que la structure des données est complète en fusionnant avec initialValue
   */
  const loadData = () => {
    const savedData = localStorage.getItem(storageKey);
    if (savedData) {
      try {
        const parsedData = JSON.parse(savedData);
        // Fusion récursive des données sauvegardées avec la structure initiale
        data.value = mergeDeep(JSON.parse(JSON.stringify(initialValue)), parsedData);
      } catch (error) {
        console.error('Erreur lors de la récupération des données:', error);
      }
    }
  };
  
  /**
   * Efface les données du localStorage et réinitialise l'état
   */
  const clearData = () => {
    localStorage.removeItem(storageKey);
    data.value = JSON.parse(JSON.stringify(initialValue));
  };

  /**
   * Fusionne récursivement deux objets
   */
  const mergeDeep = (target, source) => {
    const isObject = obj => obj && typeof obj === 'object' && !Array.isArray(obj);
    
    if (!isObject(target) || !isObject(source)) {
      return source === undefined ? target : source;
    }
    
    const result = { ...target };
    
    Object.keys(source).forEach(key => {
      if (isObject(source[key])) {
        if (!(key in target)) {
          result[key] = source[key];
        } else {
          result[key] = mergeDeep(target[key], source[key]);
        }
      } else {
        result[key] = source[key];
      }
    });
    
    return result;
  };
  
  // Charger les données au montage du composant
  onMounted(loadData);
  
  return {
    data,
    saveData,
    loadData,
    clearData
  };
}
