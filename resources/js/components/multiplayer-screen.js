/**
 * Alpine.js wrapper for multiplayer screen
 * Combines multiplayer manager and map components
 */
import multiplayerManager from './multiplayer-manager.js';
import multiplayerMap from './multiplayer-map.js';
import gameTimer from './game-timer.js';

export default function multiplayerScreen() {
    const manager = multiplayerManager();
    const map = multiplayerMap();
    const timer = gameTimer();

    return {
        // Merge all properties
        ...manager,
        ...map,
        ...timer,

        // Override init to call all initializers
        init() {
            if (manager.init) manager.init.call(this);
            if (map.init) map.init.call(this);
            if (timer.init) timer.init.call(this);
        },

        // Override destroy to call all destroyers
        destroy() {
            if (manager.destroy) manager.destroy.call(this);
            if (map.destroy) map.destroy.call(this);
            if (timer.destroy) timer.destroy.call(this);
        },
    };
}
