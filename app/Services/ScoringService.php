<?php

namespace App\Services;

class ScoringService
{
    private const STANDARD_THRESHOLDS = [
        50 => ['points' => 10, 'emoji' => '🎯', 'text' => 'Perfekt!', 'class' => 'excellent'],
        200 => ['points' => 9, 'emoji' => '⭐', 'text' => 'Fantastiskt!', 'class' => 'excellent'],
        400 => ['points' => 8, 'emoji' => '🌟', 'text' => 'Jättebra!', 'class' => 'excellent'],
        700 => ['points' => 7, 'emoji' => '👏', 'text' => 'Riktigt bra!', 'class' => 'good'],
        1100 => ['points' => 6, 'emoji' => '👍', 'text' => 'Bra!', 'class' => 'good'],
        1600 => ['points' => 5, 'emoji' => '😊', 'text' => 'Helt okej!', 'class' => 'okay'],
        2200 => ['points' => 4, 'emoji' => '🙂', 'text' => 'Inte så illa!', 'class' => 'okay'],
        3000 => ['points' => 3, 'emoji' => '🤔', 'text' => 'Fortsätt öva!', 'class' => 'okay'],
        4500 => ['points' => 2, 'emoji' => '💪', 'text' => 'Det var långt!', 'class' => 'poor'],
        PHP_FLOAT_MAX => ['points' => 1, 'emoji' => '🌍', 'text' => 'Wow, det var riktigt långt!', 'class' => 'poor'],
    ];

    private const WINE_THRESHOLDS = [
        25 => ['points' => 10, 'emoji' => '🎯', 'text' => 'Perfekt!', 'class' => 'excellent'],
        100 => ['points' => 9, 'emoji' => '⭐', 'text' => 'Fantastiskt!', 'class' => 'excellent'],
        200 => ['points' => 8, 'emoji' => '🌟', 'text' => 'Jättebra!', 'class' => 'excellent'],
        350 => ['points' => 7, 'emoji' => '👏', 'text' => 'Riktigt bra!', 'class' => 'good'],
        550 => ['points' => 6, 'emoji' => '👍', 'text' => 'Bra!', 'class' => 'good'],
        800 => ['points' => 5, 'emoji' => '😊', 'text' => 'Helt okej!', 'class' => 'okay'],
        1100 => ['points' => 4, 'emoji' => '🙂', 'text' => 'Inte så illa!', 'class' => 'okay'],
        1500 => ['points' => 3, 'emoji' => '🤔', 'text' => 'Fortsätt öva!', 'class' => 'okay'],
        2250 => ['points' => 2, 'emoji' => '💪', 'text' => 'Det var långt!', 'class' => 'poor'],
        PHP_FLOAT_MAX => ['points' => 1, 'emoji' => '🌍', 'text' => 'Wow, det var riktigt långt!', 'class' => 'poor'],
    ];

    public function calculateScore(float $kmDistance, array $place): array
    {
        // Adjust for place size (radius)
        $adjustedDistance = max(0, $kmDistance - $place['size']);

        // Wine regions use stricter thresholds (2x harder)
        $isWineRegion = in_array($place['type'], ['vin', 'docg', 'aoc']);
        $thresholds = $isWineRegion ? self::WINE_THRESHOLDS : self::STANDARD_THRESHOLDS;

        foreach ($thresholds as $maxDistance => $threshold) {
            if ($adjustedDistance < $maxDistance) {
                // Convert to Swedish miles (1 mil = 10 km)
                $milDistance = number_format($kmDistance / 10, 1);

                return [
                    'points' => $threshold['points'],
                    'feedback' => $threshold['class'],
                    'emoji' => $threshold['emoji'],
                    'message' => "{$threshold['emoji']} {$threshold['text']} Du var {$milDistance} mil bort!",
                    'distance' => $milDistance,
                ];
            }
        }

        // Fallback (should never reach due to PHP_FLOAT_MAX threshold)
        return [
            'points' => 1,
            'feedback' => 'poor',
            'emoji' => '🌍',
            'message' => 'Långt bort!',
            'distance' => '∞',
        ];
    }
}
