// Organized places exports
// Import all place categories
import cities from './core/cities.js';
import countries from './core/countries.js';
import islands from './core/islands.js';
import landmarks from './core/landmarks.js';
import generalWineRegions from './wine/general.js';
import docgWineRegions from './wine/docg.js';
import aocWineRegions from './wine/aoc.js';

// Export all categories
export {
    cities,
    countries,
    islands,
    landmarks,
    generalWineRegions,
    docgWineRegions,
    aocWineRegions
};

// Combined exports by type
export const placesByType = {
    stad: cities,
    land: countries,
    ö: islands,
    plats: landmarks,
    vin: generalWineRegions,
    docg: docgWineRegions,
    aoc: aocWineRegions
};

// All places combined (for backwards compatibility or bulk operations)
export const allPlaces = [
    ...cities,
    ...countries,
    ...islands,
    ...landmarks,
    ...generalWineRegions,
    ...docgWineRegions,
    ...aocWineRegions
];

// Helper function to get places by difficulty
export function getPlacesByDifficulty(difficulty) {
    return allPlaces.filter(place => place.difficulty.includes(difficulty));
}

// Helper function to get places by type and difficulty
export function getPlacesByTypeAndDifficulty(type, difficulty) {
    const places = placesByType[type] || [];
    return places.filter(place => place.difficulty.includes(difficulty));
}

// Statistics
export const stats = {
    total: allPlaces.length,
    byType: {
        stad: cities.length,
        land: countries.length,
        ö: islands.length,
        plats: landmarks.length,
        vin: generalWineRegions.length,
        docg: docgWineRegions.length,
        aoc: aocWineRegions.length
    }
};

// Backward-compatible export (matches old places.js structure)
// This allows existing code to import with: import places from './places'
// and access places.easy, places.medium, places.hard
const placesByDifficulty = {
    easy: getPlacesByDifficulty('easy'),
    medium: getPlacesByDifficulty('medium'),
    hard: getPlacesByDifficulty('hard')
};

export default placesByDifficulty;
