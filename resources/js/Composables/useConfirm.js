import { ref } from 'vue';

/**
 * Composable pour gérer les boîtes de dialogue de confirmation
 * Permet de créer facilement des dialogues de confirmation pour des actions critiques
 */
export function useConfirm() {
    const isOpen = ref(false);
    const title = ref('');
    const message = ref('');
    const confirmButton = ref({
        label: 'Confirmer',
        class: 'is-danger',
    });
    const cancelButton = ref({
        label: 'Annuler',
        class: 'is-light',
    });
    
    // Fonctions de rappel
    let resolvePromise = null;
    let rejectPromise = null;
    
    /**
     * Ouvre une boîte de dialogue de confirmation
     * 
     * @param {Object} options - Options de configuration
     * @param {string} options.title - Titre de la boîte de dialogue
     * @param {string} options.message - Message à afficher
     * @param {Object} options.button - Configuration des boutons
     * @param {Function} options.onConfirm - Fonction exécutée à la confirmation
     * @param {Function} options.onCancel - Fonction exécutée à l'annulation
     */
    const confirm = (options) => {
        title.value = options.title || 'Confirmation';
        message.value = options.message || 'Êtes-vous sûr de vouloir effectuer cette action ?';
        
        if (options.button) {
            if (options.button.confirm) {
                confirmButton.value.label = options.button.confirm;
            }
            if (options.button.cancel) {
                cancelButton.value.label = options.button.cancel;
            }
        }
        
        isOpen.value = true;
        
        return new Promise((resolve, reject) => {
            resolvePromise = resolve;
            rejectPromise = reject;
            
            // Si des callbacks spécifiques sont fournis, les utiliser
            if (options.onConfirm) {
                resolvePromise = () => {
                    resolve(true);
                    options.onConfirm();
                };
            }
            
            if (options.onCancel) {
                rejectPromise = () => {
                    reject();
                    options.onCancel();
                };
            }
        });
    };
    
    /**
     * Confirme le dialogue et exécute la fonction de rappel
     */
    const handleConfirm = () => {
        isOpen.value = false;
        if (resolvePromise) {
            resolvePromise(true);
        }
    };
    
    /**
     * Annule le dialogue et exécute la fonction de rappel d'annulation
     */
    const handleCancel = () => {
        isOpen.value = false;
        if (rejectPromise) {
            rejectPromise();
        }
    };
    
    /**
     * Affiche le composant de dialogue de confirmation
     * À utiliser dans le template
     */
    const ConfirmDialog = {
        setup() {
            return {
                isOpen,
                title,
                message,
                confirmButton,
                cancelButton,
                handleConfirm,
                handleCancel,
            };
        },
        template: `
            <div v-if="isOpen" class="modal is-active">
                <div class="modal-background" @click="handleCancel"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">{{ title }}</p>
                        <button class="delete" aria-label="close" @click="handleCancel"></button>
                    </header>
                    <section class="modal-card-body">
                        {{ message }}
                    </section>
                    <footer class="modal-card-foot">
                        <button :class="['button', confirmButton.class]" @click="handleConfirm">
                            {{ confirmButton.label }}
                        </button>
                        <button :class="['button', cancelButton.class]" @click="handleCancel">
                            {{ cancelButton.label }}
                        </button>
                    </footer>
                </div>
            </div>
        `,
    };
    
    return {
        isOpen,
        title,
        message,
        confirmButton,
        cancelButton,
        confirm,
        handleConfirm,
        handleCancel,
        ConfirmDialog,
    };
}
