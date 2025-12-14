# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

GeoPinner is a geography guessing game built with Laravel 12, Livewire 3, and Volt. Players guess locations on a map (countries, cities, wine regions, etc.) and earn points based on accuracy and speed. The game supports both single-player and real-time multiplayer modes.

## Common Commands

### Development
```bash
# Start development server with all services (Laravel, queue, logs, Vite)
composer run dev

# Build frontend assets
npm run build

# Run development Vite server
npm run dev

# Code formatting with Laravel Pint
vendor/bin/pint --dirty
```

### Testing
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/Livewire/GameTest.php

# Run tests matching a filter
php artisan test --filter=testName
```

### Multiplayer/Broadcasting
```bash
# Start Laravel Reverb WebSocket server (required for multiplayer)
php artisan reverb:start

# Reverb runs at reverb.herd.test:443 (HTTPS) when using Laravel Herd
```

### Database
```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Fresh database with seed data
php artisan migrate:fresh --seed
```

## Architecture

### Game Modes

The application has two parallel implementations:

1. **Livewire/Volt Version** (routes: `/game-v2`, `/multiplayer-v2`)
   - Modern implementation using Livewire components
   - Interactive, server-driven UI
   - Primary version going forward

2. **Vanilla JS Version** (routes: `/multiplayer`)
   - Original implementation with vanilla JavaScript
   - Uses API endpoints from `GameController`
   - Legacy support

### Core Domain Models

- **Place** (`app/Models/Place.php`): Geographic locations with lat/lng coordinates, type, difficulty, and size (radius)
- **Game** (`app/Models/Game.php`): Multiplayer game sessions with code, settings, and status
- **Player** (`app/Models/Player.php`): Participants in multiplayer games
- **Round** (`app/Models/Round.php`): Individual rounds within a game
- **Guess** (`app/Models/Guess.php`): Player guesses with coordinates and scoring

### Key Enums

- **Difficulty** (`app/Enums/Difficulty.php`): Easy, Medium, Hard
- **PlaceType** (`app/Enums/PlaceType.php`): Mixed, Location, Island, City, Capital, Country, WineRegion, DOCG, AOC
- **NumRound** (`app/Enums/NumRound.php`): Number of rounds options
- **TimeDuration** (`app/Enums/TimeDuration.php`): Timer duration options

### Services

- **PlaceService** (`app/Services/PlaceService.php`): Fetches and filters places by difficulty and type
- **ScoringService** (`app/Services/ScoringService.php`): Calculates points based on distance from target
  - Standard thresholds for most places
  - Stricter thresholds (2x harder) for wine regions (vin, docg, aoc)
  - Accounts for place size/radius when calculating adjusted distance
  - Returns points (0-10), emoji, message, and CSS class

### Livewire Components

- **Game** (`app/Livewire/Game.php`): Single-player game logic
  - Manages game state (setup, game, result screens)
  - Handles place selection, scoring, time bonuses
  - Stores shuffled places in session to avoid hydration issues
  - Fisher-Yates shuffle for randomization

- **Multiplayer** (`app/Livewire/Multiplayer.php`): Multiplayer game coordination
  - Creates/joins games with unique codes
  - Broadcasts events via Laravel Reverb
  - Synchronizes state across all players

### Real-Time Broadcasting

Uses **Laravel Reverb** for WebSocket communication:

- Game channels: `game.{code}` for isolated per-game communication
- Events broadcast in `app/Events/`:
  - `PlayerJoined`, `GameStarted`, `RoundStarted`
  - `GuessSubmitted`, `RoundCompleted`, `GameCompleted`
- See `MULTIPLAYER.md` for detailed broadcasting setup

### Frontend Architecture

- **JavaScript**: Modular components in `resources/js/`
  - `game/`: Game state management, scoring logic
  - `map/`: Leaflet map integration
  - `ui/`: Timer, feedback display
  - `components/`: Reusable Alpine.js components for Livewire version

- **Styles**: Tailwind CSS v4 in `resources/css/app.css`
  - Uses `@import "tailwindcss"` (not `@tailwind` directives)
  - Custom theme extensions with `@theme` directive

- **Views**: Blade templates in `resources/views/`
  - `layouts/app.blade.php`: Base layout with Flux UI components
  - `livewire/game.blade.php`: Single-player game UI
  - `livewire/multiplayer.blade.php`: Multiplayer game UI
  - `home.blade.php`: Landing page

## Important Patterns

### Place Data Storage

Places are stored in the `places` table with:
- `difficulty`: JSON array (e.g., `["easy", "medium"]`) - a place can appear in multiple difficulties
- `size`: Radius in kilometers for scoring tolerance
- `type`: One of the PlaceType enum values

Use `Place::difficulty($difficulty)` scope to filter by difficulty (uses `whereJsonContains`).

### Scoring Algorithm

1. Calculate Haversine distance between guess and actual location
2. Adjust distance by subtracting place size: `max(0, distance - place['size'])`
3. Apply thresholds (standard or wine) to determine points (0-10)
4. Calculate time bonus if timer enabled and points >= 7:
   - 3 points: < 25% of time
   - 2 points: < 50% of time
   - 1 point: < 75% of time

### Session vs. Component State

The Livewire `Game` component stores the shuffled `game_places` array in the session (not component state) to avoid large hydration payloads. Each round retrieves the current place from session.

### Livewire Event Pattern

Components dispatch events to Alpine.js for map interactions:
- `clear-map`: Reset map markers
- `show-result`: Display user guess vs. actual location
- `show-timeout-result`: Display correct location on timeout
- `round-complete`: Trigger next round transition

## Development Notes

### Database Seeding

The `export-places.mjs` script is used to populate the places database. Place data is seeded from external sources.

### Flux UI Components

This project uses **Flux Pro** with access to all free and pro components. Common components:
- `<flux:button>`, `<flux:input>`, `<flux:select>`
- `<flux:card>`, `<flux:heading>`, `<flux:badge>`
- Always check existing views for component usage patterns

### Volt Components

The project uses **class-based Volt** components (not functional). Components extend `Livewire\Volt\Component` using anonymous classes within `@volt` directives.

### Testing Strategy

- Use Pest for all tests (not PHPUnit syntax)
- Feature tests in `tests/Feature/`
- Livewire component tests in `tests/Feature/Livewire/`
- Browser tests (Pest v4) can be added in `tests/Browser/` for E2E testing
- Always run relevant tests after changes: `php artisan test --filter=GameTest`

### Running in Laravel Herd

- Site available at: `https://geopinner.test` (managed by Herd)
- Reverb runs at: `https://reverb.herd.test:443`
- No need to manually start `php artisan serve`
- Use `get-absolute-url` tool to generate correct URLs

## API Endpoints (for Vanilla JS version)

```
POST   /api/games/create       - Create new multiplayer game
POST   /api/games/join         - Join existing game
GET    /api/games/{code}/players - Get players in game
POST   /api/games/start        - Start game (host only)
POST   /api/games/guess        - Submit player guess
POST   /api/games/next-round   - Advance to next round
GET    /api/places             - Get places for single-player
```

## Configuration

Key environment variables:
- `BROADCAST_CONNECTION=reverb`
- `REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET`
- `REVERB_HOST`, `REVERB_PORT`, `REVERB_SCHEME`
- `VITE_REVERB_*` variables must match `REVERB_*` for frontend

See `MULTIPLAYER.md` for complete Reverb configuration details.
