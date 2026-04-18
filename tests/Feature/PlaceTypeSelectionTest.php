<?php

use App\Enums\Difficulty;
use App\Enums\PlaceType;
use App\Livewire\Game;
use App\Models\Place;
use App\Services\PlaceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed test data
    $this->artisan('db:seed', ['--class' => 'PlacesSeeder']);
});

test('it can fetch only capitals', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Medium, ['capital']);

    expect($places->count())->toBeGreaterThan(0, 'Should find capital cities');

    // Verify all returned places are capitals
    foreach ($places as $place) {
        expect($place->type)->toBe('capital', "Place '{$place->name}' should have type 'capital'");
    }
});

test('it stores capitals with correct type in database', function () {
    // Check that capitals are stored with type 'capital', not 'city'
    $capitals = Place::where('type', 'capital')->get();

    expect($capitals->count())->toBeGreaterThan(0, 'Database should contain capitals with type "capital"');

    // Verify no cities have the capital flag
    $citiesMarkedAsCapitals = Place::where('type', 'city')
        ->where('capital', true)
        ->count();

    expect($citiesMarkedAsCapitals)->toBe(0, 'Cities should not have capital flag when type is "capital"');
});

test('it can start game with only capitals selected', function () {
    $placeService = app(PlaceService::class);

    // Verify we have enough capitals for a game
    $capitals = $placeService->getPlaces(Difficulty::Easy, ['capital']);

    expect($capitals->count())->toBeGreaterThanOrEqual(5, 'Should have at least 5 capitals for easy difficulty');
});

test('all place types are stored in lowercase', function () {
    $places = Place::all();

    foreach ($places as $place) {
        expect($place->type)->toBe(
            strtolower($place->type),
            "Place type '{$place->type}' for '{$place->name}' should be lowercase"
        );
    }
});

test('it can fetch mixed types including capitals', function () {
    $placeService = app(PlaceService::class);

    // Fetch with multiple types including capitals
    $places = $placeService->getPlaces(Difficulty::Medium, ['capital', 'city', 'country']);

    expect($places->count())->toBeGreaterThan(0);

    // Verify we have all three types
    $types = $places->pluck('type')->unique()->values()->all();

    expect($types)->toContain('capital');
    expect($types)->toContain('city');
    expect($types)->toContain('country');
});

test('it can fetch only european countries', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Medium, ['country_europe']);

    expect($places->count())->toBeGreaterThan(0, 'Should find European countries');

    $european = \App\Enums\PlaceType::europeanCountries();

    foreach ($places as $place) {
        expect($place->type)->toBe('country');
        expect(in_array($place->name, $european, true))
            ->toBeTrue("'{$place->name}' should be a European country");
    }
});

test('it can fetch only european cities', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Medium, ['city_europe']);

    expect($places->count())->toBeGreaterThan(0, 'Should find European cities');

    $european = \App\Enums\PlaceType::europeanCountries();

    foreach ($places as $place) {
        expect($place->type)->toBe('city');

        $matched = false;
        foreach ($european as $country) {
            if (str_ends_with($place->name, ', '.$country)) {
                $matched = true;
                break;
            }
        }

        expect($matched)->toBeTrue("'{$place->name}' should belong to a European country");
    }
});

test('it can fetch only european capitals', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Easy, ['capital_europe']);

    expect($places->count())->toBeGreaterThan(0, 'Should find European capitals');

    $european = \App\Enums\PlaceType::europeanCountries();

    foreach ($places as $place) {
        expect($place->type)->toBe('capital');

        $matched = false;
        foreach ($european as $country) {
            if (str_ends_with($place->name, ', '.$country)) {
                $matched = true;
                break;
            }
        }

        expect($matched)->toBeTrue("'{$place->name}' should belong to a European country");
    }
});

test('european capital filter excludes non-european capitals', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Easy, ['capital_europe']);

    $names = $places->pluck('name')->all();

    expect($names)->not->toContain('Tokyo, Japan');
    expect($names)->not->toContain('Washington D.C., USA');
});

test('european city filter excludes capitals', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Easy, ['city_europe']);

    foreach ($places as $place) {
        expect($place->type)->not->toBe('capital');
    }
});

test('starting a game in europe region with mixed type yields only european places', function () {
    $european = PlaceType::europeanCountries();

    Livewire::test(Game::class)
        ->call('setRegion', 'europe')
        ->set('difficulty', Difficulty::Easy->value)
        ->set('rounds', 5)
        ->call('startGame')
        ->assertSet('screen', 'game');

    $places = session('game_places');

    expect($places)->toBeArray()->not->toBeEmpty();

    foreach ($places as $place) {
        $isCountry = in_array($place['name'], $european, true);

        $isCityOrCapital = false;
        foreach ($european as $country) {
            if (str_ends_with($place['name'], ', '.$country)) {
                $isCityOrCapital = true;
                break;
            }
        }

        expect($isCountry || $isCityOrCapital)->toBeTrue(
            "'{$place['name']}' should be a European place"
        );
    }
});

test('starting a game in europe region with country type yields only european countries', function () {
    $european = PlaceType::europeanCountries();

    Livewire::test(Game::class)
        ->call('setRegion', 'europe')
        ->call('toggleGameType', PlaceType::Country->value)
        ->set('difficulty', Difficulty::Medium->value)
        ->set('rounds', 5)
        ->call('startGame')
        ->assertSet('screen', 'game');

    $places = session('game_places');

    foreach ($places as $place) {
        expect($place['type'])->toBe('country');
        expect(in_array($place['name'], $european, true))->toBeTrue();
    }
});

test('european country filter excludes non-european countries', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Medium, ['country_europe']);

    $names = $places->pluck('name')->all();

    expect($names)->not->toContain('Japan');
    expect($names)->not->toContain('Brasilien');
    expect($names)->not->toContain('USA');
});

test('it can combine european filter with regular types', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Easy, ['country_europe', 'island']);

    expect($places->count())->toBeGreaterThan(0);

    $types = $places->pluck('type')->unique()->values()->all();

    expect($types)->toContain('country');
    expect($types)->toContain('island');
});

test('mixed selection does not include europe types', function () {
    $placeService = app(PlaceService::class);

    $places = $placeService->getPlaces(Difficulty::Easy, ['mixed']);

    $types = $places->pluck('type')->unique()->values()->all();

    expect($types)->not->toContain('city_europe');
    expect($types)->not->toContain('country_europe');
});
