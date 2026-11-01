/**
 * Start view for a round. Swedish provinces get a map framed around Sweden or the
 * chosen part of it, everything else starts with the whole world.
 */
const SWEDEN_BOUNDS = {
    all: [[55.2, 10.9], [69.1, 24.2]],
    norrland: [[60.1, 11.9], [69.1, 24.2]],
    svealand: [[58.5, 11.6], [62.4, 19.2]],
    gotaland: [[55.2, 11.0], [59.4, 19.4]],
};
const WORLD_MIN_ZOOM = 2;
const WORLD_MAX_ZOOM = 6;
const SWEDEN_EXTRA_ZOOM = 3;

export function resetMapView(map, place, zoomEnabled = true, swedenPart = 'all') {
    if (place?.type === 'swedish_province') {
        const bounds = SWEDEN_BOUNDS[swedenPart] ?? SWEDEN_BOUNDS.all;
        const fittedZoom = map.getBoundsZoom(bounds);

        map.setMinZoom(zoomEnabled ? WORLD_MIN_ZOOM : fittedZoom);
        map.setMaxZoom(zoomEnabled ? fittedZoom + SWEDEN_EXTRA_ZOOM : fittedZoom);
        map.fitBounds(bounds);

        return;
    }

    map.setMinZoom(WORLD_MIN_ZOOM);
    map.setMaxZoom(zoomEnabled ? WORLD_MAX_ZOOM : WORLD_MIN_ZOOM);
    map.setView([20, 0], WORLD_MIN_ZOOM);
}
