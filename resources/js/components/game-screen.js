/**
 * Alpine.js wrapper component that combines map and timer
 * Ensures both components initialize properly
 */
import gameMap from './game-map.js';
import gameTimer from './game-timer.js';

export default function gameScreen() {
    const map = gameMap();
    const timer = gameTimer();

    return {
        // Merge all properties from both components
        ...map,
        ...timer,

        // Override init to call both initializers
        init() {
            if (map.init) map.init.call(this);
            if (timer.init) timer.init.call(this);
        },

        // Override destroy to call both destroyers
        destroy() {
            if (map.destroy) map.destroy.call(this);
            if (timer.destroy) timer.destroy.call(this);
        },
    };
}
