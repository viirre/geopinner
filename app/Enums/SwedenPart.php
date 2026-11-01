<?php

namespace App\Enums;

/**
 * Part of Sweden (landsdel) to play in the Swedish province mode. A specific part
 * plays every province in it once, regardless of difficulty and round setting.
 */
enum SwedenPart: string
{
    case All = 'all';
    case Norrland = 'norrland';
    case Svealand = 'svealand';
    case Gotaland = 'gotaland';

    public function label(): string
    {
        return match ($this) {
            self::All => 'Hela Sverige',
            self::Norrland => 'Norrland',
            self::Svealand => 'Svealand',
            self::Gotaland => 'Götaland',
        };
    }

    public function playsEveryProvinceOnce(): bool
    {
        return $this !== self::All;
    }

    /**
     * @return array<int, string>
     */
    public function provinceNames(): array
    {
        return match ($this) {
            self::All => array_merge(
                self::Norrland->provinceNames(),
                self::Svealand->provinceNames(),
                self::Gotaland->provinceNames(),
            ),
            self::Norrland => [
                'Gästrikland', 'Hälsingland', 'Härjedalen', 'Jämtland', 'Medelpad',
                'Ångermanland', 'Västerbotten', 'Norrbotten', 'Lappland',
            ],
            self::Svealand => [
                'Uppland', 'Södermanland', 'Västmanland', 'Närke', 'Värmland', 'Dalarna',
            ],
            self::Gotaland => [
                'Skåne', 'Blekinge', 'Halland', 'Småland', 'Öland', 'Gotland',
                'Östergötland', 'Västergötland', 'Bohuslän', 'Dalsland',
            ],
        };
    }
}
