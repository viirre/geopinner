/**
 * Alpine.js component for game timer countdown
 * Handles visual countdown and auto-submit on timeout
 */
export default function gameTimer() {
    return {
        timeRemaining: 0,
        intervalId: null,
        isRunning: false,

        init() {
            // Listen for round-started event to reset timer (single player)
            this.$wire.$on('round-started', () => {
                this.startTimer();
            });

            // Listen for round-started-mp event (multiplayer)
            this.$wire.$on('round-started-mp', () => {
                this.startTimer();
            });

            // Listen for round-complete to stop timer
            this.$wire.$on('round-complete', () => {
                this.stopTimer();
            });

            // Listen for game-finished to stop timer
            this.$wire.$on('game-finished', () => {
                this.stopTimer();
            });

            // Start timer if already on game screen with timer enabled
            if (this.$wire.screen === 'game' && this.$wire.timerEnabled) {
                this.startTimer();
            }
        },

        startTimer() {
            if (!this.$wire.timerEnabled) return;

            // Reset time to duration
            this.timeRemaining = this.$wire.timerDuration;
            this.isRunning = true;

            // Clear any existing interval
            if (this.intervalId) {
                clearInterval(this.intervalId);
            }

            // Start countdown
            this.intervalId = setInterval(() => {
                this.timeRemaining--;

                if (this.timeRemaining <= 0) {
                    this.handleTimeout();
                }
            }, 1000);
        },

        stopTimer() {
            this.isRunning = false;
            if (this.intervalId) {
                clearInterval(this.intervalId);
                this.intervalId = null;
            }
        },

        handleTimeout() {
            this.stopTimer();
            // Call Livewire method to handle timeout
            this.$wire.handleTimeout();
        },

        getTimerClass() {
            if (this.timeRemaining <= 3) {
                return 'text-red-600 dark:text-red-400 font-bold';
            } else if (this.timeRemaining <= 5) {
                return 'text-orange-600 dark:text-orange-400';
            }
            return '';
        },

        destroy() {
            this.stopTimer();
        },
    };
}
