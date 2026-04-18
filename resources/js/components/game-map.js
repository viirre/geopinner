/**
 * Alpine.js component for Leaflet map integration
 * Handles map initialization, markers, and click events
 */
import { calculateScore } from '../game/scoring.js';

export default function gameMap() {
    return {
        map: null,
        userMarker: null,
        placeMarker: null,
        distanceLine: null,
        tileLayer: null,
        showLabels: false,

        init() {
            // Initialize map immediately if screen is already 'game'
            if (this.$wire.screen === 'game') {
                this.$nextTick(() => {
                    this.initMap();
                });
            }

            // Watch for screen changes to 'game'
            this.$watch('$wire.screen', (value) => {
                if (value === 'game' && !this.map) {
                    // Use nextTick to ensure DOM is ready
                    this.$nextTick(() => {
                        this.initMap();
                    });
                }
            });

            // Listen for Livewire events
            this.$wire.$on('show-result', (data) => {
                this.showResult(data);
            });

            this.$wire.$on('show-timeout-result', (data) => {
                this.showTimeoutResult(data);
            });

            this.$wire.$on('clear-map', () => {
                this.clearMarkers();
            });

            this.$wire.$on('round-started', () => {
                this.clearMarkers();
                this.resetView();
            });
        },

        initMap() {
            if (this.map) return; // Already initialized

            const mapContainer = document.getElementById('map');
            if (!mapContainer) {
                console.error('Map container not found');
                return;
            }

            // Initialize Leaflet map
            this.map = L.map('map', {
                center: [20, 0],
                zoom: 2,
                minZoom: 2,
                maxZoom: this.$wire.zoomEnabled ? 6 : 2,
                scrollWheelZoom: this.$wire.zoomEnabled,
                doubleClickZoom: this.$wire.zoomEnabled,
                worldCopyJump: true,
                zoomControl: true,
            });

            // Set initial tile layer
            this.setTileLayer();

            // Force map to recalculate size after a short delay
            setTimeout(() => {
                if (this.map) {
                    this.map.invalidateSize();
                }
            }, 100);

            // Handle map clicks
            this.map.on('click', (e) => {
                if (!this.$wire.hasGuessed) {
                    this.handleMapClick(e.latlng);
                }
            });
        },

        setTileLayer() {
            // Remove existing tile layer
            if (this.tileLayer) {
                this.map.removeLayer(this.tileLayer);
            }

            // Determine style based on showLabels setting
            const style = this.showLabels ? 'light_all' : 'light_nolabels';
            const tileUrl = `https://{s}.basemaps.cartocdn.com/${style}/{z}/{x}/{y}.png`;

            this.tileLayer = L.tileLayer(tileUrl, {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 19,
            });

            this.tileLayer.addTo(this.map);
        },

        toggleLabels() {
            // Called when label checkbox is toggled
            this.setTileLayer();
        },

        handleMapClick(latlng) {
            if (this.$wire.hasGuessed || !this.$wire.currentPlace) {
                return;
            }

            // Mark as guessed immediately to prevent double-clicking
            this.$wire.hasGuessed = true;

            const place = this.$wire.currentPlace;
            const userLat = latlng.lat;
            const userLng = latlng.lng;

            // Calculate distance using Haversine formula
            const distance = this.calculateDistance(userLat, userLng, place.lat, place.lng);

            // Calculate score using imported scoring module
            const scoreResult = calculateScore(distance, place);

            // Calculate time bonus if timer enabled
            let timeBonus = 0;
            if (this.$wire.timerEnabled && scoreResult.points >= 7) {
                const timeTaken = this.$wire.roundStartTime ? (Math.floor(Date.now() / 1000) - this.$wire.roundStartTime) : 0;
                timeBonus = this.calculateTimeBonus(timeTaken);
            }

            // Build feedback object
            const feedback = {
                message: scoreResult.message,
                class: scoreResult.feedback,
                emoji: scoreResult.emoji,
                points: scoreResult.points,
                timeBonus: timeBonus,
            };

            if (timeBonus > 0) {
                feedback.message += ` +${timeBonus} snabbhetsbonus!`;
            }

            // Update UI immediately (no backend wait)
            this.$wire.lastFeedback = feedback;
            this.$wire.totalScore += scoreResult.points;
            this.$wire.totalBonus += timeBonus;

            // Show visual result on map
            this.showResult({
                userLat,
                userLng,
                placeLat: place.lat,
                placeLng: place.lng,
            });

            // Record round in backend asynchronously (non-blocking)
            this.$wire.recordRound(userLat, userLng, scoreResult.points, timeBonus, scoreResult.distance);
        },

        calculateDistance(lat1, lng1, lat2, lng2) {
            const earthRadius = 6371; // km

            const dLat = this.deg2rad(lat2 - lat1);
            const dLng = this.deg2rad(lng2 - lng1);

            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return earthRadius * c;
        },

        deg2rad(deg) {
            return deg * (Math.PI / 180);
        },

        calculateTimeBonus(timeTaken) {
            const duration = this.$wire.timerDuration;

            if (timeTaken < duration * 0.25) {
                return 3;
            }
            if (timeTaken < duration * 0.5) {
                return 2;
            }
            if (timeTaken < duration * 0.75) {
                return 1;
            }

            return 0;
        },

        showResult(data) {
            const { userLat, userLng, placeLat, placeLng } = data;

            // Update user marker position if it exists, otherwise create it
            if (this.userMarker) {
                // Just update the position instead of removing/re-adding
                this.userMarker.setLatLng([userLat, userLng]);
            } else {
                // Add user marker (red pin)
                const userIcon = L.icon({
                    iconUrl: '/pin_user.png',
                    iconSize: [16, 40],
                    iconAnchor: [10, 40],
                });

                this.userMarker = L.marker([userLat, userLng], {
                    icon: userIcon,
                }).addTo(this.map);
            }

            // Clear old place marker and distance line if they exist
            if (this.placeMarker) {
                this.map.removeLayer(this.placeMarker);
                this.placeMarker = null;
            }
            if (this.distanceLine) {
                this.map.removeLayer(this.distanceLine);
                this.distanceLine = null;
            }

            // Add place marker (magenta/pink pin)
            const placeIcon = L.icon({
                iconUrl: '/pin_place.png',
                iconSize: [16, 40],
                iconAnchor: [10, 40],
            });

            this.placeMarker = L.marker([placeLat, placeLng], {
                icon: placeIcon,
            }).addTo(this.map);

            // Draw distance line
            this.distanceLine = L.polyline(
                [
                    [userLat, userLng],
                    [placeLat, placeLng],
                ],
                {
                    color: '#ff6b6b',
                    weight: 3,
                    dashArray: '10, 5',
                }
            ).addTo(this.map);

            // Fit bounds to show both markers
            const bounds = L.latLngBounds([
                [userLat, userLng],
                [placeLat, placeLng],
            ]);
            this.map.fitBounds(bounds, {
                padding: [80, 80],
                maxZoom: 5
            });
        },

        showTimeoutResult(data) {
            const { placeLat, placeLng } = data;

            // Only show the correct location marker (no user marker on timeout)
            const placeIcon = L.icon({
                iconUrl: '/pin_place.png',
                iconSize: [16, 40],
                iconAnchor: [10, 40],
            });

            this.placeMarker = L.marker([placeLat, placeLng], {
                icon: placeIcon,
            }).addTo(this.map);

            // Center map on the correct location
            this.map.setView([placeLat, placeLng], 4);
        },

        clearMarkers() {
            if (this.userMarker) {
                this.map.removeLayer(this.userMarker);
                this.userMarker = null;
            }
            if (this.placeMarker) {
                this.map.removeLayer(this.placeMarker);
                this.placeMarker = null;
            }
            if (this.distanceLine) {
                this.map.removeLayer(this.distanceLine);
                this.distanceLine = null;
            }
        },

        resetView() {
            if (this.map) {
                this.map.setView([20, 0], 2);
            }
        },

        destroy() {
            // Cleanup when component is destroyed
            if (this.map) {
                this.map.remove();
                this.map = null;
            }
        },
    };
}
