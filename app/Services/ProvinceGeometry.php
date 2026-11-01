<?php

namespace App\Services;

use App\Enums\PlaceType;

/**
 * Point checks against the Swedish province outlines that the map draws, so a
 * guess in a neighbouring province can be told apart from one in the right one.
 * Mirrors resources/js/map/provinceGeometry.js.
 */
class ProvinceGeometry
{
    /** Outlines are simplified, so guesses this close to the border count as inside. */
    private const BORDER_TOLERANCE_KM = 3;

    private const KM_PER_DEGREE_LAT = 110.574;

    private const KM_PER_DEGREE_LNG_AT_EQUATOR = 111.32;

    /**
     * Distance in km from the guess to the place's border, 0 when the guess is
     * inside, or null when the place is not a province with an outline.
     *
     * @param  array{name: string, type: string}  $place
     */
    public function kmOutsideBorder(array $place, float $lat, float $lng): ?float
    {
        if ($place['type'] !== PlaceType::SwedishProvince->value) {
            return null;
        }

        $polygons = $this->polygons()[$place['name']] ?? null;

        if ($polygons === null) {
            return null;
        }

        if ($this->contains($polygons, $lat, $lng)) {
            return 0.0;
        }

        $distance = $this->distanceToEdgesKm($polygons, $lat, $lng);

        return $distance <= self::BORDER_TOLERANCE_KM ? 0.0 : $distance;
    }

    /**
     * @param  array<int, array<int, array<int, array{0: float, 1: float}>>>  $polygons
     */
    private function contains(array $polygons, float $lat, float $lng): bool
    {
        foreach ($polygons as $rings) {
            $inside = false;

            foreach ($rings as $ring) {
                $count = count($ring);

                for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
                    [$xi, $yi] = $ring[$i];
                    [$xj, $yj] = $ring[$j];

                    if (($yi > $lat) !== ($yj > $lat) && $lng < ($xj - $xi) * ($lat - $yi) / ($yj - $yi) + $xi) {
                        $inside = ! $inside;
                    }
                }
            }

            if ($inside) {
                return true;
            }
        }

        return false;
    }

    /**
     * Shortest distance to any edge, in a flat projection centred on the guess.
     *
     * @param  array<int, array<int, array<int, array{0: float, 1: float}>>>  $polygons
     */
    private function distanceToEdgesKm(array $polygons, float $lat, float $lng): float
    {
        $kmPerDegreeLng = self::KM_PER_DEGREE_LNG_AT_EQUATOR * cos(deg2rad($lat));
        $shortest = PHP_FLOAT_MAX;

        foreach ($polygons as $rings) {
            foreach ($rings as $ring) {
                $count = count($ring);

                for ($i = 1; $i < $count; $i++) {
                    $ax = ($ring[$i - 1][0] - $lng) * $kmPerDegreeLng;
                    $ay = ($ring[$i - 1][1] - $lat) * self::KM_PER_DEGREE_LAT;
                    $bx = ($ring[$i][0] - $lng) * $kmPerDegreeLng;
                    $by = ($ring[$i][1] - $lat) * self::KM_PER_DEGREE_LAT;

                    $shortest = min($shortest, $this->distanceFromOriginToSegment($ax, $ay, $bx, $by));
                }
            }
        }

        return $shortest;
    }

    private function distanceFromOriginToSegment(float $ax, float $ay, float $bx, float $by): float
    {
        $dx = $bx - $ax;
        $dy = $by - $ay;
        $lengthSquared = $dx * $dx + $dy * $dy;

        $t = $lengthSquared > 0 ? max(0, min(1, -($ax * $dx + $ay * $dy) / $lengthSquared)) : 0;

        return hypot($ax + $t * $dx, $ay + $t * $dy);
    }

    /**
     * Outline polygons per province name, read once per request.
     *
     * @return array<string, array<int, array<int, array<int, array{0: float, 1: float}>>>>
     */
    private function polygons(): array
    {
        return once(function (): array {
            $outlines = json_decode(file_get_contents(resource_path('js/map/swedishProvinces.json')), true);

            return collect($outlines['features'])
                ->mapWithKeys(fn (array $feature) => [
                    $feature['properties']['name'] => $feature['geometry']['type'] === 'Polygon'
                        ? [$feature['geometry']['coordinates']]
                        : $feature['geometry']['coordinates'],
                ])
                ->all();
        });
    }
}
