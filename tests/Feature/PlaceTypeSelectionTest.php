<?php

use App\Enums\Difficulty;
use App\Models\Place;
use App\Services\PlaceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
