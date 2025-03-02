<template>

    <Head :title="fullName" />

    <Layout>
        <div class="min-h-screen bg-gray-50">
            <HeaderPage>
                <template #headerPage>
                    <div class="bg-white shadow-sm border-b border-gray-200 px-4 py-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                                    Détails de la pièce retrouvée
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Consultez les informations détaillées de cette pièce
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </HeaderPage>

            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
                <!-- Fil d'Ariane -->
                <BreadcrumbNav :items="[
                    { label: 'Rechercher une pièce', href: route('found.search') },
                    { label: fullName }
                ]" />

                <!-- Contenu Principal -->
                <DetailCard
                    :title="fullName"
                    :has-image-section="true"
                >
                    <!-- Section Image (Galerie) -->
                    <template #imageSection>
                        <div class="relative">
                            <!-- Bouton de vue plein écran -->
                            <button @click="toggleFullscreen" 
                                class="absolute top-4 right-4 z-10 bg-white bg-opacity-75 p-2 rounded-full hover:bg-opacity-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path v-if="isFullscreen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4m-4 0l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                </svg>
                            </button>
                            
                            <!-- Galerie principale -->
                            <Splide ref="mainSplide" :options="{
                                rewind: true,
                                arrows: true,
                                pagination: true,
                                height: '500px',
                                zoom: true
                            }" @splide:moved="syncThumbnails">
                                <!-- Utilisation de SplideSlide pour chaque image -->
                                <SplideSlide v-if="photos && !Array.isArray(photos)">
                                    <div class="splide__zoom">
                                        <img :alt="fullName" :src="showImage(photos)" 
                                            class="w-full h-full object-cover cursor-zoom-in">
                                    </div>
                                </SplideSlide>
                                
                                <!-- Support pour un tableau de photos -->
                                <template v-else>
                                    <!-- Utilise une image de placeholder si aucune photo n'est disponible -->
                                    <SplideSlide v-if="!photos || photos.length === 0">
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </SplideSlide>
                                    
                                    <!-- Affiche toutes les photos disponibles -->
                                    <SplideSlide v-for="(photo, index) in photos" :key="index">
                                        <div class="splide__zoom">
                                            <img :alt="`${fullName} - Photo ${index + 1}`" :src="showImage(photo)" 
                                                class="w-full h-full object-cover cursor-zoom-in">
                                        </div>
                                    </SplideSlide>
                                </template>
                            </Splide>
                            
                            <!-- Galerie de miniatures -->
                            <Splide v-if="Array.isArray(photos) && photos.length > 1" 
                                ref="thumbnailSplide" 
                                :options="{
                                    rewind: true,
                                    gap: '1rem',
                                    pagination: false,
                                    fixedWidth: 100,
                                    fixedHeight: 60,
                                    cover: true,
                                    isNavigation: true,
                                    arrows: photos && photos.length > 4
                                }" 
                                @splide:mounted="syncMainSlider"
                                class="mt-4">
                                <SplideSlide v-for="(photo, index) in photos" :key="index" class="cursor-pointer">
                                    <img :alt="`Miniature ${index + 1}`" :src="showImage(photo)" 
                                        class="w-full h-full object-cover rounded-md opacity-70 hover:opacity-100 transition-opacity duration-200">
                                </SplideSlide>
                            </Splide>
                        </div>
                        
                        <!-- Modal plein écran -->
                        <div v-if="isFullscreen" class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center">
                            <button @click="toggleFullscreen" class="absolute top-4 right-4 z-10 bg-white bg-opacity-50 p-2 rounded-full hover:bg-opacity-100 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            
                            <Splide :options="{
                                rewind: true,
                                arrows: true,
                                pagination: true,
                                height: '90vh',
                                width: '90vw',
                                zoom: true
                            }" :index="currentSlideIndex">
                                <SplideSlide v-if="photos && !Array.isArray(photos)">
                                    <div class="splide__zoom">
                                        <img :alt="fullName" :src="showImage(photos)" class="max-h-[85vh] mx-auto object-contain">
                                    </div>
                                </SplideSlide>
                                
                                <template v-else>
                                    <SplideSlide v-if="!photos || photos.length === 0">
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </SplideSlide>
                                    
                                    <SplideSlide v-for="(photo, index) in photos" :key="index">
                                        <div class="splide__zoom">
                                            <img :alt="`${fullName} - Photo ${index + 1}`" :src="showImage(photo)" 
                                                class="max-h-[85vh] mx-auto object-contain cursor-zoom-in">
                                        </div>
                                    </SplideSlide>
                                </template>
                            </Splide>
                        </div>
                    </template>
                    
                    <!-- Contenu principal avec sections thématiques -->
                    <InfoSection 
                        title="Détails de l'objet" 
                        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" 
                        container-class="mt-6"
                    >
                        <p>{{ details }}</p>
                    </InfoSection>
                    
                    <!-- Section Localisation -->
                    <InfoSection 
                        title="Emplacement" 
                        :badge="findCity"
                        icon="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        container-class="mt-6"
                    >
                        <LocationMap 
                            v-if="coordinates.lat && coordinates.lng"
                            :latitude="coordinates.lat" 
                            :longitude="coordinates.lng" 
                            :location-name="findCity" 
                            :height="280"
                            class="mt-3 mb-2"
                        />
                        <p v-else class="mt-2 italic text-gray-500">Informations de localisation précises non disponibles.</p>
                    </InfoSection>
                    
                    <!-- Section Récompense -->
                    <InfoSection 
                        title="Récompense" 
                        :badge="amount_check.amount == 0 ? amount_piece.formatted : amount_check.formatted"
                        icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        icon-class="text-green-600"
                        icon-bg-class="bg-green-50"
                        badge-class="bg-green-50 text-green-700"
                        container-class="mt-6"
                    >
                        <p>
                            {{ amount_check.amount == 0 
                                ? 'Cette trouvaille est associée à une récompense en espèces.'
                                : 'Cette trouvaille est associée à une récompense par chèque.' 
                            }}
                        </p>
                    </InfoSection>
                    
                    <!-- Section Informations complémentaires -->
                    <InfoSection 
                        v-if="createdDate"
                        title="Informations complémentaires" 
                        icon="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        icon-class="text-gray-600"
                        icon-bg-class="bg-gray-100"
                        container-class="mt-6"
                    >
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Trouvé le {{ formatDate(createdDate) }}</span>
                        </div>
                    </InfoSection>
                    
                    <!-- Action -->
                    <template #actions>
                        <div class="mt-6 space-y-4">
                            <Link :href="route('found.info', { thefind: id })"
                                class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent rounded-lg text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Valider cette trouvaille
                            </Link>
                            
                            <div class="flex space-x-2">
                                <button @click="shareItem" 
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                    Partager
                                </button>
                                
                                <button @click="reportIssue"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Signaler
                                </button>
                            </div>
                        </div>
                    </template>
                </DetailCard>
            </div>
        </div>
    </Layout>

</template>

<script>
import Layout from "@/Layouts/Layout";
import HeaderPage from "@/Layouts/HeaderPage";
import { Link } from '@inertiajs/inertia-vue3';
import { Splide, SplideSlide } from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';
import BreadcrumbNav from "@/Components/BreadcrumbNav";
import DetailCard from "@/Components/DetailCard";
import InfoSection from "@/Components/InfoSection";
import LocationMap from "@/Components/LocationMap";

export default {
    name: "TheShowFind",
    components: {
        HeaderPage,
        Link,
        Splide,
        SplideSlide,
        Layout,
        BreadcrumbNav,
        DetailCard,
        InfoSection,
        LocationMap
    },
    props: {
        id: Number,
        fullName: String,
        findCity: String,
        details: String,
        amount_piece: Object,
        amount_check: Object,
        photos: {
            type: [String, Array],
            required: true
        },
        coordinates: {
            type: Object,
            default: () => ({ lat: null, lng: null })
        },
        createdDate: {
            type: String,
            default: null
        }
    },
    data() {
        return {
            isFullscreen: false,
            currentSlideIndex: 0
        }
    },
    methods: {
        showImage(file) {
            if (!file) return '';
            return "/storage/findImages/" + file;
        },
        toggleFullscreen() {
            this.isFullscreen = !this.isFullscreen;
            if (this.isFullscreen) {
                document.body.classList.add('overflow-hidden');
            } else {
                document.body.classList.remove('overflow-hidden');
            }
        },
        syncThumbnails(splide) {
            this.currentSlideIndex = splide.index;
            if (this.$refs.thumbnailSplide && this.$refs.thumbnailSplide.splide) {
                this.$refs.thumbnailSplide.splide.go(splide.index);
            }
        },
        syncMainSlider() {
            if (this.$refs.thumbnailSplide && this.$refs.thumbnailSplide.splide && this.$refs.mainSplide && this.$refs.mainSplide.splide) {
                this.$refs.thumbnailSplide.splide.sync(this.$refs.mainSplide.splide);
            }
        },
        formatDate(dateString) {
            if (!dateString) return '';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('fr-FR', options);
        },
        shareItem() {
            if (navigator.share) {
                navigator.share({
                    title: this.fullName,
                    text: `J'ai retrouvé ${this.fullName} à ${this.findCity}. Consultez les détails sur FindToFound.`,
                    url: window.location.href
                })
                .catch(err => {
                    console.error('Erreur lors du partage:', err);
                });
            } else {
                // Copier le lien dans le presse-papier si l'API de partage n'est pas disponible
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = window.location.href;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                
                alert('Lien copié dans le presse-papier!');
            }
        },
        reportIssue() {
            // Implémentation simple - pourrait être remplacée par une modale ou une redirection vers un formulaire
            const reason = prompt('Veuillez indiquer la raison du signalement:');
            if (reason) {
                alert('Merci pour votre signalement. Notre équipe va examiner ce problème dans les plus brefs délais.');
                // Ici nous pourrions envoyer les données à une API
                console.log('Signalement:', { itemId: this.id, reason });
            }
        }
    }
}
</script>

<style>
.splide__arrow {
    background: rgba(37, 99, 235, 0.9) !important;
    opacity: 1 !important;
}

.splide__arrow svg {
    fill: #ffffff !important;
}

.splide__pagination__page.is-active {
    background: rgb(37, 99, 235) !important;
}
</style>
