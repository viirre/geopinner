# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Geopinner is a Swedish-language interactive geography quiz game built with vanilla JavaScript and Vite. Players are shown a location name (cities, countries, islands, wine regions, etc.) and must click on a map to guess where it is located. The game calculates distance accuracy and awards points (0-10) based on how close the guess is.

## Development Commands

- `npm run dev` - Start development server with hot reload
- `npm run build` - Build for production (outputs to `dist/`)
- `npm run preview` - Preview production build locally

## Code Architecture

### Entry Points and Structure

- **index.html**: Main HTML template with Swedish UI text, defines three screens (setup, game, result)
- **src/main.js**: Core game logic and state management (380 lines)
- **src/places.js**: Location database with ~760 lines of place data organized by difficulty
- **src/style.css**: Complete styling with animations and responsive design
- **public/**: Static assets (pin_user.png, pin_place.png marker icons)

### Game Flow

1. **Setup Screen**: User selects difficulty (easy/medium/hard), game type (mixed/countries/cities/wine regions/DOCG/AOC), and number of rounds (5/10/15/20)
2. **Game Screen**: Shows question ("Var ligger X?"), interactive map, and score tracking
3. **Result Screen**: Shows final score, performance message, and round-by-round breakdown

### Map Integration

- Uses **Leaflet.js** (v1.9.4) loaded from CDN
- Two tile style options in main.js:5-18:
  - `voyager`: CARTO Voyager (default in code)
  - `positron`: CARTO Positron (clearer borders, currently active via CURRENT_TILE_STYLE)
- **Difficulty-based labels**: Easy mode shows labeled maps, medium/hard show unlabeled maps (main.js:124-134)
- Map settings: center [20,0], zoom 2-10 range, world copy jump enabled

### Places Database Structure

Located in `src/places.js` with three difficulty tiers:

```javascript
{
  easy: [...],    // ~187 places - major cities, large countries, famous landmarks
  medium: [...],  // ~230 places - smaller cities, regions, wine areas
  hard: [...]     // Challenging locations
}
```

Each place object:
```javascript
{
  name: "Stockholm, Sverige",
  lat: 59.3293,
  lng: 18.0686,
  type: "stad",     // stad, land, ö, plats, vin, docg, aoc
  size: 12          // radius in km - affects scoring tolerance
}
```

Place types:
- `stad`: City
- `land`: Country
- `ö`: Island
- `plats`: Landmark/specific location
- `vin`: Wine region
- `docg`: Italian DOCG wine regions
- `aoc`: French AOC wine regions

### Scoring System

Points are calculated in main.js:248-295 based on adjusted distance:
- Adjusted distance = actual distance - place size (radius)
- Distance bands award 10 → 1 points (e.g., <50km = 10pts, <200km = 9pts, etc.)
- Distance shown in Swedish miles (1 mil = 10 km)

### Game State Management

Key global variables in main.js:
- `gameSettings`: {difficulty, rounds, gameType}
- `currentRound`, `totalScore`, `currentPlace`, `hasGuessed`
- `roundHistory`: Array storing each round's results
- `usedPlaces`: Prevents duplicate locations in same game
- Leaflet objects: `map`, `tileLayer`, `userMarker`, `placeMarker`, `distanceLine`

### Visual Feedback

- Custom pin markers (red for user, different color for correct location)
- Animated dashed line connecting guess to correct location
- Color-coded feedback: excellent (green), good (blue), okay (orange), poor (red)
- CSS animations for marker drops and line dashes

## Key Implementation Details

### Place Filtering

`getFilteredPlaces()` in main.js:72-90 filters the places database by:
1. Difficulty level (easy/medium/hard)
2. Game type (blandat/lander/stader/vin/docg/aoc)

Validates sufficient places exist before starting game (main.js:93-98).

### Map Tile Style Switching

To change map style, modify `CURRENT_TILE_STYLE` constant in main.js:21. Available styles defined in TILE_STYLES object (main.js:5-18).

### Preventing Duplicate Places

`usedPlaces` array tracks selected places per game session (main.js:41, 105, 164-175). Resets when all available places exhausted.

### Marker Positioning

Custom Leaflet icons use `iconAnchor: [10, 40]` to position the pin tip correctly at the coordinates (main.js:203-227).

## Language

All UI text is in Swedish. When adding features, maintain Swedish language for user-facing strings.
