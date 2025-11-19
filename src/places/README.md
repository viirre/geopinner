# Places Database Organization

This directory contains the organized and deduplicated places database for Geopinner.

## Structure

```
places/
├── core/
│   ├── cities.js        # 222 cities (type: "stad")
│   ├── countries.js     # 142 countries (type: "land")
│   ├── islands.js       # 57 islands (type: "ö")
│   └── landmarks.js     # 66 landmarks (type: "plats")
├── wine/
│   ├── general.js       # 48 wine regions (type: "vin")
│   ├── docg.js         # 34 Italian DOCG regions (type: "docg")
│   └── aoc.js          # 42 French AOC regions (type: "aoc")
├── index.js            # Main export file with helpers (backward-compatible)
└── README.md           # This file
```

## Statistics

- **Original entries**: 750 places
  - Easy: 196
  - Medium: 224
  - Hard: 330
- **Unique places after deduplication**: 611
- **Duplicates removed**: 139 (18.5% reduction)

## Deduplication

Places were deduplicated based on name + coordinates (rounded to 4 decimal places). When duplicates were found:

1. **Difficulty levels were merged** into an array. For example:
   - "Bangkok, Thailand" appears in easy, medium, and hard → `difficulty: ['easy', 'medium', 'hard']`
   - "Paris, Frankrike" appears only in easy → `difficulty: ['easy']`

2. **Data from easier difficulty was preferred** for conflicting values:
   - If size differs, the value from the easiest difficulty is kept
   - Capital flags are preserved from any occurrence

3. **Type from first occurrence was kept** (easiest difficulty first)

## Type Inconsistency Resolutions

During deduplication, 16 places were found with inconsistent types. Here are the decisions made:

### Critical Decisions

1. **Vatikanstaten** (Vatican City)
   - Found as: `plats` and `land`
   - **Resolution**: Kept as `plats` (landmark)
   - **Rationale**: While Vatican City is technically a country, in the context of the game it works better as a landmark/specific place

2. **Island** (Iceland)
   - Found as: `ö` and `land`
   - **Resolution**: Kept as `ö` (island)
   - **Rationale**: The name literally means "Iceland" and it appeared first as an island in the easy difficulty

3. **Filippinerna** (Philippines)
   - Found as: `land` and `ö`
   - **Resolution**: Kept as `land` (country)
   - **Rationale**: While Philippines is an archipelago, it's primarily a country in the game context

4. **Bordeaux, Frankrike**
   - Found as: `vin` and `stad`
   - **Resolution**: Kept as `vin` (wine region)
   - **Rationale**: In the context of this game, Bordeaux is more commonly referenced as a wine region

### Wine Region Overlaps (AOC vs General)

French wine regions that appeared as both `aoc` and `vin` were kept as `aoc` (more specific):
- Pauillac, Bordeaux
- Margaux, Bordeaux
- Saint-Émilion, Bordeaux
- Pomerol, Bordeaux
- Sauternes, Bordeaux
- Hermitage, Rhône
- Côte-Rôtie, Rhône
- Muscadet, Loire
- Sancerre, Loire
- Vouvray, Loire

### Wine Region Overlaps (DOCG vs General)

Italian wine regions that appeared as both `docg` and `vin` were kept as `docg` (more specific):
- Barbaresco, Piemonte
- Barbera d'Asti, Piemonte

**Rationale**: The more specific wine classification (AOC/DOCG) is more accurate and useful for wine-focused game modes.

## Usage

### Import everything:
```javascript
import {
  cities,
  countries,
  islands,
  landmarks,
  generalWineRegions,
  docgWineRegions,
  aocWineRegions,
  placesByType,
  allPlaces,
  getPlacesByDifficulty,
  getPlacesByTypeAndDifficulty
} from './places/index.js';
```

### Get places by difficulty:
```javascript
const easyPlaces = getPlacesByDifficulty('easy');
const hardCities = getPlacesByTypeAndDifficulty('stad', 'hard');
```

### Get places by type:
```javascript
const allCities = placesByType.stad;
const allWineRegions = [...generalWineRegions, ...docgWineRegions, ...aocWineRegions];
```

## Place Object Format

Each place has the following structure:

```javascript
{
  name: "Paris, Frankrike",          // Display name
  lat: 48.8566,                       // Latitude
  lng: 2.3522,                        // Longitude
  type: "stad",                       // Type: stad/land/ö/plats/vin/docg/aoc
  capital: true,                      // Optional: true if capital city
  size: 15,                           // Radius in km (affects scoring)
  difficulty: ['easy']                // Array of difficulty levels
}
```

## Backwards Compatibility

The `index.js` file provides a backward-compatible export structure that matches the old `places.js` format:

```javascript
import places from './places/index.js';
const easyPlaces = places.easy;      // Returns all places with difficulty: ['easy']
const mediumPlaces = places.medium;  // Returns all places with difficulty: ['medium']
const hardPlaces = places.hard;      // Returns all places with difficulty: ['hard']
```

Existing code using this pattern continues to work without changes.

## Migration Notes

To migrate existing code to use the new organized structure:

1. **For difficulty-based filtering**: Use `getPlacesByDifficulty(difficulty)` instead of `places.easy`, `places.medium`, `places.hard`
2. **For type-based filtering**: Use `placesByType[type]` or the individual exports
3. **For combined filtering**: Use `getPlacesByTypeAndDifficulty(type, difficulty)`

Example migration:
```javascript
// Old way
const easyPlaces = places.easy;
const easyCities = easyPlaces.filter(p => p.type === 'stad');

// New way
const easyCities = getPlacesByTypeAndDifficulty('stad', 'easy');
```
