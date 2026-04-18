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
    case CountryEurope = 'country_europe';
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
            self::CityEurope => 'Städer i Europa',
            self::CountryEurope => 'Länder i Europa',
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

    public static function europeTypes(): array
    {
        return [
            self::CityEurope,
            self::CountryEurope,
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
