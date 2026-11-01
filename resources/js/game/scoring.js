/**
 * Scoring module for Geopinner
 * Handles distance-based scoring, scaled per place type so close-together places (wine regions, Swedish provinces) are harder
 */

// Scoring thresholds for standard places (cities, countries, etc.)
const STANDARD_THRESHOLDS = [
    { max: 50, points: 10, emoji: '🎯', text: 'Perfekt!', class: 'excellent' },
    { max: 200, points: 9, emoji: '⭐', text: 'Fantastiskt!', class: 'excellent' },
    { max: 400, points: 8, emoji: '🌟', text: 'Jättebra!', class: 'excellent' },
    { max: 700, points: 7, emoji: '👏', text: 'Riktigt bra!', class: 'good' },
    { max: 1100, points: 6, emoji: '👍', text: 'Bra!', class: 'good' },
    { max: 1600, points: 5, emoji: '😊', text: 'Helt okej!', class: 'okay' },
    { max: 2200, points: 4, emoji: '🙂', text: 'Inte så illa!', class: 'okay' },
    { max: 3000, points: 3, emoji: '🤔', text: 'Fortsätt öva!', class: 'okay' },
    { max: 4500, points: 2, emoji: '💪', text: 'Det var långt!', class: 'poor' },
    { max: Infinity, points: 1, emoji: '🌍', text: 'Wow, det var riktigt långt!', class: 'poor' }
];

// Guess distances are multiplied by this before scoring, so 2 halves every threshold.
// Must match PlaceType::scoringDifficultyFactor() in PHP.
const DIFFICULTY_FACTORS = {
    wine_region: 2,
    docg: 2,
    aoc: 2,
    swedish_province: 8,
};

// A guess outside the place's outline can never score better than this.
// Must match ScoringService::MAX_POINTS_OUTSIDE_BORDER in PHP.
const MAX_POINTS_OUTSIDE_BORDER = 7;

/**
 * Calculate score based on distance to target
 * @param {number} kmDistance - Distance in kilometers
 * @param {Object} place - Place object with type and size
 * @param {number|null} kmOutsideBorder - How far outside the place's outline the guess is (0 inside), or null without an outline
 * @returns {Object} Scoring result with points, feedback, message, and class
 */
export function calculateScore(kmDistance, place, kmOutsideBorder = null) {
    const difficultyFactor = DIFFICULTY_FACTORS[place.type] ?? 1;
    const isOutsideBorder = kmOutsideBorder > 0;

    // Distance outside the place (its border, or else its radius), scaled for harder place types
    const adjustedDistance = (kmOutsideBorder ?? Math.max(0, kmDistance - place.size)) * difficultyFactor;

    // Find matching threshold
    for (const threshold of STANDARD_THRESHOLDS) {
        if (isOutsideBorder && threshold.points > MAX_POINTS_OUTSIDE_BORDER) {
            continue;
        }

        if (adjustedDistance < threshold.max) {
            if (isOutsideBorder) {
                const milOutside = (kmOutsideBorder / 10).toFixed(1);

                return {
                    points: threshold.points,
                    feedback: threshold.class,
                    emoji: '❌',
                    message: `❌ Fel landskap! Du var ${milOutside} mil från gränsen.`,
                    distance: milOutside
                };
            }

            // Convert to Swedish miles (1 mil = 10 km)
            const milDistance = (kmDistance / 10).toFixed(1);
            const result = kmOutsideBorder === null ? `Du var ${milDistance} mil bort!` : 'Rätt landskap!';

            return {
                points: threshold.points,
                feedback: threshold.class,
                emoji: threshold.emoji,
                message: `${threshold.emoji} ${threshold.text} ${result}`,
                distance: milDistance
            };
        }
    }

    // Fallback (should never reach here due to Infinity threshold)
    const milDistance = (kmDistance / 10).toFixed(1);
    return {
        points: 1,
        feedback: 'poor',
        emoji: '🌍',
        message: `🌍 Wow, det var riktigt långt! Du var ${milDistance} mil bort!`,
        distance: milDistance
    };
}

/**
 * Calculate final score message based on percentage
 * @param {number} totalScore - Total points earned
 * @param {number} maxScore - Maximum possible points
 * @returns {string} Congratulatory message
 */
export function getFinalMessage(totalScore, maxScore) {
    const percentage = (totalScore / maxScore) * 100;

    if (percentage >= 90) {
        return '🏆 Fantastiskt! Du är en geografigenius!';
    } else if (percentage >= 75) {
        return '⭐ Excellent! Mycket bra jobbat!';
    } else if (percentage >= 60) {
        return '👍 Bra jobbat! Fortsätt öva!';
    } else if (percentage >= 40) {
        return '😊 Inte dåligt! Du lär dig mer och mer!';
    } else {
        return '💪 Bra försök! Prova igen så blir det bättre!';
    }
}
