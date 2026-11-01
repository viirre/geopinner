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
    case CityEurope = 'city_europe';
    case CapitalEurope = 'capital_europe';
    case CountryEurope = 'country_europe';
    case WineRegion = 'wine_region';
    case DOCG = 'docg';
    case AOC = 'aoc';
    case SwedishProvince = 'swedish_province';

    public function label(): string
    {
        return match ($this) {
            self::Mixed => 'Blandat',
            self::Location => 'Platser',
            self::Island => 'Öar',
            self::City => 'Städer',
            self::Capital => 'Huvudstäder',
            self::Country => 'Länder',
            self::CityEurope => 'Städer i Europa',
            self::CapitalEurope => 'Huvudstäder i Europa',
            self::CountryEurope => 'Länder i Europa',
            self::WineRegion => 'Vinregioner',
            self::DOCG => 'DOCG',
            self::AOC => 'AOC',
            self::SwedishProvince => 'Landskap',
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

    public static function europeTypes(): array
    {
        return [
            self::CountryEurope,
            self::CapitalEurope,
            self::CityEurope,
        ];
    }

    public static function wineTypes(): array
    {
        return [
            self::WineRegion,
            self::DOCG,
            self::AOC,
        ];
    }

    /**
     * Guess distances are multiplied by this before scoring, so 2 halves every threshold.
     * Types whose places lie close together need a higher factor to separate right from wrong.
     * Swedish provinces are scored on the distance to their border, which is short, hence 8.
     */
    public function scoringDifficultyFactor(): int
    {
        return match (true) {
            $this === self::SwedishProvince => 8,
            in_array($this, self::wineTypes(), true) => 2,
            default => 1,
        };
    }

    /**
     * @return array<int, string> Swedish names of European countries used to filter Europe-restricted modes.
     */
    public static function europeanCountries(): array
    {
        return [
            'Albanien',
            'Andorra',
            'Belgien',
            'Bosnien och Hercegovina',
            'Bulgarien',
            'Cypern',
            'Danmark',
            'Estland',
            'Finland',
            'Frankrike',
            'Grekland',
            'Irland',
            'Island',
            'Italien',
            'Kosovo',
            'Kroatien',
            'Lettland',
            'Liechtenstein',
            'Litauen',
            'Luxemburg',
            'Malta',
            'Moldavien',
            'Monaco',
            'Montenegro',
            'Nederländerna',
            'Nordmakedonien',
            'Norge',
            'Polen',
            'Portugal',
            'Rumänien',
            'Ryssland',
            'San Marino',
            'Schweiz',
            'Serbien',
            'Slovakien',
            'Slovenien',
            'Spanien',
            'Storbritannien',
            'Sverige',
            'Tjeckien',
            'Turkiet',
            'Tyskland',
            'Ukraina',
            'Ungern',
            'Vatikanstaten',
            'Vitryssland',
            'Österrike',
        ];
    }
}
