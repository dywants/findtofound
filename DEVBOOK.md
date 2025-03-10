# DEVBOOK - Journal de développement

## Date : 02/03/2025

## Améliorations UI/UX pour RegisterIntro.vue

Ce document trace les améliorations à apporter à la vue RegisterIntro.vue, suivant l'analyse effectuée sur sa structure, son CSS et son design.

### Structure

-   [x] Extraire les sections répétitives en composants réutilisables
    -   [x] Créer un composant `ProcessStep.vue` pour les étapes du processus
    -   [x] Créer un composant `OptionCard.vue` pour les options de sélection
    -   [x] Refactoriser la vue pour utiliser ces composants

### Système de couleurs

-   [x] Créer une palette de couleurs plus riche et cohérente
    -   [x] Définir des variables CSS pour les couleurs primaires, secondaires et d'accentuation
    -   [x] Ajouter des nuances pour les états hover/active
    -   [x] Standardiser l'utilisation des couleurs à travers l'interface

### Typographie et espacement

-   [x] Définir une hiérarchie typographique plus claire
    -   [x] Standardiser les tailles de texte pour les titres, sous-titres et corps de texte
    -   [x] Créer des classes utilitaires pour les différentes tailles de texte
    -   [x] Uniformiser les espacements entre les éléments
-   [x] Standardiser les marges et les espacements
    -   [x] Créer un système d'espacement cohérent (8px, 16px, 24px, etc.)
    -   [x] Appliquer ce système à tous les éléments de l'interface

### Composants UI

-   [x] Améliorer les boutons et les éléments interactifs
    -   [x] Ajouter des animations au survol et au clic
    -   [x] Standardiser les styles de boutons (primaire, secondaire, tertiaire)
    -   [x] Ajouter des états disabled et loading
-   [x] Enrichir les cartes d'options
    -   [x] Ajouter des icônes pour chaque point des listes
    -   [x] Améliorer la visualisation de l'état sélectionné
    -   [x] Ajouter une animation de transition lors de la sélection
-   [x] Développer un système d'icônes cohérent
    -   [x] Créer un composant `Icon.vue` réutilisable qui intègre directement les SVG
    -   [x] Implémenter des versions outline (contour) et solid (plein) pour chaque icône
    -   [x] Développer une bibliothèque d'icônes de base (check, user, document, search, map-pin, bell, chevron-down)
    -   [x] Assurer la personnalisation des icônes (taille, couleur, classe CSS)
    -   [x] Créer une page `IconTest.vue` pour présenter et tester toutes les icônes disponibles

### Adaptabilité mobile

-   [x] Renforcer la réactivité pour tous les éléments
    -   [x] Optimiser la disposition pour les petits écrans
    -   [x] Ajuster les tailles de texte et les espacements sur mobile
    -   [x] Ajouter des classes utilitaires pour la responsivité

### Améliorations visuelles

-   [x] Ajouter des illustrations et des éléments graphiques
    -   [x] Intégrer des icônes pour chaque étape du processus
    -   [ ] Utiliser des gradients pour l'en-tête au lieu d'une couleur unie
    -   [x] Ajouter des micro-animations pour les interactions
-   [ ] Améliorer les effets visuels
    -   [ ] Raffiner les ombres pour plus de profondeur
    -   [ ] Standardiser les rayons d'arrondi des éléments
    -   [x] Ajouter des animations subtiles pour les transitions d'état

### Expérience utilisateur

-   [x] Améliorer l'interface avec un système d'icônes cohérent
    -   [x] Créer un composant `Icon` réutilisable pour l'ensemble de l'application
    -   [x] Implémenter à la fois des versions "outline" et "solid" des icônes
    -   [x] Intégrer les icônes dans les composants existants comme `ProcessStep` et `OptionCard`
    -   [x] Créer une page de test (`IconTest`) pour visualiser toutes les icônes disponibles
-   [ ] Implémenter des indicateurs de progression
    -   [ ] Ajouter une barre de progression pour montrer l'étape actuelle
    -   [ ] Afficher le nombre d'étapes restantes
    -   [x] Améliorer le composant `ProcessStep` avec des icônes pour illustrer chaque étape
    -   [ ] Ajouter des animations de transition entre les étapes
-   [ ] Améliorer le feedback utilisateur
    -   [ ] Ajouter des tooltips pour fournir des informations supplémentaires
    -   [ ] Implémenter des messages de confirmation pour les actions
    -   [x] Utiliser des icônes pour communiquer visuellement l'état et les actions disponibles
-   [ ] Optimiser l'expérience mobile
    -   [ ] Assurer que tous les éléments d'interface sont facilement cliquables sur mobile
    -   [ ] Ajuster l'espacement et la taille des icônes pour une meilleure expérience sur les petits écrans
    -   [ ] Tester la réactivité sur différentes tailles d'écran

### Accessibilité

-   [ ] Améliorer l'accessibilité générale
    -   [ ] Augmenter le contraste des couleurs pour une meilleure lisibilité
    -   [ ] Ajouter des attributs ARIA appropriés
    -   [ ] S'assurer que tous les éléments interactifs sont accessibles au clavier
-   [ ] Tester avec des outils d'accessibilité
    -   [ ] Analyser avec des outils comme Lighthouse ou axe
    -   [ ] Corriger les problèmes d'accessibilité identifiés

### Optimisations techniques

-   [ ] Mettre en place des transitions Vue
    -   [ ] Utiliser `<transition>` et `<transition-group>` pour les changements d'état
    -   [ ] Optimiser les animations pour de meilleures performances
-   [ ] Refactoriser le code CSS
    -   [ ] Extraire les styles répétitifs en classes utilitaires personnalisées
    -   [ ] Utiliser des variables CSS pour les valeurs récurrentes
    -   [ ] Nettoyer les classes inutilisées et redondantes

### Implémentation technique du système d'icônes

#### Approche et architecture

Le système d'icônes a été implémenté en suivant ces principes :

1. **Intégration directe des SVG** : Plutôt que de charger dynamiquement les icônes ou d'utiliser des bibliothèques externes, nous avons opté pour l'intégration directe des SVG dans le composant `Icon.vue`. Cette approche :

    - Élimine les problèmes de chargement des icônes
    - Réduit les dépendances externes
    - Simplifie l'architecture
    - Facilite la maintenance (toutes les icônes sont dans un seul fichier)

2. **Variantes d'icônes** : Chaque icône est disponible en deux variantes :

    - **Outline** : Version avec contours, adaptée pour la majorité des états
    - **Solid** : Version pleine, pour indiquer les états actifs ou mettre en évidence des éléments

3. **Personnalisation** : Le composant `Icon` accepte plusieurs props pour personnaliser l'apparence :

    - `name` : Nom de l'icône à afficher (requis)
    - `size` : Taille de l'icône en pixels (défaut: 24)
    - `color` : Couleur de l'icône (défaut: currentColor)
    - `solid` : Boolean pour choisir entre version outline et solid (défaut: false)
    - `customClass` : Classes CSS additionnelles
    - `showTitle` : Affiche le nom de l'icône dans un élément title pour l'accessibilité

4. **Dégradation élégante** : Si une icône demandée n'existe pas, un placeholder est affiché avec le nom de l'icône, assurant une expérience utilisateur sans interruption

#### Intégration dans les composants existants

Le système d'icônes a été intégré dans plusieurs composants clés :

1. **ProcessStep** : Utilise des icônes pour représenter visuellement chaque étape du processus, avec une transition entre outline et solid lors du survol

2. **OptionCard** : Intègre des icônes pour chaque point des listes de fonctionnalités, avec la possibilité de spécifier des icônes personnalisées pour chaque élément

#### Tests et démonstration

Une page dédiée `IconTest.vue` a été créée pour :

-   Présenter toutes les icônes disponibles dans les deux variantes
-   Démontrer l'intégration avec les composants comme `OptionCard`
-   Tester le comportement du placeholder pour les icônes non existantes

Cette page est accessible via l'URL `/icon-test` et sert à la fois de documentation visuelle et d'outil de développement pour l'équipe.

### Modernisation de la page d'introduction à l'enregistrement (RegisterIntro.vue)

#### Problèmes identifiés avec la version actuelle :

1. Design peu moderne et manque d'attrait visuel
2. Structure de page trop linéaire qui ne met pas en évidence les différents parcours utilisateur
3. Absence d'illustrations pour les étapes qui rendraient le processus plus compréhensible
4. Manque de clarté concernant les parcours différenciés selon le choix de l'utilisateur (avec/sans récompense)
5. Navigation et flux utilisateur peu intuitifs

#### Plan d'amélioration

##### Étape 1 : Refonte visuelle et structurelle

-   [x] Repenser la mise en page avec un design plus moderne et aéré

    -   [x] Créer un layout en sections horizontales plutôt qu'une carte unique
    -   [x] Utiliser des arrèts de couleurs suaves et des dégradés pour améliorer l'esthétique
    -   [x] Intégrer plus d'espace blanc pour améliorer la lisibilité

-   [x] Ajouter des illustrations pour chaque étape du processus
    -   [x] Créer/intégrer une illustration pour l'étape "Informations sur l'objet trouvé"
    -   [ ] Créer/intégrer des illustrations différenciées pour les chemins avec/sans récompense
    -   [x] Créer/intégrer une illustration pour l'étape de validation et confirmation

##### Étape 2 : Visualisation claire des deux parcours utilisateur

-   [x] Restructurer l'affichage des étapes pour montrer clairement la divergence après l'étape 1

    -   [x] Créer un diagramme de flux visuel montrant les deux chemins possibles
    -   [x] Utiliser un système de couleurs différenciées pour chaque parcours

-   [x] Clarifier les deux options après l'étape 1
    -   [x] Pour l'option "avec récompense" : Mettre en évidence l'étape de création de compte et le processus pour recevoir la récompense
    -   [x] Pour l'option "sans récompense" : Illustrer clairement l'étape de renseignement de l'emplacement où l'objet a été déposé

##### Étape 3 : Amélioration de l'interactivité et de l'UX

-   [ ] Implémenter un sélecteur de parcours plus interactif

    -   [ ] Remplacer les cartes d'option statiques par un sélecteur visuel plus engageant
    -   [ ] Ajouter des animations de transition lorsque l'utilisateur sélectionne un parcours

-   [ ] Améliorer la navigation dans le processus
    -   [ ] Créer une barre de progression visuelle indiquant où se trouve l'utilisateur dans le processus
    -   [ ] Ajouter des boutons de navigation plus intuitifs avec animations
    -   [ ] Implémenter des transitions fluides entre les étapes

##### Étape 4 : Optimisation technique et performance

-   [ ] Optimiser le chargement des illustrations

    -   [ ] Utiliser des formats d'image optimisés (SVG ou WebP)
    -   [ ] Implémenter un chargement paresseux des illustrations

-   [ ] Assurer la compatibilité mobile
    -   [ ] Concevoir une expérience responsive spécifique pour les appareils mobiles
    -   [ ] Tester et optimiser sur différentes tailles d'écran

### Bénéfices attendus

1. **Amélioration de l'expérience utilisateur** : Processus plus clair et plus agréable visuellement
2. **Augmentation des taux de conversion** : Moins d'abandon grâce à un parcours plus intuitif
3. **Meilleure compréhension des options** : Utilisateurs mieux informés sur les implications de leurs choix
4. **Cohérence visuelle avec le système d'icônes** : Intégration harmonieuse avec les améliorations déjà réalisées
5. **Interface plus moderne** : Alignement avec les standards actuels de design web

## Suivi des implémentations

| Date       | Fonctionnalité                                                          | Statut   | Notes                                                                                                                                                                                                                                                                                                                                                                                            |
| ---------- | ----------------------------------------------------------------------- | -------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| 02/03/2025 | Structure des composants                                                | Terminé  | Création de ProcessStep.vue et OptionCard.vue pour une meilleure réutilisabilité. Refactorisation de RegisterIntro.vue pour utiliser ces composants.                                                                                                                                                                                                                                             |
| 02/03/2025 | Système de couleurs                                                     | Terminé  | Création d'un fichier variables.css avec une palette de couleurs complète. Intégration des variables dans la configuration Tailwind et ajout de nouveaux styles de boutons.                                                                                                                                                                                                                      |
| 03/03/2025 | Typographie et espacement                                               | Terminé  | Création de fichiers \_typography.css et \_spacing.css avec des classes utilitaires standardisées. Application de ces classes aux composants existants pour assurer une cohérence visuelle.                                                                                                                                                                                                      |
| 03/03/2025 | Composants UI                                                           | Terminé  | Amélioration des boutons avec des animations, effets de ripple et états de chargement. Enrichissement des cartes d'options avec des icônes et des animations interactives. Mise à jour du composant ProcessStep avec des transitions et animations.                                                                                                                                              |
| 03/03/2025 | Adaptabilité mobile                                                     | Terminé  | Optimisation des composants pour les écrans mobiles avec des classes responsive, ajustement des tailles de texte et des espacements. Création d'un fichier \_responsive.css avec des utilitaires spécifiques pour la responsivité. Refactorisation des composants principaux (OptionCard, ProcessStep, RegisterIntro) pour garantir une expérience utilisateur cohérente sur tous les appareils. |
| 03/03/2025 | Système d'icônes                                                        | Terminé  | Création d'un composant Icon réutilisable supportant les icônes outline et solid. Mise en place d'une bibliothèque d'icônes organisée en deux styles (Outline et Solid). Intégration des icônes dans les composants ProcessStep et OptionCard pour améliorer l'aspect visuel et l'expérience utilisateur. Création d'un composant IconShowcase pour présenter toutes les icônes disponibles.     |
| 04/03/2025 | Amélioration du système d'icônes                                        | Terminé  | Résolution du problème d'affichage des icônes en intégrant directement les SVG dans le composant Icon plutôt que de les charger dynamiquement. Création d'une page de test (IconTest) pour visualiser toutes les icônes disponibles. Amélioration de la gestion des icônes manquantes avec un placeholder informatif. Optimisation de la performance en éliminant les imports dynamiques.        |
| 04/03/2025 | Planification de modernisation de RegisterIntro.vue                     | En cours | Identification des problèmes d'UX/UI dans la page d'introduction à l'enregistrement. Définition d'un plan de refonte complète en 4 étapes : refonte visuelle, visualisation des parcours utilisateur, amélioration de l'interactivité et optimisations techniques. Plan de travail détaillé ajouté au DEVBOOK.md.                                                                                |
| 02/03/2025 | Étape 1 : Refonte visuelle de RegisterIntro.vue                         | Terminé  | Refonte complète de la mise en page avec un design plus moderne et aéré. Création d'un layout en sections horizontales avec dégradés et espaces blancs. Intégration d'illustrations pour les étapes du processus avec des icônes pertinentes. Amélioration des animations et des transitions.                                                                                                    |
| 02/03/2025 | Étape 2 : Visualisation des parcours utilisateur dans RegisterIntro.vue | Terminé  | Création d'un diagramme de flux visuel montrant clairement les deux chemins possibles (avec/sans récompense). Mise en place d'un système de couleurs différenciées (bleu pour le parcours avec récompense, vert pour le parcours anonyme). Détails des étapes spécifiques à chaque parcours avec descriptions claires et icones numérotées.                                                      |

## Améliorations pour TheSearch.vue

Ce document trace les améliorations potentielles à apporter à la vue TheSearch.vue, suite à l'analyse de sa structure et de ses fonctionnalités.

## Améliorations pour TheRegisterInfoFounder.vue

Ce document présente les améliorations potentielles pour la page TheRegisterInfoFounder.vue, qui permet aux utilisateurs de finaliser leurs informations de contact et de procéder au paiement pour récupérer un objet perdu.

## Améliorations pour TheShowFind.vue

Ce document trace les améliorations à apporter à la vue TheShowFind.vue, qui affiche les détails d'une pièce retrouvée.

### Structure et organisation du code

-   [x] Extraire les sections répétitives en composants réutilisables
    -   [x] Créer un composant `BreadcrumbNav.vue` pour le fil d'Ariane
    -   [x] Créer un composant `DetailCard.vue` pour la présentation des informations

### Amélioration de la galerie d'images

-   [x] Améliorer la galerie de photos avec Splide
    -   [x] Intégrer la gestion de plusieurs photos (actuellement une seule slide est affichée)
    -   [x] Ajouter des miniatures pour la navigation entre les images
    -   [x] Implémenter une fonction de zoom sur les images
    -   [x] Ajouter une vue plein écran pour les images

### Enrichissement de l'interface utilisateur

-   [x] Améliorer la mise en page des informations
    -   [x] Organiser les détails en sections thématiques (informations générales, emplacement, etc.)
    -   [x] Ajouter des icônes pour chaque catégorie d'information
    -   [x] Utiliser des badges pour mettre en évidence les informations importantes
-   [x] Enrichir la section de localisation
    -   [x] Intégrer une carte interactive montrant l'emplacement de la pièce
    -   [x] Ajouter un indicateur de distance par rapport à la position de l'utilisateur

### Interactions et fonctionnalités

-   [x] Améliorer l'expérience utilisateur
    -   [x] Ajouter une fonctionnalité de partage sur les réseaux sociaux
    -   [x] Implémenter un système pour signaler un problème concernant cette pièce
    -   [ ] Ajouter une option pour contacter directement le propriétaire
-   [ ] Optimiser le processus de validation
    -   [ ] Ajouter une prévisualisation des étapes de validation avant de cliquer sur le bouton
    -   [ ] Implémenter une confirmation avant validation
    -   [ ] Ajouter des indicateurs d'état pour suivre le processus de validation

### Adaptabilité et accessibilité

-   [x] Améliorer la réactivité sur mobile
    -   [x] Optimiser la disposition pour les petits écrans (agencement vertical au lieu de horizontal)
    -   [x] Adapter la taille des éléments pour une meilleure expérience tactile
-   [x] Renforcer l'accessibilité
    -   [x] Ajouter des attributs ARIA appropriés
    -   [x] Améliorer le contraste des couleurs
    -   [x] Assurer que tous les éléments interactifs sont accessibles au clavier

### Optimisations techniques

-   [x] Améliorer les performances
    -   [x] Optimiser le chargement des images (images responsive, lazy loading)
    -   [x] Implémenter le chargement progressif des contenus
-   [x] Refactoriser le code CSS
    -   [x] Extraire les styles répétitifs en classes utilitaires
    -   [x] Utiliser des variables CSS pour les valeurs récurrentes
    -   [x] Standardiser les styles avec le reste de l'application

### Performance et UX

-   [x] Optimiser la recherche

    -   [x] Implémenter un debounce sur l'input de recherche pour éviter des recherches excessives pendant la saisie
    -   [x] Ajouter un indicateur de chargement pendant que les résultats sont filtrés
    -   [x] Mémoriser les termes de recherche récents pour accélérer les recherches répétées

-   [x] Améliorer le retour utilisateur
    -   [x] Afficher le nombre de résultats trouvés (ex: "7 résultats pour 'carte d'identité'")
    -   [x] Ajouter des filtres supplémentaires (date, type de document, ville)
    -   [x] Permettre le tri des résultats (par date, par pertinence)

### UI et Design

-   [x] Moderniser l'interface des résultats

    -   [x] Proposer une vue alternative en grille en plus de la vue liste
    -   [x] Ajouter un bouton pour basculer entre les vues liste et grille
    -   [x] Améliorer l'affichage des images (gestion des ratios, lazy loading optimisé)

-   [x] Améliorer la présentation des résultats
    -   [x] Reformater la date pour une meilleure lisibilité
    -   [ ] Ajouter des badges colorés pour différents types de documents
    -   [ ] Améliorer la mise en évidence des termes recherchés dans les résultats

### Accessibilité

-   [x] Renforcer l'accessibilité

    -   [x] Ajouter des attributs ARIA appropriés (aria-label, aria-live)
    -   [x] Améliorer la navigation au clavier
    -   [x] S'assurer que les contrastes de couleurs sont suffisants

-   [x] Optimiser pour tous les appareils
    -   [x] Améliorer la disposition sur les très petits écrans
    -   [x] Optimiser l'expérience tactile (plus grandes zones de clic)

### Fonctionnalités additionnelles

## Plan d'amélioration pour TheRegisterInfoFounder.vue

### Structure et organisation du code

-   [x] Refactoriser la page en composants réutilisables
    -   [x] Créer un composant `ProgressStepper.vue` pour la barre de progression
    -   [x] Créer un composant `UserInfoForm.vue` pour le formulaire d'information
    -   [x] Créer un composant `InfoSummary.vue` pour afficher le résumé des informations
    -   [x] Créer un composant `PaymentOptions.vue` pour les options de paiement
    -   [x] Refactoriser la page principale pour utiliser ces composants

### Améliorations UI/UX

-   [x] Moderniser l'interface utilisateur
    -   [x] Améliorer la présentation des étapes de progression
        -   [x] Ajouter des animations pour les transitions entre étapes
        -   [x] Utiliser des icônes descriptives pour chaque étape
        -   [ ] Implémenter un pourcentage de progression visuel
    -   [x] Enrichir l'affichage des options de paiement
        -   [x] Ajouter des effets d'interaction plus modernes (hover, focus, active)
        -   [x] Standardiser la taille des logos des méthodes de paiement
        -   [x] Intégrer des badges ou indicateurs pour les moyens de paiement sélectionnés
    -   [x] Améliorer le formulaire d'informations
        -   [x] Ajouter la validation en temps réel des champs (format d'email, numéro de téléphone, etc.)
        -   [ ] Implémenter l'auto-complétion pour le champ ville avec une liste prédéfinie
        -   [x] Ajouter des suggestions d'erreur plus descriptives

### Expérience utilisateur

-   [x] Optimiser le flux de paiement
    -   [x] Simplifier le processus en minimisant les étapes
    -   [ ] Ajouter une fonctionnalité de sauvegarde automatique des informations (localStorage)
    -   [x] Implémenter un indicateur de sécurité du paiement
    -   [x] Ajouter un récapitulatif clair des frais et de la récompense
-   [x] Améliorer les retours d'information
    -   [ ] Ajouter des notifications de succès/échec plus visibles
    -   [x] Intégrer des animations de chargement pendant le traitement
    -   [x] Confirmer visuellement chaque étape complétée
-   [x] Enrichir les informations contextuelles
    -   [x] Ajouter des tooltips explicatifs pour les différentes options de paiement
    -   [ ] Inclure une FAQ directement accessible depuis la page
    -   [x] Fournir des informations claires pour chaque moyen de paiement

### Adaptabilité et responsive design

-   [x] Renforcer l'adaptabilité mobile
    -   [x] Optimiser la disposition des formulaires sur petits écrans
    -   [x] Adapter la présentation des méthodes de paiement pour l'affichage vertical
    -   [x] Améliorer l'accessibilité des boutons et des champs sur mobile
-   [ ] Améliorer la compatibilité multi-navigateurs
    -   [ ] Tester et optimiser sur différents navigateurs (Chrome, Firefox, Safari, Edge)
    -   [x] Assurer une expérience cohérente quelle que soit la plateforme

### Intégration technique et optimisations

-   [x] Améliorer l'intégration des passerelles de paiement
    -   [x] Moderniser l'intégration PayPal avec une interface utilisateur améliorée
    -   [x] Optimiser l'affichage des options de paiement (affichage conditionnel)
    -   [ ] Améliorer la gestion des erreurs de paiement
-   [x] Optimiser les performances
    -   [ ] Implémenter le chargement différé des ressources externes
    -   [x] Optimiser les transitions et animations pour de meilleures performances
    -   [x] Utiliser des transitions CSS pour des animations fluides

### Accessibilité

-   [ ] Renforcer l'accessibilité WCAG
    -   [ ] Améliorer la navigation au clavier
    -   [ ] Ajouter des attributs ARIA appropriés
    -   [ ] Assurer un contraste suffisant pour tous les éléments de texte
    -   [ ] Fournir des alternatives textuelles pour les éléments visuels

### Tableau de bord de progression

| Date       | Tâche                            | Statut  | Description                                                                           |
| ---------- | -------------------------------- | ------- | ------------------------------------------------------------------------------------- |
| 02/03/2025 | Refactorisation en composants    | Terminé | Décomposition de la page en composants réutilisables pour améliorer la maintenabilité |
|            | Modernisation de l'interface     | À faire | Améliorer l'aspect visuel et l'expérience utilisateur                                 |
|            | Optimisation du flux de paiement | À faire | Simplifier et sécuriser le processus de paiement                                      |
|            | Adaptation mobile                | À faire | Assurer une expérience optimale sur tous les appareils                                |
|            | Amélioration de l'accessibilité  | À faire | Rendre la page conforme aux normes WCAG                                               |

-   [ ] Implémenter des fonctionnalités avancées

    -   [ ] Ajouter la géolocalisation pour trouver les objets perdus à proximité
    -   [ ] Permettre une recherche par carte interactive
    -   [ ] Ajouter des suggestions de recherche basées sur les termes populaires

-   [ ] Enrichir l'expérience utilisateur
    -   [ ] Implémenter l'historique de recherche personnel
    -   [ ] Permettre de sauvegarder des recherches favorites
    -   [ ] Ajouter des notifications pour les nouvelles pièces correspondant aux critères précédemment recherchés

### Optimisations techniques

-   [x] Refactoriser pour plus de maintenabilité

    -   [x] Extraire la logique de recherche dans un composable Vue réutilisable
    -   [x] Améliorer la configuration de Fuse.js pour des résultats plus pertinents
    -   [ ] Standardiser l'affichage des résultats dans un composant dédié

-   [x] Optimiser les performances
    -   [ ] Implémenter une pagination ou un infinite scroll pour les grands volumes de résultats
    -   [x] Mettre en cache les résultats de recherche récents
    -   [ ] Optimiser le rendu des listes avec `v-for` (utiliser `v-memo` pour les éléments stables)

## Journal des améliorations de TheSearch.vue

| Date       | Description                                                                               | Auteur |
| ---------- | ----------------------------------------------------------------------------------------- | ------ |
| 02/03/2025 | Ajout du debounce, d'un indicateur de chargement et de l'affichage du nombre de résultats |        |
| 02/03/2025 | Implémentation des filtres par date et options de tri                                     |        |
| 02/03/2025 | Ajout d'une vue alternative en grille avec bascule entre les modes d'affichage            |        |
| 02/03/2025 | Amélioration de l'accessibilité avec attributs ARIA et focus styles                       |        |
| 02/03/2025 | Refactorisation de la logique de recherche dans un composable Vue réutilisable            |        |

## Notes et idées supplémentaires

-   Envisager l'utilisation d'une bibliothèque d'animations comme GSAP pour des transitions plus fluides
-   Intégrer un système de reconnaissance d'image pour faciliter la recherche de pièces similaires
-   Explorer l'utilisation d'une API de géolocalisation pour améliorer la recherche par proximité
-   Explorer la possibilité d'ajouter un mode sombre
-   Considérer l'ajout de préférences utilisateur pour personnaliser l'interface

## Améliorations pour Contact.vue

Ce document liste les améliorations à apporter à la page Contact.vue, afin de la moderniser et d'offrir une meilleure expérience utilisateur.

### Structure et organisation du code

-   [x] Refactoriser la structure du composant
    -   [x] Extraire des composants réutilisables pour l'information de contact (ContactInfo.vue)
    -   [x] Créer un composant dédié pour le formulaire de contact (ContactForm.vue)
    -   [x] Organiser les imports et les styles selon les standards du projet

### Enrichissement des fonctionnalités

-   [x] Implémenter un formulaire de contact interactif
    -   [x] Créer des champs pour nom, email, sujet et message
    -   [x] Ajouter des validations en temps réel pour les champs de formulaire
    -   [x] Intégrer un système de feedback visuel (succès, erreur, chargement)
-   [x] Ajouter des fonctionnalités d'interaction
    -   [x] Implémenter la copie en un clic pour les informations de contact
    -   [x] Intégrer des liens directs pour l'email et le téléphone
    -   [x] Ajouter des animations pour améliorer l'interactivité

### Améliorations UX/UI

-   [x] Moderniser l'interface utilisateur
    -   [x] Créer une mise en page plus équilibrée entre les informations et le formulaire
    -   [x] Ajouter un arrière-plan avec un design plus moderne (motifs ou formes géométriques subtiles)
    -   [x] Intégrer une carte interactive Google Maps
-   [x] Améliorer les éléments visuels
    -   [x] Utiliser le système d'icônes cohérent développé pour l'application
    -   [x] Standardiser les couleurs selon la palette définie pour l'application
    -   [x] Ajouter des effets de survol et des micro-animations pour les éléments interactifs

### Adaptabilité et accessibilité

-   [x] Optimiser pour les appareils mobiles
    -   [x] Revoir l'agencement pour offrir une meilleure expérience sur petits écrans
    -   [x] Ajuster les tailles de police et les espacements pour la lisibilité mobile
    -   [x] Assurer que tous les éléments restent accessibles et fonctionnels sur mobile
-   [x] Renforcer l'accessibilité
    -   [x] Ajouter des attributs ARIA appropriés
    -   [x] Améliorer les contrastes de couleurs
    -   [x] S'assurer que tous les éléments sont navigables au clavier

### Intégration à l'écosystème de l'application

-   [x] Standardisation avec les autres pages
    -   [x] Utiliser le même système de mise en page que les autres pages améliorées
    -   [x] Intégrer les composants partagés et la cohérence visuelle
    -   [x] Respecter la charte stylistique établie (typographie, espacement, couleurs)
-   [x] Ajouter des fonctionnalités avancées
    -   [x] Intégrer une carte interactive pour l'emplacement physique
    -   [x] Ajouter une section FAQ interactive avec accordéon
    -   [ ] Intégrer un système de prise de rendez-vous ou de chat en direct (optionnel)

### Tableau de bord de progression

| Date       | Tâche                                   | Statut  | Description                                                                                                                                                        |
| ---------- | --------------------------------------- | ------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| 02/03/2025 | Analyse initiale de Contact.vue         | Terminé | Identification des opportunités d'amélioration et planification des étapes                                                                                         |
| 02/03/2025 | Refactorisation en composants           | Terminé | Décomposition réussie de la page en composants réutilisables (ContactInfo.vue, ContactForm.vue) et remplacement de la page statique par une version plus modulaire |
| 02/03/2025 | Implémentation du formulaire interactif | Terminé | Création d'un formulaire de contact complet avec validation, feedback visuel et focus interactif                                                                   |
| 02/03/2025 | Modernisation de l'interface            | Terminé | Refonte complète de l'UI avec animations, arrière-plans stylisés et carte interactive                                                                              |
| 02/03/2025 | Optimisation pour mobile                | Terminé | Mise en page responsive et adaptation des éléments pour tous appareils                                                                                             |
| 02/03/2025 | Section FAQ interactive                 | Terminé | Implémentation d'un système d'accordéon pour les questions fréquentes                                                                                              |

## Création d'une page d'accueil pour la protection de documents

Ce document trace les étapes pour créer une page d'accueil dédiée à la fonctionnalité de protection de documents, afin d'améliorer l'expérience utilisateur et de fournir un contexte clair avant l'utilisation de l'outil.

### Contexte

Actuellement, la fonctionnalité de protection de documents (DocuTrace) est accessible directement via la page Protect.vue qui combine à la fois l'explication de la fonctionnalité et l'interface utilisateur pour protéger les documents. Cette approche manque d'une introduction claire et d'un parcours utilisateur progressif.

### Objectifs

-   Créer une page d'accueil dédiée qui explique clairement le but et les avantages de la protection de documents
-   Améliorer l'expérience utilisateur en établissant un parcours progressif
-   Mettre en valeur les fonctionnalités clés de la protection de documents
-   Maintenir la cohérence avec les améliorations UX/UI déjà implémentées dans d'autres parties de l'application

### Plan d'implémentation

#### Étape 1 : Conception de la structure de la page d'accueil

-   [x] Concevoir une mise en page moderne et attrayante pour la page d'accueil
    -   [x] Créer une section d'en-tête avec une illustration représentative et un message d'accroche
    -   [x] Développer une section expliquant le concept de protection de documents
    -   [x] Créer une section présentant les fonctionnalités clés avec des icônes
    -   [x] Concevoir une section des avantages de la protection de documents
    -   [x] Ajouter une section FAQ pour répondre aux questions communes
    -   [x] Intégrer un appel à l'action clair pour rediriger vers la page de protection

#### Étape 2 : Mise en œuvre technique

-   [x] Créer un nouveau composant Vue pour la page d'accueil (DocumentsHome.vue)
    -   [x] Implémenter la structure HTML/CSS de base selon la conception
    -   [x] Intégrer les composants existants (comme les icônes)
    -   [x] Ajouter des animations et transitions pour une expérience utilisateur engageante
-   [x] Modifier les routes pour intégrer la nouvelle page
    -   [x] Ajouter une nouvelle route pour la page d'accueil dans web.php
    -   [x] Mettre à jour la navigation pour inclure un lien vers cette page
    -   [x] Ajuster la route existante pour rediriger vers la nouvelle page d'accueil

#### Étape 3 : Optimisation de l'expérience utilisateur

-   [x] Améliorer la navigation entre les pages de la fonctionnalité
    -   [x] Ajouter un fil d'Ariane (breadcrumb) pour faciliter la navigation
    -   [x] Créer des boutons d'action clairs avec des états de survol dynamiques
-   [x] Enrichir le contenu informatif
    -   [x] Ajouter des exemples visuels de documents protégés
    -   [x] Créer des infographies illustrant le processus de protection
    -   [ ] Intégrer des témoignages d'utilisateurs (optionnel)

#### Étape 4 : Tests et optimisations

-   [x] Tester la réactivité sur différents appareils
    -   [x] Optimiser la mise en page pour les appareils mobiles
    -   [x] Assurer la compatibilité avec différents navigateurs
-   [x] Effectuer des tests d'accessibilité
    -   [x] Vérifier le contraste des couleurs
    -   [x] Ajouter les attributs ARIA appropriés
    -   [x] Tester la navigation au clavier

#### Étape 5 : Finalisation et déploiement

-   [x] Revoir le contenu et effectuer les ajustements finaux
    -   [x] Corriger les problèmes identifiés lors des tests
    -   [x] Affiner les textes et les messages
-   [x] Finaliser la fonctionnalité
    -   [x] Mettre à jour la documentation
    -   [x] Préparer la fonctionnalité pour le déploiement

### Tableau de bord de progression

| Date       | Tâche                                                            | Statut   | Description                                                                                                                                                                                                                                                                                                                                                                                                    |
| ---------- | ---------------------------------------------------------------- | -------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 02/03/2025 | Analyse initiale de la fonctionnalité de protection de documents | Terminé  | Évaluation de la structure actuelle et identification du besoin d'une page d'accueil                                                                                                                                                                                                                                                                                                                           |
| 03/03/2025 | Implémentation de la prévisualisation des documents              | Terminé  | Ajout d'une fonctionnalité de prévisualisation pour les documents téléversés avec support pour les images (affichage direct) et les PDF (avec lien d'ouverture). Correction des bugs liés à la manipulation des fichiers et amélioration de l'expérience utilisateur avec adaptation dynamique de l'interface.                                                                                                 |
| 03/03/2025 | Enrichissement de la présentation des documents protégés         | Terminé  | Refonte complète de l'affichage des documents pour utiliser un format de grille de cartes visuelles. Ajout de miniatures pour les images et icones différenciés pour les PDF et autres fichiers. Intégration de badges de type pour les différents formats (PDF, JPEG, etc.), d'animations au survol et d'options de tri et d'affichage. Amélioration générale de l'expérience utilisateur et de l'esthétique. |
| 03/03/2025 | Implémentation du filigranage PDF                                | Terminé  | Ajout de la fonctionnalité de filigranage pour les documents PDF en utilisant FPDI/FPDF avec rotation et transparence du texte. Création d'une classe ExtendedFpdi pour étendre les fonctionnalités de base.                                                                                                                                                                                                   |
| 03/03/2025 | Plan d'améliorations pour Documents/Protect.vue                  | En cours | Élaboration d'un plan détaillé pour améliorer l'interface et l'expérience utilisateur de la page de protection de documents                                                                                                                                                                                                                                                                                    |
| 02/03/2025 | Planification des améliorations                                  | Terminé  | Élaboration du plan détaillé pour la création de la page d'accueil DocumentsHome.vue                                                                                                                                                                                                                                                                                                                           |
| 02/03/2025 | Conception de la page d'accueil                                  | Terminé  | Création du composant Home.vue avec toutes les sections requises : en-tête, guide étape par étape, avantages, formats supportés et FAQ                                                                                                                                                                                                                                                                         |
| 02/03/2025 | Intégration des icônes                                           | Terminé  | Ajout de nouvelles icônes au composant Icon.vue pour enrichir l'interface utilisateur                                                                                                                                                                                                                                                                                                                          |
| 02/03/2025 | Mise à jour des routes                                           | Terminé  | Ajout d'une nouvelle route pour la page d'accueil et modification du contrôleur                                                                                                                                                                                                                                                                                                                                |
| 02/03/2025 | Intégration dans la navigation                                   | Terminé  | Mise à jour de la barre de navigation pour inclure un lien vers la nouvelle page d'accueil                                                                                                                                                                                                                                                                                                                     |
| 02/03/2025 | Implémentation des animations                                    | Terminé  | Ajout d'animations et transitions pour améliorer l'expérience utilisateur, incluant des animations au défilement avec IntersectionObserver                                                                                                                                                                                                                                                                     |
| 02/03/2025 | Optimisation de la redirection                                   | Terminé  | Mise en place d'une redirection intelligente depuis la page de protection vers la page d'accueil pour les utilisateurs externes                                                                                                                                                                                                                                                                                |
| 02/03/2025 | Intégration du fil d'Ariane                                      | Terminé  | Ajout d'un composant BreadcrumbNav pour améliorer la navigation et l'orientation de l'utilisateur                                                                                                                                                                                                                                                                                                              |
| 02/03/2025 | Amélioration des boutons                                         | Terminé  | Ajout d'icônes et d'animations aux boutons d'action pour une meilleure expérience utilisateur                                                                                                                                                                                                                                                                                                                  |
| 02/03/2025 | Enrichissement visuel                                            | Terminé  | Création d'une section d'exemple avec infographie pour illustrer la protection de documents                                                                                                                                                                                                                                                                                                                    |
| 02/03/2025 | Création du composant InfoCard                                   | Terminé  | Développement d'un composant réutilisable pour l'affichage d'informations avec icônes                                                                                                                                                                                                                                                                                                                          |
| 02/03/2025 | Optimisation mobile                                              | Terminé  | Adaptation de l'interface pour les appareils mobiles avec des tailles de texte et d'espacement responsives                                                                                                                                                                                                                                                                                                     |
| 02/03/2025 | Amélioration de l'accessibilité                                  | Terminé  | Ajout d'attributs ARIA et amélioration de la navigation au clavier                                                                                                                                                                                                                                                                                                                                             |
| 02/03/2025 | Amélioration des messages utilisateur                            | Terminé  | Optimisation des messages de succès, d'erreur et de confirmation pour une meilleure expérience utilisateur                                                                                                                                                                                                                                                                                                     |
| 08/03/2025 | Refonte du modèle de tarification et amélioration des tooltips   | Terminé  | Mise à jour du système de tarification avec un modèle hybride pour les documents protégés (limitation absolue pour le plan gratuit, quota cumulable pour le plan standard). Implémentation d'un système de tooltips amélioré avec apparition au survol, fond sombre et flèche pointant vers l'icône pour une meilleure expérience utilisateur.                                                                 |
| 02/03/2025 | Optimisation SEO                                                 | Terminé  | Ajout de méta-données linguistiques et d'informations Open Graph pour améliorer le référencement                                                                                                                                                                                                                                                                                                               |
| 02/03/2025 | Finalisation du projet                                           | Terminé  | Vérification finale de toutes les fonctionnalités et préparation pour le déploiement                                                                                                                                                                                                                                                                                                                           |

## Améliorations pour Documents/Protect.vue

Ce document détaille les améliorations à apporter à la page de protection de documents (Protect.vue), suite à l'analyse de sa structure et de ses fonctionnalités.

### Structure et organisation du code

-   [x] Refactoriser la structure de la page en composants réutilisables
    -   [x] Créer un composant `DocumentUploader.vue` pour la zone de téléversement de fichiers
    -   [x] Créer un composant `ProtectedDocumentList.vue` pour la liste des documents
    -   [x] Créer un composant `DocumentCard.vue` pour l'affichage individuel des documents
    -   [x] Refactoriser la vue principale pour utiliser ces composants

### Interface utilisateur

-   [x] Améliorer la zone de téléversement

    -   [x] Ajouter un système de glisser-déposer (drag and drop)
    -   [x] Ajouter une prévisualisation des documents téléversés
        -   [x] Prévisualisation directe des images (JPG, PNG, etc.)
        -   [x] Prévisualisation des PDF avec lien pour ouverture dans nouvel onglet
        -   [x] Adaptation dynamique de l'interface selon le type de fichier
    -   [ ] Améliorer les animations de téléversement
    -   [ ] Ajouter un indicateur de progression

-   [x] Enrichir la présentation des documents protégés

    -   [x] Transformer la liste en une grille de cartes visuelles pour chaque document
    -   [x] Intégrer les miniatures des documents quand possible (pour images/PDF)
    -   [x] Ajouter des badges d'état et de type de fichier plus visibles
    -   [x] Améliorer l'interface avec des effets de survol et transitions
    -   [x] Ajouter des options de tri et de filtrage

-   [x] Améliorer les filigranages et options de protection
    -   [ ] Ajouter des préréglages de filigrane (modes confidentiel, brouillon, etc.)
    -   [x] Implémenter le filigranage pour les fichiers PDF avec transparence et rotation
    -   [x] Optimiser la visibilité et le positionnement du filigrane en arrière-plan
    -   [x] Ajuster les options de couleur et d'opacité pour le filigrane
    -   [ ] Proposer des options de protection supplémentaires (mot de passe, expiration)

### Expérience utilisateur

-   [ ] Améliorer les interactions et le feedback

    -   [ ] Ajouter des animations lors des actions (téléversement, téléchargement)
    -   [ ] Améliorer les messages de confirmation et d'erreur
    -   [ ] Ajouter des tooltips explicatifs pour les différentes options
    -   [ ] Intégrer des notifications pour les opérations longues

-   [ ] Faciliter la gestion des documents

    -   [ ] Implémenter la fonctionnalité de recherche dans les documents
    -   [ ] Ajouter un système de tags ou de catégories
    -   [ ] Permettre l'organisation en dossiers ou collections
    -   [ ] Ajouter un historique des versions pour chaque document

-   [ ] Optimiser pour tous les appareils
    -   [ ] Améliorer la vue sur mobile et tablette
    -   [ ] Adapter l'interface de téléversement pour les écrans tactiles
    -   [ ] Assurer une expérience cohérente sur tous les navigateurs

### Accessibilité et performance

-   [ ] Renforcer l'accessibilité

    -   [ ] Ajouter des attributs ARIA appropriés
    -   [ ] Améliorer la navigation au clavier
    -   [ ] S'assurer que les contrastes de couleurs sont suffisants
    -   [ ] Tester avec des lecteurs d'écran

-   [ ] Optimiser les performances
    -   [ ] Implémenter le chargement paresseux (lazy loading) pour les documents
    -   [ ] Optimiser le traitement des fichiers côté client
    -   [ ] Améliorer la mise en cache des documents récents

### Nouvelles fonctionnalités

-   [ ] Ajouter des fonctionnalités avancées

    -   [ ] Permettre le partage sécurisé des documents protégés
    -   [ ] Ajouter un suivi des consultations de documents
    -   [ ] Intégrer une visionneuse de documents en ligne
    -   [ ] Ajouter la possibilité d'ajouter des annotations ou des commentaires

-   [ ] Intégrer avec d'autres services
    -   [ ] Permettre l'importation depuis des services cloud (Google Drive, Dropbox)
    -   [ ] Ajouter l'exportation vers différents formats
    -   [ ] Proposer l'intégration avec des outils de signature électronique

### Tableau de bord de progression

| Date       | Tâche                                                            | Statut  | Description                                                                                                                                                                             |
| ---------- | ---------------------------------------------------------------- | ------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 03/03/2025 | Analyse initiale de la page Documents/Protect.vue                | Terminé | Évaluation de la structure actuelle et identification des améliorations potentielles                                                                                                    |
| 03/03/2025 | Refactorisation de la structure du code de Documents/Protect.vue | Terminé | Création des composants réutilisables DocumentUploader, DocumentCard et ProtectedDocumentList, et refactorisation de la vue principale                                                  |
| 03/03/2025 | Correction des bugs liés à la refactorisation                    | Terminé | Correction des vérifications de valeurs null dans les composants pour éviter les erreurs et amélioration de la robustesse du code                                                       |
| 03/03/2025 | Amélioration du système de filigranage PDF                       | Terminé | Résolution des problèmes avec le filigranage PDF, optimisation de la visibilité et de la position du filigrane en arrière-plan, amélioration de la robustesse de la classe ExtendedFpdi |

## Système d'abonnement pour la protection de documents

### Page de redirection après choix du plan de souscription

Cette section détaille les étapes nécessaires pour implémenter la redirection des utilisateurs après qu'ils aient choisi un plan de souscription dans la section "Nos Plans de Souscription" de la page Documents/Home.

#### Étape 1 : Modification des boutons CTA dans Home.vue

- [x] Remplacer les boutons statiques par des liens de redirection
  - [x] Ajouter des attributs `@click` sur les boutons de chaque plan
  - [x] Créer une méthode `selectPlan(planId)` qui gère la redirection
  - [x] Passer l'ID du plan sélectionné comme paramètre d'URL

#### Étape 2 : Création de la page de confirmation et personnalisation

- [x] Créer un nouveau composant `SubscriptionConfirm.vue`
  - [x] Implémenter un résumé du plan sélectionné (caractéristiques, prix)
  - [x] Ajouter un formulaire pour les informations de facturation (si nécessaire)
  - [x] Inclure les options de personnalisation spécifiques au plan choisi
  - [x] Ajouter la sélection de la méthode de paiement

#### Étape 3 : Configuration des routes associées

- [x] Ajouter les routes nécessaires dans web.php
  - [x] Route pour la page de confirmation de l'abonnement
  - [x] Route pour le traitement du paiement
- [x] Implémenter les méthodes correspondantes dans le contrôleur
  - [x] Méthode `confirmSubscription` pour afficher la page de confirmation
  - [x] Méthode `processSubscription` pour traiter le paiement
  - [x] Méthodes auxiliaires pour les différentes passerelles de paiement

#### Étape 4 : Implémentation du processus de paiement

- [x] Intégrer avec les passerelles de paiement existantes
  - [x] Configurer PayPal pour les paiements d'abonnement
  - [x] Configurer Afrikpay pour prendre en charge les plans d'abonnement
- [x] Créer les services de paiement standardisés
  - [x] Implémenter `PaymentServiceInterface` pour uniformiser les méthodes
  - [x] Créer `PaypalService` pour gérer les paiements PayPal
  - [x] Créer `AfrikpayService` pour gérer les paiements Afrikpay
  - [x] Implémenter `PaymentFactory` pour la sélection dynamique des services
- [x] Créer les endpoints API nécessaires pour traiter le paiement
  - [x] Routes pour le processus de paiement
  - [x] Routes pour les webhooks et retours de paiement
  - [x] Contrôleurs spécifiques pour chaque passerelle de paiement

#### Étape 5 : Gestion post-paiement

- [x] Créer des pages de confirmation de paiement
  - [x] Page de succès du paiement
  - [x] Page d'erreur de paiement
  - [x] Page d'annulation de paiement
- [ ] Implémenter la logique d'attribution des avantages du plan
  - [ ] Mettre à jour le niveau d'abonnement de l'utilisateur dans la base de données
  - [ ] Générer et envoyer une facture par email
  - [ ] Activer les fonctionnalités correspondant au plan choisi
- [ ] Configurer les notifications par email
  - [ ] Email de confirmation d'abonnement
  - [ ] Détails de facturation et reçu

#### Étape 6 : Tests et déploiement

- [ ] Effectuer des tests de bout en bout du parcours utilisateur
  - [ ] Vérifier toutes les transitions entre les pages
  - [ ] Tester avec différents plans et modes de paiement
- [ ] Tester les cas d'erreur et les chemins alternatifs
  - [ ] Gestion des échecs de paiement
  - [ ] Annulation pendant le processus
- [ ] Déployer en production avec surveillance des performances

### Objectifs

-   Proposer 3 plans d'abonnement (Gratuit, Basique, Premium) avec des fonctionnalités et limites clairement définies
-   Créer une expérience utilisateur fluide pour la gestion des abonnements
-   Mettre en place un système de paiement sécurisé avec renouvellements automatiques
-   Développer un tableau de bord analytique pour suivre les performances des abonnements

### Plan d'implémentation détaillé

1. **Conception des plans d'abonnement**

    - [x] Définir 3 niveaux d'abonnement (Gratuit, Basique, Premium)
    - [x] Déterminer les fonctionnalités spécifiques à chaque niveau avec une proposition de valeur claire
    - [x] Établir la tarification pour chaque plan (mensuel et annuel avec remise)
    - [x] Concevoir une stratégie de migration entre les plans (upgrades/downgrades)
    - [x] Définir les politiques de remboursement et d'annulation

2. **Architecture de la base de données**

    - [x] Créer les modèles pour les abonnements (SubscriptionPlan, UserSubscription)
    - [x] Ajouter les relations avec le modèle utilisateur (User)
    - [x] Concevoir les tables pour l'historique des paiements (SubscriptionPayment)
    - [x] Créer un modèle pour le suivi d'utilisation (UsageTracking)
    - [x] Implémenter un système de journalisation des changements d'abonnement (SubscriptionChangeLog)

3. **Intégration d'un système de paiement**

    - [ ] Implémenter l'API de paiement par Mobile Money pour les utilisateurs africains
    - [ ] Configurer les webhooks pour les notifications de paiement
    - [ ] Mettre en place un système de gestion des échecs de paiement avec tentatives automatiques
    - [ ] Développer un système de facturation avec génération de PDF

4. **Développement du backend**

    - [ ] Créer les routes et contrôleurs RESTful pour la gestion des abonnements
    - [ ] Implémenter la logique d'accès conditionnel aux fonctionnalités (middleware d'autorisation)
    - [ ] Développer le système de renouvellement automatique avec notifications préalables
    - [ ] Créer un système de quotas et de limites d'utilisation
    - [ ] Mettre en place un cache pour optimiser les vérifications d'abonnement fréquentes

5. **Développement du frontend**

    - [x] Concevoir une page de présentation des plans d'abonnement moderne et attractive
        - [x] Créer un tableau comparatif interactif des fonctionnalités
        - [ ] Ajouter des témoignages et études de cas pour chaque niveau
    - [ ] Développer un formulaire d'inscription avec sélection du plan et upselling intelligent
    - [ ] Créer une interface de gestion de l'abonnement pour l'utilisateur
        - [ ] Historique des paiements et factures téléchargeables
        - [ ] Statistiques d'utilisation avec visualisations
    - [ ] Implémenter des animations et micro-interactions pour améliorer l'UX

6. **Système de protection des documents**

    - [ ] Implémenter les restrictions d'accès selon le niveau d'abonnement
    - [ ] Créer un middleware pour vérifier les droits d'accès en temps réel
    - [ ] Développer un système de filigranage avancé avec options de personnalisation
        - [ ] Filigranes textuels avec polices personnalisables
        - [ ] Filigranes avec logo et transparence ajustable
        - [ ] Positionnement intelligent du filigrane
    - [ ] Ajouter un système de suivi des documents partagés (analytics)

7. **Gestion des notifications et communication**

    - [ ] Configurer les emails transactionnels avec un design moderne
        - [ ] Confirmation d'abonnement et reçus
        - [ ] Rappels de renouvellement (7 jours et 1 jour avant)
        - [ ] Alertes d'approche de limite d'utilisation (80% et 95%)
    - [ ] Mettre en place des notifications in-app pour les changements de statut
    - [ ] Développer un centre de notifications centralisé
    - [ ] Créer des campagnes d'email ciblées pour l'upselling

8. **Tests et déploiement**

    - [ ] Élaborer un plan de tests complet
        - [ ] Tests unitaires pour la logique d'abonnement
        - [ ] Tests d'intégration pour les paiements
        - [ ] Tests end-to-end des parcours utilisateur
    - [ ] Mettre en place un environnement de staging pour les tests
    - [ ] Vérifier la sécurité des transactions et la conformité RGPD
    - [ ] Déployer progressivement avec une stratégie de rollback
    - [ ] Réaliser des tests A/B sur les pages d'abonnement

9. **Suivi et analytics**

    - [ ] Mettre en place des métriques clés de performance (KPI)
        - [ ] Taux de conversion par plan
        - [ ] Valeur moyenne des abonnements (ARPU)
        - [ ] Taux de rétention et churn
    - [ ] Développer un tableau de bord administrateur pour suivre les abonnements
    - [ ] Configurer des rapports de revenus automatisés (quotidiens, hebdomadaires, mensuels)
    - [ ] Intégrer des outils d'analyse comportementale (heatmaps, enregistrements de session)

10. **Optimisation et maintenance**
    - [x] Analyser les taux de conversion et d'abandon pour optimisation continue
    - [ ] Mettre en place un système de feedback utilisateur sur les plans d'abonnement
    - [x] Ajuster les offres selon les retours utilisateurs et les données d'utilisation
    - [ ] Planifier les évolutions futures du système d'abonnement
    - [ ] Développer une stratégie de fidélisation (récompenses, programme de parrainage)

### Étapes d'implémentation

| Date       | Tâche                                 | Statut  | Description                                                                                                                |
| ---------- | ------------------------------------- | ------- | -------------------------------------------------------------------------------------------------------------------------- |
| 07/03/2025 | Conception détaillée des plans        | Terminé | Définition complète des fonctionnalités, limites et tarifs pour chaque plan d'abonnement                                   |
| 07/03/2025 | Création des modèles de données       | Terminé | Implémentation des modèles SubscriptionPlan, UserSubscription, SubscriptionPayment, UsageTracking et SubscriptionChangeLog |
| 09/03/2025 | Intégration de Stripe                 | À faire | Configuration de l'API Stripe, webhooks et système de gestion des cartes de paiement                                       |
| 10/03/2025 | Développement des contrôleurs backend | À faire | Création des API RESTful pour la gestion complète des abonnements                                                          |
| 11/03/2025 | Middleware d'autorisation             | À faire | Implémentation du système de vérification des droits basé sur l'abonnement                                                 |
| 12/03/2025 | Système de quotas et limites          | À faire | Développement du système de suivi d'utilisation et application des limites                                                 |
| 13/03/2025 | Page de présentation des abonnements  | À faire | Création d'une interface moderne et persuasive pour la présentation des plans                                              |
| 14/03/2025 | Interface de gestion des abonnements  | À faire | Développement du tableau de bord utilisateur pour gérer son abonnement                                                     |
| 15/03/2025 | Système de notifications              | À faire | Configuration des emails transactionnels et notifications in-app                                                           |
| 16/03/2025 | Tests d'intégration                   | À faire | Tests complets des parcours d'abonnement, paiement et utilisation                                                          |
| 17/03/2025 | Tableau de bord analytique            | À faire | Création d'un dashboard administrateur avec KPIs et rapports                                                               |
| 18/03/2025 | Lancement et suivi                    | À faire | Déploiement progressif et monitoring des performances                                                                      |

### Fonctionnalités par plan d'abonnement (implémentées dans SubscriptionPlanSeeder)

| Fonctionnalité                  | Gratuit              | Basique                  | Premium                                   |
| ------------------------------- | -------------------- | ------------------------ | ----------------------------------------- |
| Nombre de générations/mois      | 5                    | 100                      | Illimité                                  |
| Taille maximale des documents   | 10 MB                | 50 MB                    | 200 MB                                    |
| Documents protégés              | 5 documents au total | 20/mois (max 100)        | Illimité                                  |
| Types de documents supportés    | PDF uniquement       | PDF, JPG, PNG            | Tous formats (PDF, JPG, PNG, DOCX, XLSX)  |
| Personnalisation du filigrane   | Basique (texte)      | Avancée (texte, couleur) | Complète (texte, logo, position, opacité) |
| Stockage des documents protégés | 7 jours              | 30 jours                 | 1 an                                      |
| Nombre de partages par document | 3                    | 20                       | Illimité                                  |
| Protection par mot de passe     | Non                  | Oui                      | Oui                                       |
| Suivi des consultations         | Non                  | Basique                  | Détaillé avec analytics                   |
| Expiration programmable         | Non                  | Oui                      | Oui avec options avancées                 |
| Support client                  | Email (48h)          | Email (24h)              | Email (12h) + Chat prioritaire            |
| Accès API                       | Non                  | Limité                   | Complet                                   |
| Rapports d'utilisation          | Non                  | Mensuels                 | Hebdomadaires + personnalisables          |
| Utilisateurs par compte         | 1                    | 3                        | 10 + option équipe                        |
| Prix mensuel                    | Gratuit              | 9,99€                    | 29,99€                                    |
| Prix annuel (économie)          | Gratuit              | 99,90€ (16% d'économie)  | 299,90€ (16% d'économie)                  |

### Stratégie de conversion et fidélisation

-   **Conversion Gratuit → Basique**

    -   Notifications intelligentes lorsque l'utilisateur approche de sa limite mensuelle
    -   Offre d'essai du plan Basique pendant 14 jours
    -   Démonstration des fonctionnalités premium verrouillées avec CTA clairs

-   **Conversion Basique → Premium**

    -   Analyse des besoins basée sur l'utilisation pour suggestions personnalisées
    -   Offre de migration avec 1 mois gratuit
    -   Webinaires exclusifs sur l'utilisation avancée des fonctionnalités Premium

-   **Fidélisation Premium**
    -   Programme de récompenses pour utilisation continue
    -   Accès anticipé aux nouvelles fonctionnalités
    -   Webinaires et formations exclusives
    -   Programme de parrainage avec avantages mutuels

### Implémentation d'un système multi-devises

Pour offrir une expérience adaptée au marché africain et international, le système d'abonnement doit prendre en charge plusieurs devises :

-   XAF : Franc CFA d'Afrique centrale
-   XOF : Franc CFA d'Afrique de l'ouest
-   EUR : Euro
-   USD : Dollar américain

#### Étapes d'implémentation du système multi-devises

1. **Architecture de base de données**

    - [ ] Créer une table `currencies` avec les champs suivants :
        - `id`: Identifiant unique
        - `code`: Code ISO de la devise (XAF, XOF, EUR, USD)
        - `name`: Nom complet de la devise
        - `symbol`: Symbole monétaire (€, $, FCFA)
        - `exchange_rate`: Taux de change par rapport à la devise de référence
        - `is_active`: Indique si la devise est disponible pour les utilisateurs
        - `is_default`: Indique la devise par défaut du système
        - `decimal_places`: Nombre de décimales à afficher (0 pour XAF/XOF, 2 pour EUR/USD)
    - [ ] Modifier la table `subscription_plans` pour ajouter une référence à la devise par défaut
    - [ ] Créer une table `subscription_plan_prices` pour stocker les prix dans différentes devises
        - `subscription_plan_id`: Référence au plan d'abonnement
        - `currency_id`: Référence à la devise
        - `monthly_price`: Prix mensuel
        - `annual_price`: Prix annuel
    - [ ] Le montant sera stocké en XAF comme devise principale et les autres devises seront calculées en fonction du taux de change
    - [ ] Créer des migrations pour ces nouvelles tables et modifications
    - [ ] Implémenter les modèles Eloquent avec les relations appropriées

2. **Service de taux de change**

    - [ ] Intégrer une API de taux de change en temps réel
        - [ ] Créer un compte sur Exchange Rate API ou Open Exchange Rates
        - [ ] Configurer la clé API dans le fichier .env (`EXCHANGE_RATE_API_KEY`)
        - [ ] Implémenter un service `CurrencyExchangeService` qui gère les appels API
    - [ ] Développer un service de synchronisation des taux de change
        - [ ] Créer une commande artisan `php artisan currency:sync` pour actualiser les taux
        - [ ] Configurer une tâche planifiée (cron) qui s'exécute quotidiennement à minuit
        - [ ] Enregistrer chaque synchronisation dans une table `exchange_rate_logs`
    - [ ] Créer un mécanisme de fallback en cas d'indisponibilité de l'API
        - [ ] Mettre en cache les derniers taux de change valides (Redis ou base de données)
        - [ ] Implémenter une politique de réessai avec backoff exponentiel
        - [ ] Envoyer une notification à l'administrateur en cas d'échecs répétés
    - [ ] Gérer les spécificités des devises africaines
        - [ ] Maintenir la parité fixe entre EUR et XAF/XOF (1 EUR = 655.957 XAF/XOF)

3. **Géolocalisation et détection de devise**

    - [ ] Implémenter un système de détection du pays de l'utilisateur
        - [ ] Intégrer la bibliothèque GeoIP2 via Composer (`composer require geoip2/geoip2`)
        - [ ] Télécharger et configurer la base de données GeoLite2 Country
        - [ ] Créer un middleware `DetectUserCurrency` qui s'exécute sur chaque requête
    - [ ] Associer les pays aux devises appropriées
        - [ ] Créer une table `country_currency` avec la relation entre pays (code ISO) et devise
        - [ ] Définir les associations : 
            - Cameroun, Gabon, Congo, RCA, Tchad, Guinée Équatoriale → XAF
            - Sénégal, Mali, Côte d'Ivoire, Bénin, Burkina Faso, Togo, Niger, Guinée-Bissau → XOF
            - Zone Euro → EUR
            - Reste du monde → USD (par défaut)
    - [ ] Gérer la préférence de devise de l'utilisateur
        - [ ] Stocker la devise préférée dans la table `users` (`preferred_currency_id`)
        - [ ] Créer un endpoint API `/api/user/currency` pour mettre à jour la préférence
        - [ ] Pour les utilisateurs non connectés, utiliser les cookies ou localStorage

4. **Modifications du backend**

    - [ ] Développer les services de gestion des devises
        - [ ] Créer un service `CurrencyService` pour centraliser la logique de conversion
        - [ ] Implémenter des helpers comme `convertCurrency($amount, $fromCurrency, $toCurrency)`
        - [ ] Mettre en cache les conversions fréquentes pour optimiser les performances
    - [ ] Adapter les contrôleurs d'abonnement
        - [ ] Modifier `SubscriptionController` pour considérer la devise sélectionnée
        - [ ] Ajouter un paramètre `currency_code` dans les endpoints liés aux paiements
        - [ ] Développer une logique de fallback si la devise demandée n'est pas disponible
    - [ ] Gérer les rapports financiers
        - [ ] Stocker toutes les transactions avec la devise utilisée et son taux de change
        - [ ] Créer une table `transactions` avec les champs nécessaires pour le multi-devises
        - [ ] Développer des rapports consolidés avec conversion vers la devise principale
    - [ ] Mettre à jour le système d'API
        - [ ] Ajouter un endpoint `/api/currencies` pour lister les devises disponibles
        - [ ] Renvoyer les prix dans toutes les devises ou la devise demandée via `/api/subscription-plans`
        - [ ] Documenter les modifications de l'API avec Swagger/OpenAPI

5. **Adaptations du frontend**

    - [ ] Développer des composants pour la gestion des devises
        - [ ] Créer un composant `CurrencySelector.vue` pour le choix de la devise
        - [ ] Implémenter un composant `FormattedPrice.vue` pour afficher les prix avec le bon format
        - [ ] Développer un store Vuex/Pinia pour gérer l'état global de la devise
    - [ ] Intégrer le sélecteur de devise dans l'interface
        - [ ] Ajouter le sélecteur dans le header global de l'application
        - [ ] Utiliser une icône de devise avec un dropdown pour les options
        - [ ] Sauvegarder la préférence utilisateur via l'API appropriée
    - [ ] Adapter la page de tarification
        - [ ] Mettre à jour le composant `PricingPlans.vue` pour utiliser la devise sélectionnée
        - [ ] Afficher un indicateur subtil du taux de change appliqué
        - [ ] Ajouter une option pour basculer entre affichage mensuel et annuel
    - [ ] Implémenter un formatage adapté des prix
        - [ ] Créer un service JavaScript de formatage monétaire
        - [ ] Gérer les spécificités par devise (XAF/XOF sans décimales, EUR/USD avec 2 décimales)
        - [ ] Utiliser les bonnes conventions de séparateurs selon la langue (espace pour fr, virgule pour en)

6. **Intégration des passerelles de paiement**

    - [ ] Configurer Stripe pour le multi-devises
        - [ ] Mettre à jour la clé API Stripe dans les paramètres du compte pour activer EUR, USD
        - [ ] Implémenter la gestion des webhooks Stripe pour chaque devise
        - [ ] Configurer les méthodes de paiement appropriées par région (cartes, SEPA, ACH)
    - [ ] Intégrer les solutions de paiement mobile africaines
        - [ ] Orange Money
            - [ ] Créer un compte développeur et obtenir les clés API
            - [ ] Implémenter le flux de paiement par redirection avec retour de statut
            - [ ] Gérer les notifications de paiement réussi/échoué
        - [ ] MTN Mobile Money
            - [ ] Intégrer l'API MoMo Collection pour les paiements XAF
            - [ ] Configurer le système de callback pour la confirmation des paiements
            - [ ] Développer la logique de gestion des timeout et des échecs
        - [ ] Wave
            - [ ] Intégrer l'API Wave pour les paiements XOF
            - [ ] Implémenter la vérification des transactions
    - [ ] Créer un système de routage intelligent
        - [ ] Développer un service `PaymentGatewayRouter` qui sélectionne la passerelle optimale
        - [ ] Définir des règles de routage basées sur : pays, devise, montant, disponibilité
        - [ ] Implémenter des politiques de fallback en cas d'échec d'une passerelle
    - [ ] Unifier l'expérience utilisateur de paiement
        - [ ] Créer un composant `PaymentProcessor.vue` qui s'adapte à la passerelle utilisée
        - [ ] Développer une interface commune pour toutes les passerelles
        - [ ] Concevoir un workflow de paiement cohérent quelle que soit la méthode utilisée

7. **Comptabilité et fiscalité**

    - [ ] Gérer les règles fiscales par région
        - [ ] Créer une table `tax_rules` avec les informations fiscales par pays
        - [ ] Implémenter un service `TaxCalculationService` qui détermine le taux applicable
        - [ ] Gérer les cas spécifiques comme la TVA européenne et les taxes locales africaines
    - [ ] Développer la génération de factures
        - [ ] Créer un système de génération de factures conforme aux réglementations locales
        - [ ] Intégrer les informations fiscales spécifiques à chaque pays
        - [ ] Formatter les montants selon les conventions locales de chaque devise
    - [ ] Implémenter des rapports financiers multi-devises
        - [ ] Créer un tableau de bord admin pour visualiser les revenus par devise
        - [ ] Développer des rapports d'agrégation avec conversion en devise de référence (XAF)
        - [ ] Implémenter des graphiques d'évolution des revenus par devise
    - [ ] Gérer la comptabilité interne
        - [ ] Définir XAF comme devise de référence pour la comptabilité
        - [ ] Enregistrer le taux de change utilisé pour chaque transaction
        - [ ] Implémenter un système d'exportation des données comptables au format standard

8. **Tests et validation**

    - [ ] Développer des tests automatisés
        - [ ] Créer des tests unitaires pour les services de conversion de devises
        - [ ] Implémenter des tests d'intégration pour chaque passerelle de paiement
        - [ ] Développer des tests end-to-end pour les parcours utilisateur complets
    - [ ] Tester les parcours de paiement
        - [ ] Vérifier le processus d'abonnement dans chaque devise (XAF, XOF, EUR, USD)
        - [ ] Tester les scénarios de changement de devise en cours d'abonnement
        - [ ] Valider le comportement du système en cas d'indisponibilité d'une passerelle
    - [ ] Valider la précision des conversions
        - [ ] Vérifier les algorithmes d'arrondi pour chaque devise
        - [ ] S'assurer que la somme des montants convertis correspond au montant total
        - [ ] Tester les cas limites (très petits montants, très grands montants)
    - [ ] Effectuer des tests de performance
        - [ ] Mesurer l'impact des conversions de devise sur les temps de réponse
        - [ ] Vérifier l'efficacité du système de cache des taux de change
        - [ ] Tester la charge du système avec de multiples transactions simultanées
    - [ ] Valider l'interface utilisateur
        - [ ] Vérifier la cohérence de l'affichage des prix sur toutes les pages
        - [ ] Tester l'accessibilité du sélecteur de devise
        - [ ] Valider l'expérience mobile pour toutes les fonctionnalités liées aux devises

#### Calendrier d'implémentation

| Date       | Étape                                     | Statut  | Description                                                     |
| ---------- | ----------------------------------------- | ------- | --------------------------------------------------------------- |
| 20/03/2025 | Architecture de base de données           | À faire | Création des tables et relations pour le support multi-devises  |
| 21/03/2025 | Intégration API de taux de change         | À faire | Configuration du service d'actualisation des taux               |
| 22/03/2025 | Système de géolocalisation                | À faire | Développement de la détection et association de devise par pays |
| 23/03/2025 | Adaptation de l'interface de tarification | À faire | Mise à jour du frontend pour supporter plusieurs devises        |
| 24/03/2025 | Intégration Mobile Money                  | À faire | Configuration des passerelles de paiement africaines            |
| 25/03/2025 | Tests et déploiement                      | À faire | Validation et mise en production                                |
