/**
 * Alpine.js component for multiplayer Echo subscriptions
 * ONLY handles real-time events, all business logic is in Livewire
 */
export default function multiplayerManager() {
    return {
        echoChannel: null,

        init() {
            // Listen for subscribe event from Livewire
            this.$wire.$on('subscribe-to-game', (data) => {
                this.subscribeToGame(data.gameCode);
            });

            // Listen for guess submission from Livewire
            this.$wire.$on('submit-mp-guess', (data) => {
                this.submitGuess(data);
            });

            // Listen for next round request from Livewire
            this.$wire.$on('next-mp-round', (data) => {
                this.nextRound(data);
            });

            // Listen for timeout submission from Livewire
            this.$wire.$on('submit-mp-timeout', (data) => {
                this.submitTimeout(data);
            });
        },

        async submitGuess(data) {
            try {
                const response = await fetch('/api/games/guess', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        round_id: data.round_id,
                        player_id: data.player_id,
                        lat: data.lat,
                        lng: data.lng,
                    }),
                });

                if (!response.ok) {
                    console.error('Failed to submit guess');
                }
            } catch (error) {
                console.error('Error submitting guess:', error);
            }
        },

        async submitTimeout(data) {
            try {
                const response = await fetch('/api/games/guess', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        round_id: data.round_id,
                        player_id: data.player_id,
                        lat: null, // Null indicates timeout
                        lng: null,
                    }),
                });

                if (!response.ok) {
                    console.error('Failed to submit timeout');
                }
            } catch (error) {
                console.error('Error submitting timeout:', error);
            }
        },

        async nextRound(data) {
            try {
                const response = await fetch('/api/games/next-round', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        game_id: data.game_id,
                        player_id: data.player_id,
                    }),
                });

                if (!response.ok) {
                    console.error('Failed to request next round');
                }
            } catch (error) {
                console.error('Error requesting next round:', error);
            }
        },

        subscribeToGame(gameCode) {
            // Unsubscribe from previous channel if exists
            if (this.echoChannel) {
                window.Echo.leave(`game.${this.echoChannel}`);
            }

            this.echoChannel = gameCode;

            window.Echo.channel(`game.${gameCode}`)
                .listen('.PlayerJoined', (data) => {
                    console.log('Player joined:', data);
                    // Reload players in Livewire
                    this.$wire.call('loadPlayers');
                })
                .listen('.GameStarted', (data) => {
                    console.log('Game started:', data);
                    // First round will be triggered by RoundStarted event
                })
                .listen('.RoundStarted', (data) => {
                    console.log('Round started:', data);
                    this.$wire.startRound(data.round, data.game);
                })
                .listen('.GuessSubmitted', (data) => {
                    console.log('Guess submitted:', data);
                    // Could show indicator that another player guessed
                })
                .listen('.RoundCompleted', (data) => {
                    console.log('Round completed:', data);
                    this.$wire.showRoundResults(data);
                })
                .listen('.GameCompleted', (data) => {
                    console.log('Game completed:', data);
                    this.$wire.showWinner(data);
                });

            console.log(`Subscribed to game.${gameCode}`);
        },

        destroy() {
            // Cleanup when component is destroyed
            if (this.echoChannel) {
                window.Echo.leave(`game.${this.echoChannel}`);
            }
        },
    };
}
