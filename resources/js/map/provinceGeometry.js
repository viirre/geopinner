/**
 * Point checks against a province outline, so a guess in a neighbouring province
 * can be told apart from one in the right one. Mirrors App\Services\ProvinceGeometry.
 */

// Outlines are simplified, so guesses this close to the border count as inside.
const BORDER_TOLERANCE_KM = 3;
const KM_PER_DEGREE_LAT = 110.574;
const KM_PER_DEGREE_LNG_AT_EQUATOR = 111.32;

function polygonsOf(feature) {
    return feature.geometry.type === 'Polygon'
        ? [feature.geometry.coordinates]
        : feature.geometry.coordinates;
}

function contains(polygons, lat, lng) {
    return polygons.some((rings) => {
        let inside = false;

        for (const ring of rings) {
            for (let i = 0, j = ring.length - 1; i < ring.length; j = i++) {
                const [xi, yi] = ring[i];
                const [xj, yj] = ring[j];

                if ((yi > lat) !== (yj > lat) && lng < (xj - xi) * (lat - yi) / (yj - yi) + xi) {
                    inside = !inside;
                }
            }
        }

        return inside;
    });
}

function distanceFromOriginToSegment(ax, ay, bx, by) {
    const dx = bx - ax;
    const dy = by - ay;
    const lengthSquared = dx * dx + dy * dy;
    const t = lengthSquared > 0 ? Math.max(0, Math.min(1, -(ax * dx + ay * dy) / lengthSquared)) : 0;

    return Math.hypot(ax + t * dx, ay + t * dy);
}

// Shortest distance to any edge, in a flat projection centred on the guess.
function distanceToEdgesKm(polygons, lat, lng) {
    const kmPerDegreeLng = KM_PER_DEGREE_LNG_AT_EQUATOR * Math.cos(lat * Math.PI / 180);
    let shortest = Infinity;

    for (const rings of polygons) {
        for (const ring of rings) {
            for (let i = 1; i < ring.length; i++) {
                shortest = Math.min(shortest, distanceFromOriginToSegment(
                    (ring[i - 1][0] - lng) * kmPerDegreeLng,
                    (ring[i - 1][1] - lat) * KM_PER_DEGREE_LAT,
                    (ring[i][0] - lng) * kmPerDegreeLng,
                    (ring[i][1] - lat) * KM_PER_DEGREE_LAT,
                ));
            }
        }
    }

    return shortest;
}

/**
 * Distance in km from the guess to the province border, 0 when the guess is inside.
 */
export function kmOutsideBorder(feature, lat, lng) {
    const polygons = polygonsOf(feature);

    if (contains(polygons, lat, lng)) {
        return 0;
    }

    const distance = distanceToEdgesKm(polygons, lat, lng);

    return distance <= BORDER_TOLERANCE_KM ? 0 : distance;
}
