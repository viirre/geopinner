/**
 * Game state management module for Geopinner
 * Centralized state management with timer support
 */

import { PlaceSelector } from './placeSelector.js';

/**
 * GameState class manages all game state and logic
 */
export class GameState {
    constructor() {
        this.reset();
    }

    /**
     * Reset all game state
     */
    reset() {
        // Game settings
        this.settings = {
            difficulty: 'medium',
            rounds: 10,
            gameTypes: ['mixed'],  // Changed to array for multi-selection
            zoomEnabled: true,
            showLabels: false,
            timerEnabled: true,   // Timer enabled by default
            timerDuration: 10     // Seconds per round (default 10s)
        };

        // Game progress
        this.currentRound = 0;
        this.totalScore = 0;
        this.totalBonus = 0;
        this.currentPlace = null;
        this.hasGuessed = false;
        this.roundHistory = [];
        this.placeSelector = null;

        // Timer state
        this.timerInterval = null;
        this.timeRemaining = 0;
        this.roundStartTime = 0;
        this.roundEndTime = 0;
    }

    /**
     * Update game settings
     * @param {Object} newSettings - Settings to update
     */
    updateSettings(newSettings) {
        this.settings = { ...this.settings, ...newSettings };
    }

    /**
     * Start a new game
     * @returns {Promise<Object>} Validation result
     */
    async startGame() {
        console.log("Starting game with settings:", this.settings);

        // Fetch places from API
        try {
            // Build query params with array support
            const params = new URLSearchParams();
            params.append('difficulty', this.settings.difficulty);
            this.settings.gameTypes.forEach(type => {
                params.append('gameTypes[]', type);
            });

            const response = await fetch('/api/places?' + params.toString());

            if (!response.ok) {
                throw new Error('Failed to fetch places');
            }

            const data = await response.json();

            if (!data.success || !data.places || data.places.length === 0) {
                return {
                    success: false,
                    error: 'Inga platser hittades för denna kombination. Välj andra inställningar.'
                };
            }

            // Create place selector with fetched places
            this.placeSelector = new PlaceSelector(
                data.places,
                this.settings.gameTypes
            );

            // Validate enough places available
            if (!this.placeSelector.hasEnoughPlaces(this.settings.rounds)) {
                return {
                    success: false,
                    error: `Det finns bara ${this.placeSelector.getCount()} platser i denna kombination. Välj färre rundor eller byt speltyp/svårighetsgrad.`
                };
            }

            // Reset game state
            this.currentRound = 0;
            this.totalScore = 0;
            this.totalBonus = 0;
            this.roundHistory = [];

            return { success: true };
        } catch (error) {
            console.error('Error fetching places:', error);
            return {
                success: false,
                error: 'Kunde inte ladda platser. Försök igen.'
            };
        }
    }

    /**
     * Start next round
     * @returns {Object} Round data
     */
    nextRound() {
        this.currentRound++;
        this.hasGuessed = false;
        this.currentPlace = this.placeSelector.next();

        // Start timer if enabled
        if (this.settings.timerEnabled) {
            this.startTimer();
        }

        return {
            round: this.currentRound,
            totalRounds: this.settings.rounds,
            place: this.currentPlace,
            score: this.totalScore
        };
    }

    /**
     * Start the round timer
     */
    startTimer() {
        this.timeRemaining = this.settings.timerDuration;
        this.roundStartTime = Date.now();
        this.roundEndTime = null;

        // Clear any existing timer
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
        }
    }

    /**
     * Stop the round timer and return time taken
     * @returns {number} Time taken in seconds
     */
    stopTimer() {
        this.roundEndTime = Date.now();
        const timeTaken = Math.round((this.roundEndTime - this.roundStartTime) / 1000);

        if (this.timerInterval) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        }

        return timeTaken;
    }

    /**
     * Calculate time bonus based on speed
     * @param {number} timeTaken - Time taken in seconds
     * @param {number} basePoints - Base points earned
     * @returns {number} Bonus points (0-3)
     */
    calculateTimeBonus(timeTaken, basePoints) {
        // Only give bonus for good guesses (7+ points)
        if (basePoints < 7) {
            return 0;
        }

        const duration = this.settings.timerDuration;

        // Very fast: < 25% of time
        if (timeTaken < duration * 0.25) {
            return 3;
        }
        // Fast: < 50% of time
        else if (timeTaken < duration * 0.5) {
            return 2;
        }
        // Decent: < 75% of time
        else if (timeTaken < duration * 0.75) {
            return 1;
        }

        return 0;
    }

    /**
     * Submit a guess for the current round
     * @param {number} userLat - User's guess latitude
     * @param {number} userLng - User's guess longitude
     * @param {number} kmDistance - Distance in kilometers
     * @param {Object} scoreResult - Result from scoring.calculateScore()
     * @returns {Object} Round result
     */
    submitGuess(userLat, userLng, kmDistance, scoreResult) {
        if (this.hasGuessed) {
            throw new Error('Already guessed this round');
        }

        this.hasGuessed = true;

        // Calculate time bonus if timer enabled
        let timeBonus = 0;
        let timeTaken = 0;

        if (this.settings.timerEnabled && this.roundStartTime) {
            timeTaken = this.stopTimer();
            timeBonus = this.calculateTimeBonus(timeTaken, scoreResult.points);
        }

        // Add base points to totalScore, bonuses to totalBonus
        this.totalScore += scoreResult.points;
        this.totalBonus += timeBonus;
        const totalPoints = scoreResult.points + timeBonus;

        // Record round history
        const roundResult = {
            place: this.currentPlace.name,
            distance: scoreResult.distance,
            points: scoreResult.points,
            timeBonus: timeBonus,
            totalPoints: totalPoints,
            timeTaken: timeTaken
        };

        this.roundHistory.push(roundResult);

        return {
            ...roundResult,
            score: this.totalScore,
            feedback: scoreResult.feedback,
            message: scoreResult.message,
            emoji: scoreResult.emoji
        };
    }

    /**
     * Check if game is complete
     * @returns {boolean} True if all rounds are complete
     */
    isGameComplete() {
        return this.currentRound >= this.settings.rounds;
    }

    /**
     * Get final game results
     * @returns {Object} Final results
     */
    getFinalResults() {
        const maxPossibleScore = this.settings.rounds * 10;

        return {
            totalScore: this.totalScore,
            totalBonus: this.totalBonus,
            maxPossibleScore: maxPossibleScore,
            percentage: (this.totalScore / maxPossibleScore) * 100,
            roundHistory: this.roundHistory,
            settings: this.settings
        };
    }

    /**
     * Get current game status for saving/loading
     * @returns {Object} Serializable game state
     */
    serialize() {
        return {
            settings: this.settings,
            currentRound: this.currentRound,
            totalScore: this.totalScore,
            totalBonus: this.totalBonus,
            roundHistory: this.roundHistory
        };
    }

    /**
     * Restore game state from serialized data
     * @param {Object} data - Serialized state data
     */
    deserialize(data) {
        this.settings = data.settings || this.settings;
        this.currentRound = data.currentRound || 0;
        this.totalScore = data.totalScore || 0;
        this.totalBonus = data.totalBonus || 0;
        this.roundHistory = data.roundHistory || [];
    }
}
