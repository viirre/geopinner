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
        if (is_string($difficulty)) {
            $difficulty = Difficulty::from($difficulty);
        }

        if (in_array(PlaceType::Mixed->value, $gameTypes)) {
            $gameTypes = PlaceType::regularTypesValues();
        }

        $wantsCityEurope = in_array(PlaceType::CityEurope->value, $gameTypes);
        $wantsCapitalEurope = in_array(PlaceType::CapitalEurope->value, $gameTypes);
        $wantsCountryEurope = in_array(PlaceType::CountryEurope->value, $gameTypes);

        $regularTypes = array_values(array_diff($gameTypes, [
            PlaceType::CityEurope->value,
            PlaceType::CapitalEurope->value,
            PlaceType::CountryEurope->value,
        ]));

        $query = Place::query()->difficulty($difficulty);

        $query->where(function ($q) use ($regularTypes, $wantsCityEurope, $wantsCapitalEurope, $wantsCountryEurope) {
            if (! empty($regularTypes)) {
                $q->orWhereIn('type', $regularTypes);
            }

            if ($wantsCityEurope) {
                $q->orWhere(fn ($inner) => $inner
                    ->where('type', PlaceType::City->value)
                    ->where(function ($names) {
                        foreach (PlaceType::europeanCountries() as $country) {
                            $names->orWhere('name', 'like', '%, '.$country);
                        }
                    })
                );
            }

            if ($wantsCapitalEurope) {
                $q->orWhere(fn ($inner) => $inner
                    ->where('type', PlaceType::Capital->value)
                    ->where(function ($names) {
                        foreach (PlaceType::europeanCountries() as $country) {
                            $names->orWhere('name', 'like', '%, '.$country);
                        }
                    })
                );
            }

            if ($wantsCountryEurope) {
                $q->orWhere(fn ($inner) => $inner
                    ->where('type', PlaceType::Country->value)
                    ->whereIn('name', PlaceType::europeanCountries())
                );
            }
        });

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
