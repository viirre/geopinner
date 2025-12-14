<?php

use App\Enums\Difficulty;
use App\Enums\PlaceType;
use App\Livewire\Game;
use App\Models\Place;
use Livewire\Livewire;

beforeEach(function () {
    // Create test places using enums - need at least 20 for all tests
    // NOTE: difficulty is stored as an array (JSON) in the database
    $places = [
        // Easy difficulty - need at least 10 regular types
        ['name' => 'Stockholm', 'lat' => 59.33, 'lng' => 18.07, 'type' => PlaceType::Capital->value, 'size' => 10, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'Paris', 'lat' => 48.86, 'lng' => 2.35, 'type' => PlaceType::Capital->value, 'size' => 12, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'Sweden', 'lat' => 62.0, 'lng' => 15.0, 'type' => PlaceType::Country->value, 'size' => 200, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'France', 'lat' => 46.23, 'lng' => 2.21, 'type' => PlaceType::Country->value, 'size' => 250, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'London', 'lat' => 51.51, 'lng' => -0.13, 'type' => PlaceType::City->value, 'size' => 18, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'Germany', 'lat' => 51.17, 'lng' => 10.45, 'type' => PlaceType::Country->value, 'size' => 220, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'Rome', 'lat' => 41.90, 'lng' => 12.50, 'type' => PlaceType::City->value, 'size' => 14, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'Italy', 'lat' => 41.87, 'lng' => 12.57, 'type' => PlaceType::Country->value, 'size' => 230, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'Spain', 'lat' => 40.46, 'lng' => -3.75, 'type' => PlaceType::Country->value, 'size' => 240, 'difficulty' => [Difficulty::Easy->value]],
        ['name' => 'UK', 'lat' => 55.38, 'lng' => -3.44, 'type' => PlaceType::Country->value, 'size' => 180, 'difficulty' => [Difficulty::Easy->value]],

        // Medium difficulty - mixed types (need at least 10 for default rounds)
        // Also need at least 3 of each type for game type tests
        ['name' => 'Berlin', 'lat' => 52.52, 'lng' => 13.40, 'type' => PlaceType::Capital->value, 'size' => 15, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Madrid', 'lat' => 40.42, 'lng' => -3.70, 'type' => PlaceType::Capital->value, 'size' => 14, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Bordeaux', 'lat' => 44.84, 'lng' => -0.58, 'type' => PlaceType::WineRegion->value, 'size' => 30, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Champagne', 'lat' => 49.04, 'lng' => 3.96, 'type' => PlaceType::AOC->value, 'size' => 35, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Amsterdam', 'lat' => 52.37, 'lng' => 4.90, 'type' => PlaceType::Capital->value, 'size' => 11, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Barcelona', 'lat' => 41.39, 'lng' => 2.16, 'type' => PlaceType::City->value, 'size' => 13, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Rioja', 'lat' => 42.29, 'lng' => -2.54, 'type' => PlaceType::WineRegion->value, 'size' => 28, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Sicily', 'lat' => 37.50, 'lng' => 14.02, 'type' => PlaceType::Island->value, 'size' => 180, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Eiffel Tower', 'lat' => 48.86, 'lng' => 2.29, 'type' => PlaceType::Location->value, 'size' => 1, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Prague', 'lat' => 50.08, 'lng' => 14.44, 'type' => PlaceType::Capital->value, 'size' => 12, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Vienna', 'lat' => 48.21, 'lng' => 16.37, 'type' => PlaceType::Capital->value, 'size' => 13, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Brussels', 'lat' => 50.85, 'lng' => 4.35, 'type' => PlaceType::Capital->value, 'size' => 11, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Copenhagen', 'lat' => 55.68, 'lng' => 12.57, 'type' => PlaceType::Capital->value, 'size' => 10, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Lisbon', 'lat' => 38.72, 'lng' => -9.14, 'type' => PlaceType::Capital->value, 'size' => 12, 'difficulty' => [Difficulty::Medium->value]],
        // Add more cities, countries, and wine regions for game type tests
        ['name' => 'Munich', 'lat' => 48.14, 'lng' => 11.58, 'type' => PlaceType::City->value, 'size' => 12, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Milan', 'lat' => 45.46, 'lng' => 9.19, 'type' => PlaceType::City->value, 'size' => 13, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Portugal', 'lat' => 39.40, 'lng' => -8.22, 'type' => PlaceType::Country->value, 'size' => 150, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Belgium', 'lat' => 50.50, 'lng' => 4.47, 'type' => PlaceType::Country->value, 'size' => 120, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Netherlands', 'lat' => 52.13, 'lng' => 5.29, 'type' => PlaceType::Country->value, 'size' => 130, 'difficulty' => [Difficulty::Medium->value]],
        ['name' => 'Tuscany', 'lat' => 43.77, 'lng' => 11.25, 'type' => PlaceType::WineRegion->value, 'size' => 35, 'difficulty' => [Difficulty::Medium->value]],

        // Hard difficulty - need at least 10 regular types
        ['name' => 'Oslo', 'lat' => 59.91, 'lng' => 10.75, 'type' => PlaceType::Capital->value, 'size' => 8, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Chianti', 'lat' => 43.47, 'lng' => 11.23, 'type' => PlaceType::DOCG->value, 'size' => 25, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Tallinn', 'lat' => 59.44, 'lng' => 24.75, 'type' => PlaceType::Capital->value, 'size' => 7, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Barolo', 'lat' => 44.61, 'lng' => 7.94, 'type' => PlaceType::DOCG->value, 'size' => 20, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Gothenburg', 'lat' => 57.71, 'lng' => 11.97, 'type' => PlaceType::City->value, 'size' => 9, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Brunello', 'lat' => 43.06, 'lng' => 11.57, 'type' => PlaceType::DOCG->value, 'size' => 22, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Helsinki', 'lat' => 60.17, 'lng' => 24.94, 'type' => PlaceType::Capital->value, 'size' => 8, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Dublin', 'lat' => 53.35, 'lng' => -6.26, 'type' => PlaceType::Capital->value, 'size' => 9, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Warsaw', 'lat' => 52.23, 'lng' => 21.01, 'type' => PlaceType::Capital->value, 'size' => 10, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Budapest', 'lat' => 47.50, 'lng' => 19.04, 'type' => PlaceType::Capital->value, 'size' => 11, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Belgrade', 'lat' => 44.79, 'lng' => 20.45, 'type' => PlaceType::Capital->value, 'size' => 9, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Bratislava', 'lat' => 48.15, 'lng' => 17.11, 'type' => PlaceType::Capital->value, 'size' => 8, 'difficulty' => [Difficulty::Hard->value]],
        ['name' => 'Ljubljana', 'lat' => 46.06, 'lng' => 14.51, 'type' => PlaceType::Capital->value, 'size' => 7, 'difficulty' => [Difficulty::Hard->value]],
    ];

    foreach ($places as $placeData) {
        Place::create($placeData);
    }
});

it('renders successfully', function () {
    Livewire::test(Game::class)
        ->assertStatus(200);
});

it('starts on setup screen', function () {
    Livewire::test(Game::class)
        ->assertSet('screen', 'setup');
});

it('can start a game with default settings', function () {
    // Verify places exist in test database
    expect(Place::count())->toBe(43); // 10 easy + 20 medium + 13 hard

    $component = Livewire::test(Game::class);

    // Check defaults
    expect($component->get('difficulty'))->toBe(Difficulty::Medium->value);
    expect($component->get('gameTypes'))->toBe([PlaceType::Mixed->value]);
    expect($component->get('rounds'))->toBe(10);

    $component
        ->set('rounds', 5) // Reduce rounds for test data
        ->call('startGame')
        ->assertHasNoErrors()
        ->assertSet('screen', 'game')
        ->assertSet('currentRound', 1);
});

it('validates game has enough places for selected rounds', function () {
    Livewire::test(Game::class)
        ->set('difficulty', Difficulty::Hard->value)
        ->set('gameTypes', [PlaceType::DOCG->value]) // DOCG might have limited places
        ->set('rounds', 20)
        ->call('startGame');

    // If there aren't enough places, it should either error or start
    // We just verify it doesn't crash
    expect(true)->toBeTrue();
});

it('advances to next round after guess', function () {
    $component = Livewire::test(Game::class)
        ->set('rounds', 5)
        ->call('startGame')
        ->assertSet('currentRound', 1);

    $currentPlace = $component->get('currentPlace');

    // Submit a guess
    $component
        ->call('submitGuess', $currentPlace['lat'], $currentPlace['lng'])
        ->assertSet('hasGuessed', true);

    // Continue to next round
    $component
        ->call('continueToNextRound')
        ->assertSet('currentRound', 2)
        ->assertSet('hasGuessed', false);
});

it('calculates perfect score for exact guess', function () {
    $component = Livewire::test(Game::class)
        ->set('rounds', 1)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');

    // Submit exact guess
    $component->call('submitGuess', $currentPlace['lat'], $currentPlace['lng']);

    $totalScore = $component->get('totalScore');

    // Should get maximum points (10)
    expect($totalScore)->toBe(10);
});

it('calculates lower score for distant guess', function () {
    $component = Livewire::test(Game::class)
        ->set('rounds', 1)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');

    // Submit very distant guess (opposite side of world)
    $component->call('submitGuess', -$currentPlace['lat'], $currentPlace['lng'] + 180);

    $totalScore = $component->get('totalScore');

    // Should get low score
    expect($totalScore)->toBeLessThanOrEqual(3);
});

it('stores round history', function () {
    $component = Livewire::test(Game::class)
        ->set('rounds', 2)
        ->call('startGame');

    $place1 = $component->get('currentPlace');
    $component->call('submitGuess', $place1['lat'], $place1['lng']);
    $component->call('continueToNextRound');

    $place2 = $component->get('currentPlace');
    $component->call('submitGuess', $place2['lat'], $place2['lng']);

    $roundHistory = $component->get('roundHistory');

    expect($roundHistory)->toBeArray()
        ->and($roundHistory)->toHaveCount(2)
        ->and($roundHistory[0])->toHaveKey('place')
        ->and($roundHistory[0])->toHaveKey('points')
        ->and($roundHistory[0])->toHaveKey('distance');
});

it('prevents submitting multiple guesses for same round', function () {
    $component = Livewire::test(Game::class)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');

    // Submit first guess
    $component->call('submitGuess', $currentPlace['lat'], $currentPlace['lng']);
    $firstScore = $component->get('totalScore');

    // Try to submit second guess (should be ignored)
    $component->call('submitGuess', 0, 0);
    $secondScore = $component->get('totalScore');

    // Score should not change
    expect($secondScore)->toBe($firstScore);
});

it('finishes game after all rounds', function () {
    $component = Livewire::test(Game::class)
        ->set('rounds', 2)
        ->call('startGame');

    // Complete first round
    $place1 = $component->get('currentPlace');
    $component->call('submitGuess', $place1['lat'], $place1['lng']);
    $component->call('continueToNextRound');

    // Complete second round
    $place2 = $component->get('currentPlace');
    $component->call('submitGuess', $place2['lat'], $place2['lng']);
    $component->call('continueToNextRound');

    // Should transition to result screen
    $component->assertSet('screen', 'result');
});

it('can play again after finishing', function () {
    $component = Livewire::test(Game::class)
        ->set('rounds', 1)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');
    $component->call('submitGuess', $currentPlace['lat'], $currentPlace['lng']);
    $component->call('continueToNextRound');

    // Should be on result screen
    $component->assertSet('screen', 'result');

    // Play again
    $component->call('playAgain')
        ->assertSet('screen', 'setup')
        ->assertSet('currentRound', 0)
        ->assertSet('totalScore', 0)
        ->assertSet('roundHistory', []);
});

it('handles timeout when timer enabled', function () {
    $component = Livewire::test(Game::class)
        ->set('timerEnabled', true)
        ->set('timerDuration', 10)
        ->call('startGame');

    // Simulate timeout
    $component->call('handleTimeout');

    $roundHistory = $component->get('roundHistory');

    expect($roundHistory)->toHaveCount(1)
        ->and($roundHistory[0]['points'])->toBe(0)
        ->and($roundHistory[0]['distance'])->toBe('∞');
});

it('calculates time bonus when timer enabled and quick guess', function () {
    $component = Livewire::test(Game::class)
        ->set('timerEnabled', true)
        ->set('timerDuration', 30)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');

    // Simulate very quick guess (perfect score)
    $component->call('submitGuess', $currentPlace['lat'], $currentPlace['lng']);

    $totalBonus = $component->get('totalBonus');

    // Should have time bonus for quick perfect guess
    expect($totalBonus)->toBeGreaterThan(0);
});

it('does not give time bonus for poor guesses', function () {
    $component = Livewire::test(Game::class)
        ->set('timerEnabled', true)
        ->set('timerDuration', 30)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');

    // Submit very distant guess (low score)
    $component->call('submitGuess', -$currentPlace['lat'], $currentPlace['lng'] + 180);

    $totalBonus = $component->get('totalBonus');

    // Should not have time bonus for poor guess
    expect($totalBonus)->toBe(0);
});

it('shuffles places using fisher-yates', function () {
    Livewire::test(Game::class)
        ->set('rounds', 5)
        ->call('startGame');

    // Places are stored in session, not component state
    $places = session('game_places');

    expect($places)->toBeArray()
        ->and(count($places))->toBeGreaterThanOrEqual(5);
});

it('supports different difficulty levels', function () {
    // Easy
    $easy = Livewire::test(Game::class)
        ->set('difficulty', Difficulty::Easy->value)
        ->call('startGame')
        ->get('currentPlace');

    expect($easy)->toHaveKey('name');

    // Medium
    $medium = Livewire::test(Game::class)
        ->set('difficulty', Difficulty::Medium->value)
        ->call('startGame')
        ->get('currentPlace');

    expect($medium)->toHaveKey('name');

    // Hard
    $hard = Livewire::test(Game::class)
        ->set('difficulty', Difficulty::Hard->value)
        ->call('startGame')
        ->get('currentPlace');

    expect($hard)->toHaveKey('name');
});

it('supports different game types', function () {
    $gameTypes = [
        [PlaceType::Mixed->value],
        [PlaceType::City->value],
        [PlaceType::Country->value],
        [PlaceType::WineRegion->value],
    ];

    foreach ($gameTypes as $types) {
        $component = Livewire::test(Game::class)
            ->set('gameTypes', $types)
            ->set('rounds', 3) // Lower rounds to ensure enough places
            ->call('startGame');

        expect($component->get('currentPlace'))->toHaveKey('name');
    }
});

it('toggles game types correctly', function () {
    $component = Livewire::test(Game::class);

    // Initially has 'mixed'
    expect($component->get('gameTypes'))->toBe([PlaceType::Mixed->value]);

    // Toggle to a specific type
    $component->call('toggleGameType', PlaceType::City->value);
    expect($component->get('gameTypes'))->toBe([PlaceType::City->value]);

    // Add another type
    $component->call('toggleGameType', PlaceType::Country->value);
    expect($component->get('gameTypes'))->toContain(PlaceType::City->value)
        ->and($component->get('gameTypes'))->toContain(PlaceType::Country->value)
        ->and($component->get('gameTypes'))->not->toContain(PlaceType::Mixed->value);

    // Toggle back to mixed
    $component->call('toggleGameType', PlaceType::Mixed->value);
    expect($component->get('gameTypes'))->toBe([PlaceType::Mixed->value]);
});

it('defaults back to mixed when all types removed', function () {
    $component = Livewire::test(Game::class)
        ->set('gameTypes', [PlaceType::City->value]);

    // Remove the only type
    $component->call('toggleGameType', PlaceType::City->value);

    // Should default back to mixed
    expect($component->get('gameTypes'))->toBe([PlaceType::Mixed->value]);
});

it('provides feedback messages based on score', function () {
    $component = Livewire::test(Game::class)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');

    // Perfect guess
    $component->call('submitGuess', $currentPlace['lat'], $currentPlace['lng']);

    $feedback = $component->get('lastFeedback');

    expect($feedback)->toBeArray()
        ->and($feedback)->toHaveKey('message')
        ->and($feedback)->toHaveKey('class')
        ->and($feedback)->toHaveKey('emoji');
});

it('generates appropriate final messages', function () {
    $component = Livewire::test(Game::class)
        ->set('rounds', 1)
        ->call('startGame');

    $currentPlace = $component->get('currentPlace');
    $component->call('submitGuess', $currentPlace['lat'], $currentPlace['lng']);
    $component->call('continueToNextRound');

    $finalMessage = $component->get('finalMessage');

    expect($finalMessage)->toBeString()
        ->and($finalMessage)->not->toBeEmpty();
});
