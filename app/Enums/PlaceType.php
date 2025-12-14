<?php

namespace App\Enums;

enum PlaceType: string
{
    case Mixed = 'mixed';
    case Location = 'location';
    case Island = 'island';
    case City = 'city';
    case Capital = 'capital';
    case Country = 'country';
    case WineRegion = 'wine_region';
    case DOCG = 'docg';
    case AOC = 'aoc';

    public function label(): string
    {
        return match ($this) {
            self::Mixed => 'Blandat',
            self::Location => 'Platser',
            self::Island => 'Öar',
            self::City => 'Städer',
            self::Capital => 'Huvudstäder',
            self::Country => 'Länder',
            self::WineRegion => 'Vinregioner',
            self::DOCG => 'DOCG',
            self::AOC => 'AOC',
        };
    }

    public static function regularTypes(): array
    {
        return [
            self::Country,
            self::Capital,
            self::City,
            self::Location,
            self::Island,
        ];
    }

    public static function regularTypesValues(): array
    {
        return array_map(fn ($type) => $type->value, self::regularTypes());
    }

    public static function wineTypes(): array
    {
        return [
            self::WineRegion,
            self::DOCG,
            self::AOC,
        ];
    }
}
