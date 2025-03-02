import { ref } from 'vue';

/**
 * Composable pour gérer le téléchargement et le traitement d'images
 * 
 * @param {Function} onChange - Fonction appelée lorsque les images changent
 * @returns {Object} - Fonctions et données pour la gestion des images
 */
export function useImageUpload(onChange = null) {
  const selectedImages = ref([]);

  /**
   * Met à jour les images sélectionnées
   * 
   * @param {Array} newImages - Nouvelles images à traiter
   */
  const updateImages = (newImages) => {
    console.log('Mise à jour des images:', newImages);

    // S'assurer que les images ont le bon format (url et file)
    const processedImages = newImages.map(img => {
      // Vérifier si l'image est déjà au bon format
      if (img.url && img.file) {
        return img;
      }
      // Si c'est juste une URL, créer un objet au bon format
      return { url: img, file: null };
    });

    // Ne mettre à jour que si le contenu a changé
    if (JSON.stringify(selectedImages.value) !== JSON.stringify(processedImages)) {
      selectedImages.value = processedImages;
      
      // Appeler le callback si fourni
      if (onChange && typeof onChange === 'function') {
        onChange(selectedImages.value);
      }
    }

    console.log('Images après mise à jour:', selectedImages.value);
  };

  /**
   * Ajoute de nouvelles images au tableau existant
   */
  const addImages = (newImages) => {
    const currentImages = [...selectedImages.value];
    updateImages([...currentImages, ...newImages]);
  };

  /**
   * Supprime une image par son index
   */
  const removeImage = (index) => {
    const currentImages = [...selectedImages.value];
    currentImages.splice(index, 1);
    updateImages(currentImages);
  };

  /**
   * Traite les fichiers sélectionnés dans un input file
   */
  const handleFileUpload = (event) => {
    const files = event.target.files;
    if (!files || files.length === 0) return;

    const newImages = Array.from(files).map(file => {
      return {
        url: URL.createObjectURL(file),
        file: file
      };
    });

    addImages(newImages);
  };

  return {
    selectedImages,
    updateImages,
    addImages,
    removeImage,
    handleFileUpload
  };
}
