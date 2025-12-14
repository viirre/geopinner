<?php

namespace App\Services;

use App\Enums\Difficulty;
use App\Enums\PlaceType;
use App\Models\Place;
use Illuminate\Support\Collection;

class PlaceService
{
    /**
     * Fetch places based on difficulty and game types
     */
    public function getPlaces(string|Difficulty $difficulty, array $gameTypes): Collection
    {
        // Convert string to enum if needed
        if (is_string($difficulty)) {
            $difficulty = Difficulty::from($difficulty);
        }

        // Build query based on difficulty
        $query = Place::query()->difficulty($difficulty);

        // Filter by game types
        // If 'mixed' is selected, include all regular types
        if (in_array(PlaceType::Mixed->value, $gameTypes)) {
            $gameTypes = PlaceType::regularTypesValues();
        }

        $query->types($gameTypes);

        // Return collection with necessary fields
        return $query->get(['name', 'lat', 'lng', 'type', 'size']);
    }

    /**
     * Check if there are enough places for the requested rounds
     */
    public function hasEnoughPlaces(string|Difficulty $difficulty, array $gameTypes, int $requiredCount): bool
    {
        $places = $this->getPlaces($difficulty, $gameTypes);

        return $places->count() >= $requiredCount;
    }

    /**
     * Get place count for given criteria
     */
    public function getPlaceCount(string|Difficulty $difficulty, array $gameTypes): int
    {
        return $this->getPlaces($difficulty, $gameTypes)->count();
    }
}
