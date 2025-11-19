# GeoPinner

## Project Overview

GeoPinner is a web-based geography quiz game where players have to pinpoint locations on a map. The game is built with vanilla JavaScript, using Vite for the development server and build process, and Leaflet.js for the interactive map. The application is also a Progressive Web App (PWA), allowing it to be installed on mobile devices.

The project is structured into several modules:

*   `main.js`: The main entry point of the application, responsible for coordinating the different modules and handling user interactions.
*   `game/state.js`: Manages the game's state, including settings, score, and progress.
*   `game/placeSelector.js`: Selects the places for each round based on the chosen game type and difficulty.
*   `game/scoring.js`: Calculates the player's score based on the distance between their guess and the actual location.
*   `map/mapManager.js`: Encapsulates the Leaflet.js map functionality, such as adding markers, drawing lines, and handling map events.
*   `ui/screens.js`: Manages the different UI screens of the game (setup, game, and result).

## Building and Running

### Prerequisites

*   Node.js and npm

### Development

To run the development server, execute the following command:

```bash
npm run dev
```

### Build

To build the application for production, execute the following command:

```bash
npm run build
```

This will create a `dist` directory with the optimized and bundled files.

### Preview

To preview the production build locally, execute the following command:

```bash
npm run preview
```

## Development Conventions

The code is written in modern JavaScript (ES modules) and follows a modular pattern. The code is well-commented, and the file structure is organized by feature. There are no linters or formatters configured in the project, but the code is clean and easy to read.
