<?php

namespace App\Services;

use App\Enums\PlaceType;

class ScoringService
{
    private const THRESHOLDS = [
        50 => ['points' => 10, 'emoji' => '🎯', 'text' => 'Perfekt!', 'class' => 'excellent'],
        200 => ['points' => 9, 'emoji' => '⭐', 'text' => 'Fantastiskt!', 'class' => 'excellent'],
        400 => ['points' => 8, 'emoji' => '🌟', 'text' => 'Jättebra!', 'class' => 'excellent'],
        700 => ['points' => 7, 'emoji' => '👏', 'text' => 'Riktigt bra!', 'class' => 'good'],
        1100 => ['points' => 6, 'emoji' => '👍', 'text' => 'Bra!', 'class' => 'good'],
        1600 => ['points' => 5, 'emoji' => '😊', 'text' => 'Helt okej!', 'class' => 'okay'],
        2200 => ['points' => 4, 'emoji' => '🙂', 'text' => 'Inte så illa!', 'class' => 'okay'],
        3000 => ['points' => 3, 'emoji' => '🤔', 'text' => 'Fortsätt öva!', 'class' => 'okay'],
        4500 => ['points' => 2, 'emoji' => '💪', 'text' => 'Det var långt!', 'class' => 'poor'],
        PHP_INT_MAX => ['points' => 1, 'emoji' => '🌍', 'text' => 'Wow, det var riktigt långt!', 'class' => 'poor'],
    ];

    /** A guess outside the place's outline can never score better than this. */
    private const MAX_POINTS_OUTSIDE_BORDER = 7;

    /**
     * Score a guess. When the place has an outline, pass how far outside its border
     * the guess landed (0 when inside); otherwise the place radius is used.
     */
    public function calculateScore(float $kmDistance, array $place, ?float $kmOutsideBorder = null): array
    {
        $difficultyFactor = PlaceType::tryFrom($place['type'] ?? '')?->scoringDifficultyFactor() ?? 1;
        $isOutsideBorder = $kmOutsideBorder > 0;

        // Distance outside the place (its border, or else its radius), scaled for harder place types
        $adjustedDistance = ($kmOutsideBorder ?? max(0, $kmDistance - ($place['size'] ?? 0))) * $difficultyFactor;

        foreach (self::THRESHOLDS as $maxDistance => $threshold) {
            if ($isOutsideBorder && $threshold['points'] > self::MAX_POINTS_OUTSIDE_BORDER) {
                continue;
            }

            if ($adjustedDistance < $maxDistance) {
                if ($isOutsideBorder) {
                    $milOutside = number_format($kmOutsideBorder / 10, 1);

                    return [
                        'points' => $threshold['points'],
                        'feedback' => $threshold['class'],
                        'emoji' => '❌',
                        'message' => "❌ Fel landskap! Du var {$milOutside} mil från gränsen.",
                        'distance' => $milOutside,
                    ];
                }

                // Convert to Swedish miles (1 mil = 10 km)
                $milDistance = number_format($kmDistance / 10, 1);
                $result = $kmOutsideBorder === null
                    ? "Du var {$milDistance} mil bort!"
                    : 'Rätt landskap!';

                return [
                    'points' => $threshold['points'],
                    'feedback' => $threshold['class'],
                    'emoji' => $threshold['emoji'],
                    'message' => "{$threshold['emoji']} {$threshold['text']} {$result}",
                    'distance' => $milDistance,
                ];
            }
        }

        // Fallback (should never reach due to PHP_INT_MAX threshold)
        return [
            'points' => 1,
            'feedback' => 'poor',
            'emoji' => '🌍',
            'message' => 'Långt bort!',
            'distance' => '∞',
        ];
    }
}
