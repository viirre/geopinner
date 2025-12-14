/**
 * GeoPinner - Livewire Version
 * Entry point for Livewire + Alpine.js version
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Setup Pusher for Laravel Echo
window.Pusher = Pusher;

// Initialize Laravel Echo for real-time features (multiplayer)
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Alpine.js components - Use Livewire's built-in Alpine
import gameScreen from './components/game-screen.js';
import multiplayerScreen from './components/multiplayer-screen.js';

// Register Alpine components using Livewire's Alpine instance
document.addEventListener('alpine:init', () => {
    window.Alpine.data('gameScreen', gameScreen);
    window.Alpine.data('multiplayerScreen', multiplayerScreen);
    console.log('Alpine components registered');
});

console.log('GeoPinner Livewire version loaded');
console.log('Echo ready for real-time events');
