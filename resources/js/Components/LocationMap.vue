<template>
    <div class="relative rounded-lg overflow-hidden" :style="{ height: height + 'px' }">
        <!-- Carte -->
        <div ref="mapContainer" class="w-full h-full"></div>
        
        <!-- Overlay de chargement -->
        <div v-if="loading" class="absolute inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 text-sm font-medium">Chargement de la carte...</span>
        </div>
        
        <!-- Information de distance -->
        <div v-if="userDistance && showDistance" class="absolute bottom-3 left-3 bg-white px-3 py-2 rounded-lg shadow-md text-sm">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span class="font-medium">Distance: {{ formatDistance(userDistance) }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LocationMap',
    props: {
        latitude: {
            type: [Number, String],
            required: true
        },
        longitude: {
            type: [Number, String],
            required: true
        },
        locationName: {
            type: String,
            default: 'Emplacement'
        },
        height: {
            type: Number,
            default: 300
        },
        showDistance: {
            type: Boolean,
            default: true
        },
        zoom: {
            type: Number,
            default: 14
        }
    },
    data() {
        return {
            map: null,
            marker: null,
            loading: true,
            userPosition: null,
            userDistance: null
        }
    },
    computed: {
        latNumber() {
            return typeof this.latitude === 'string' ? parseFloat(this.latitude) : this.latitude;
        },
        lngNumber() {
            return typeof this.longitude === 'string' ? parseFloat(this.longitude) : this.longitude;
        }
    },
    mounted() {
        // Charge Leaflet depuis un CDN si ce n'est pas déjà fait
        if (!window.L) {
            const leafletCSS = document.createElement('link');
            leafletCSS.rel = 'stylesheet';
            leafletCSS.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
            document.head.appendChild(leafletCSS);
            
            const leafletScript = document.createElement('script');
            leafletScript.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
            leafletScript.onload = this.initMap;
            document.head.appendChild(leafletScript);
        } else {
            this.initMap();
        }
    },
    methods: {
        initMap() {
            // Initialisation de la carte
            setTimeout(() => {
                this.map = L.map(this.$refs.mapContainer).setView([this.latNumber, this.lngNumber], this.zoom);
                
                // Ajouter la couche OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.map);
                
                // Ajouter un marqueur pour l'emplacement
                this.marker = L.marker([this.latNumber, this.lngNumber]).addTo(this.map);
                this.marker.bindPopup(`<strong>${this.locationName}</strong>`).openPopup();
                
                // Calculer la distance depuis la position de l'utilisateur
                this.getUserLocation();
                
                this.loading = false;
            }, 100);
        },
        getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        this.userPosition = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        // Calculer la distance
                        this.calculateDistance();
                        
                        // Ajouter un cercle pour la position de l'utilisateur
                        L.circle([this.userPosition.lat, this.userPosition.lng], {
                            color: 'blue',
                            fillColor: '#3b82f6',
                            fillOpacity: 0.5,
                            radius: 300
                        }).addTo(this.map);
                    },
                    (error) => {
                        console.error('Erreur de géolocalisation:', error);
                    }
                );
            }
        },
        calculateDistance() {
            if (!this.userPosition) return;
            
            // Utiliser la formule de Haversine pour calculer la distance
            const R = 6371; // Rayon de la Terre en km
            const dLat = this.toRad(this.latNumber - this.userPosition.lat);
            const dLon = this.toRad(this.lngNumber - this.userPosition.lng);
            
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(this.toRad(this.userPosition.lat)) * Math.cos(this.toRad(this.latNumber)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
            
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            
            this.userDistance = R * c; // Distance en km
        },
        toRad(value) {
            return value * Math.PI / 180;
        },
        formatDistance(distance) {
            if (distance < 1) {
                return `${Math.round(distance * 1000)} m`;
            } else {
                return `${distance.toFixed(1)} km`;
            }
        }
    }
}
</script>
