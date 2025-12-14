<?php

use App\Livewire\Multiplayer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'PlacesSeeder']);
});

test('multiplayer game applies custom timer duration from host settings', function () {
    // Host creates a game with 20 second timer
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', 'medium')
        ->set('gameTypes', ['city'])
        ->set('rounds', 5)
        ->set('timerDuration', 20) // Custom timer duration
        ->call('createGame');

    // Verify game was created with 20 second timer
    expect($component->get('timerDuration'))->toBe(20);

    // Simulate another player joining
    $joiningPlayer = Livewire::test(Multiplayer::class)
        ->set('playerName', 'Joining Player')
        ->set('gameCode', $component->get('sessionGameCode'))
        ->call('joinGame');

    // Start the game (only host can do this)
    $game = \App\Models\Game::where('code', $component->get('sessionGameCode'))->first();

    // Verify game settings include the custom timer
    expect($game->settings['timerDuration'])->toBe(20);

    // Simulate round starting - this would normally come via Echo broadcast
    $placeData = [
        'name' => 'Test City',
        'lat' => 59.3293,
        'lng' => 18.0686,
        'type' => 'city',
        'size' => 50,
    ];

    $roundData = [
        'id' => 1,
        'number' => 1,
        'place' => $placeData,
        'started_at' => now(),
    ];

    $gameData = [
        'id' => $game->id,
        'total_rounds' => 5,
        'timer_duration' => 20, // Should be 20, not default 10
        'show_labels' => false,
    ];

    // Call startRound on the joining player's component
    $joiningPlayer->call('startRound', $roundData, $gameData);

    // Verify joining player also has 20 second timer
    expect($joiningPlayer->get('timerDuration'))->toBe(20);
    expect($joiningPlayer->get('screen'))->toBe('game');
});

test('multiplayer applies different timer durations correctly', function () {
    $durations = [5, 10, 15, 20, 30, 60];

    foreach ($durations as $duration) {
        // Create game with specific duration
        $component = Livewire::test(Multiplayer::class)
            ->set('hostName', 'Test Player')
            ->set('difficulty', 'medium')
            ->set('gameTypes', ['city'])
            ->set('rounds', 5)
            ->set('timerDuration', $duration)
            ->call('createGame');

        $game = \App\Models\Game::where('code', $component->get('sessionGameCode'))->first();

        // Verify game has the correct duration
        expect($game->settings['timerDuration'])->toBe($duration);

        // Simulate round start
        $roundData = [
            'id' => 1,
            'number' => 1,
            'place' => ['name' => 'Test', 'lat' => 59.0, 'lng' => 18.0, 'type' => 'city', 'size' => 50],
            'started_at' => now(),
        ];

        $gameData = [
            'id' => $game->id,
            'total_rounds' => 5,
            'timer_duration' => $duration,
            'show_labels' => false,
        ];

        $component->call('startRound', $roundData, $gameData);

        // Verify component has correct duration
        expect($component->get('timerDuration'))->toBe($duration);
    }
});

test('multiplayer applies show labels setting from host', function () {
    // Create game with show labels enabled
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', 'medium')
        ->set('gameTypes', ['city'])
        ->set('rounds', 5)
        ->set('showLabels', true) // Enable labels
        ->call('createGame');

    $game = \App\Models\Game::where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['showLabels'])->toBe(true);

    // Simulate round start
    $roundData = [
        'id' => 1,
        'number' => 1,
        'place' => ['name' => 'Test', 'lat' => 59.0, 'lng' => 18.0, 'type' => 'city', 'size' => 50],
        'started_at' => now(),
    ];

    $gameData = [
        'id' => $game->id,
        'total_rounds' => 5,
        'timer_duration' => 30,
        'show_labels' => true, // Should be passed to all players
    ];

    // Simulate joining player receiving round start
    $joiningPlayer = Livewire::test(Multiplayer::class);
    $joiningPlayer->call('startRound', $roundData, $gameData);

    // Verify joining player has labels enabled
    expect($joiningPlayer->get('showLabels'))->toBe(true);
});
