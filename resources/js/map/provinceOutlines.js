/**
 * Outlines for Swedish provinces (landskap) on a Leaflet map.
 *
 * Geometry comes from OpenStreetMap (ODbL), clipped to the Natural Earth coastline
 * and simplified. Provinces without their own OSM boundary are built from counties
 * and municipalities. The file is imported lazily so other modes never load it.
 */
const PROVINCE_TYPE = 'swedish_province';

const BORDER_STYLE = {
    color: '#475569',
    weight: 1,
    opacity: 0.7,
    fill: false,
};

const HIGHLIGHT_STYLE = {
    color: '#d946ef',
    weight: 3,
    opacity: 0.9,
    fillColor: '#d946ef',
    fillOpacity: 0.15,
};

let provincesPromise = null;

function loadProvinces() {
    // A failed load is not cached, so a later round can try again.
    provincesPromise ??= import('./swedishProvinces.json')
        .then((module) => module.default)
        .catch((error) => {
            provincesPromise = null;
            throw error;
        });

    return provincesPromise;
}

export function isProvince(place) {
    return place?.type === PROVINCE_TYPE;
}

/**
 * The outline feature for a province, or null when it is missing or failed to load.
 */
export async function findProvinceFeature(name) {
    try {
        const provinces = await loadProvinces();

        return provinces.features.find((item) => item.properties.name === name) ?? null;
    } catch {
        return null;
    }
}

/**
 * Keeps the border layer and the highlighted answer for one map. Async loads are
 * versioned so a highlight that resolves after the round was cleared is dropped.
 */
export function createProvinceOutlines(map) {
    let borders = null;
    let bordersPart = null;
    let highlight = null;
    let version = 0;
    let wantedPart = null;

    return {
        preload() {
            loadProvinces().catch(() => {});
        },

        /**
         * Shows the borders of one part of Sweden ('all' for every province) or hides them.
         */
        async setBordersVisible(visible, swedenPart = 'all') {
            wantedPart = visible ? swedenPart : null;

            if (borders && bordersPart !== wantedPart) {
                borders.remove();
                borders = null;
            }

            if (!visible || borders) {
                return;
            }

            let provinces;
            try {
                provinces = await loadProvinces();
            } catch {
                return;
            }

            if (wantedPart !== swedenPart || borders) {
                return;
            }

            borders = L.geoJSON(provinces, {
                style: BORDER_STYLE,
                interactive: false,
                filter: (feature) => swedenPart === 'all' || feature.properties.part === swedenPart,
            }).addTo(map);
            bordersPart = swedenPart;
            highlight?.bringToFront();
        },

        /**
         * Draws the outline of the place if it is a province and returns the layer.
         * Returns null when there is nothing to draw, the load failed or the round moved on.
         */
        async highlight(place) {
            this.clearHighlight();

            if (!isProvince(place)) {
                return null;
            }

            const currentVersion = version;
            let provinces;
            try {
                provinces = await loadProvinces();
            } catch {
                return null;
            }

            const feature = provinces.features.find((item) => item.properties.name === place.name);

            if (!feature || currentVersion !== version) {
                return null;
            }

            highlight = L.geoJSON(feature, { style: HIGHLIGHT_STYLE, interactive: false }).addTo(map);

            return highlight;
        },

        clearHighlight() {
            version++;
            highlight?.remove();
            highlight = null;
        },
    };
}
