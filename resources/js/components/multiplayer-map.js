/**
 * Alpine.js component for multiplayer Leaflet map
 */
import { withCartoKey } from '../map/cartoKey.js';
import { resetMapView } from '../map/mapView.js';
import { createProvinceOutlines, isProvince } from '../map/provinceOutlines.js';

export default function multiplayerMap() {
    return {
        map: null,
        userMarker: null,
        tileLayer: null,
        markers: [],
        lines: [],
        provinceOutlines: null,

        init() {
            // Initialize map when round starts
            this.$wire.$on('round-started-mp', () => {
                this.$nextTick(() => {
                    if (!this.map) {
                        this.initMap();
                    } else {
                        this.clearMap();
                        this.resetView();
                        this.syncProvinceBorders();
                    }
                });
            });

            // Show results when round completes
            this.$wire.$on('show-mp-round-results', (data) => {
                this.showRoundResults(data);
            });
        },

        initMap() {
            if (this.map) return;

            const mapContainer = document.getElementById('mpMap');
            if (!mapContainer) {
                console.error('Multiplayer map container not found');
                return;
            }

            this.map = L.map('mpMap', {
                center: [20, 0],
                zoom: 2,
                minZoom: 2,
                maxZoom: 6,
                scrollWheelZoom: true,
                doubleClickZoom: true,
                worldCopyJump: true,
                zoomControl: true,
            });

            this.setTileLayer();

            this.provinceOutlines = createProvinceOutlines(this.map);
            if (isProvince(this.$wire.currentPlace)) {
                this.provinceOutlines.preload();
            }

            setTimeout(() => {
                if (this.map) {
                    this.map.invalidateSize();
                    this.resetView();
                    this.syncProvinceBorders();
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
            if (this.tileLayer) {
                this.map.removeLayer(this.tileLayer);
            }

            const style = this.$wire.showLabels ? 'light_all' : 'light_nolabels';
            const tileUrl = withCartoKey(`https://{s}.basemaps.cartocdn.com/${style}/{z}/{x}/{y}.png`);

            this.tileLayer = L.tileLayer(tileUrl, {
                attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                subdomains: 'abcd',
                maxZoom: 19,
            });

            this.tileLayer.addTo(this.map);
        },

        syncProvinceBorders() {
            this.provinceOutlines?.setBordersVisible(
                this.$wire.showProvinceBorders && isProvince(this.$wire.currentPlace),
                this.$wire.swedenPart
            );
        },

        handleMapClick(latlng) {
            // Add temporary user marker
            if (this.userMarker) {
                this.map.removeLayer(this.userMarker);
            }

            const userIcon = L.icon({
                iconUrl: '/pin_user.png',
                iconSize: [16, 40],
                iconAnchor: [10, 40],
            });

            this.userMarker = L.marker([latlng.lat, latlng.lng], {
                icon: userIcon,
            }).addTo(this.map);

            // Submit guess to Livewire
            this.$wire.submitGuess(latlng.lat, latlng.lng);
        },

        async showRoundResults(data) {
            const placeData = data.round.place;

            // Add correct location marker
            const placeIcon = L.icon({
                iconUrl: '/pin_place.png',
                iconSize: [16, 40],
                iconAnchor: [10, 40],
            });

            const placeMarker = L.marker([placeData.lat, placeData.lng], {
                icon: placeIcon,
            }).addTo(this.map);

            this.markers.push(placeMarker);

            // Add all players' guess markers
            if (data.guesses) {
                data.guesses.forEach(guess => {
                    // Circle marker with player color
                    const circleMarker = L.circleMarker([guess.lat, guess.lng], {
                        radius: 10,
                        fillColor: guess.player.color,
                        color: '#fff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8,
                    }).addTo(this.map);

                    circleMarker.bindPopup(`
                        <strong>${guess.player.name}</strong><br>
                        Poäng: ${guess.score}<br>
                        Avstånd: ${Math.round(guess.distance)} km
                    `);

                    this.markers.push(circleMarker);

                    // Draw line from guess to correct location
                    const line = L.polyline([
                        [guess.lat, guess.lng],
                        [placeData.lat, placeData.lng],
                    ], {
                        color: guess.player.color,
                        weight: 2,
                        opacity: 0.5,
                        dashArray: '5, 10',
                    }).addTo(this.map);

                    this.lines.push(line);
                });
            }

            // Fit bounds to show all markers and the province outline
            const bounds = L.latLngBounds([
                [placeData.lat, placeData.lng],
                ...data.guesses.map(g => [g.lat, g.lng]),
            ]);
            this.map.fitBounds(bounds, { padding: [50, 50] });

            const outline = await this.provinceOutlines?.highlight(placeData);
            if (outline) {
                this.map.fitBounds(bounds.extend(outline.getBounds()), { padding: [50, 50] });
            }
        },

        clearMap() {
            // Remove user marker
            if (this.userMarker) {
                this.map.removeLayer(this.userMarker);
                this.userMarker = null;
            }

            // Remove all markers
            this.markers.forEach(marker => {
                this.map.removeLayer(marker);
            });
            this.markers = [];

            // Remove all lines
            this.lines.forEach(line => {
                this.map.removeLayer(line);
            });
            this.lines = [];

            this.provinceOutlines?.clearHighlight();
        },

        resetView() {
            if (this.map) {
                resetMapView(this.map, this.$wire.currentPlace, true, this.$wire.swedenPart);
            }
        },

        destroy() {
            if (this.map) {
                this.map.remove();
                this.map = null;
            }
        },
    };
}
