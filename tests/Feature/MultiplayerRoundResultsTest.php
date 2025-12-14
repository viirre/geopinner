<?php

use App\Events\RoundCompleted;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Player;
use App\Models\Round;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('round completed event sorts guesses by score with highest first', function () {
    // Create a game
    $game = Game::create([
        'code' => 'TEST01',
        'settings' => [
            'difficulty' => 'medium',
            'rounds' => 5,
            'gameTypes' => ['city'],
            'timerEnabled' => true,
            'timerDuration' => 30,
        ],
        'status' => 'playing',
    ]);

    // Create players
    $player1 = Player::create([
        'game_id' => $game->id,
        'name' => 'Player 1',
        'color' => '#ff0000',
        'total_score' => 0,
        'is_host' => true,
    ]);

    $player2 = Player::create([
        'game_id' => $game->id,
        'name' => 'Player 2',
        'color' => '#00ff00',
        'total_score' => 0,
        'is_host' => false,
    ]);

    // Create a round
    $round = Round::create([
        'game_id' => $game->id,
        'round_number' => 1,
        'place_data' => [
            'name' => 'Test City',
            'lat' => 59.3293,
            'lng' => 18.0686,
            'type' => 'city',
            'size' => 50,
        ],
        'started_at' => now(),
    ]);

    // Player 1 gets 7 points (submitted first)
    Guess::create([
        'round_id' => $round->id,
        'player_id' => $player1->id,
        'lat' => 59.0,
        'lng' => 18.0,
        'distance' => 500,
        'score' => 7,
        'guessed_at' => now(),
    ]);

    // Player 2 gets 9 points (submitted second)
    Guess::create([
        'round_id' => $round->id,
        'player_id' => $player2->id,
        'lat' => 59.3,
        'lng' => 18.1,
        'distance' => 100,
        'score' => 9,
        'guessed_at' => now()->addSecond(),
    ]);

    // Mark round as complete
    $round->update(['completed_at' => now()]);

    // Create the event
    $event = new RoundCompleted($game, $round);
    $broadcastData = $event->broadcastWith();

    // Verify guesses are sorted by score descending
    $guesses = $broadcastData['guesses'];

    expect($guesses)->toHaveCount(2);

    // First guess should be Player 2 with 9 points (winner)
    expect($guesses[0]['player']['name'])->toBe('Player 2');
    expect($guesses[0]['score'])->toBe(9);

    // Second guess should be Player 1 with 7 points
    expect($guesses[1]['player']['name'])->toBe('Player 1');
    expect($guesses[1]['score'])->toBe(7);
});

test('round completed uses distance as tie-breaker when scores are equal', function () {
    // Create a game
    $game = Game::create([
        'code' => 'TEST02',
        'settings' => [
            'difficulty' => 'medium',
            'rounds' => 5,
            'gameTypes' => ['city'],
        ],
        'status' => 'playing',
    ]);

    // Create players
    $player1 = Player::create([
        'game_id' => $game->id,
        'name' => 'Player A - Far',
        'color' => '#ff0000',
        'total_score' => 0,
        'is_host' => true,
    ]);

    $player2 = Player::create([
        'game_id' => $game->id,
        'name' => 'Player B - Closest',
        'color' => '#00ff00',
        'total_score' => 0,
        'is_host' => false,
    ]);

    $player3 = Player::create([
        'game_id' => $game->id,
        'name' => 'Player C - Middle',
        'color' => '#0000ff',
        'total_score' => 0,
        'is_host' => false,
    ]);

    // Create a round
    $round = Round::create([
        'game_id' => $game->id,
        'round_number' => 1,
        'place_data' => [
            'name' => 'Test City',
            'lat' => 59.3293,
            'lng' => 18.0686,
            'type' => 'city',
            'size' => 50,
        ],
        'started_at' => now(),
    ]);

    // All three players get same score (8 points) but different distances
    Guess::create([
        'round_id' => $round->id,
        'player_id' => $player1->id,
        'lat' => 59.0,
        'lng' => 18.0,
        'distance' => 800, // Farthest
        'score' => 8,
        'guessed_at' => now(),
    ]);

    Guess::create([
        'round_id' => $round->id,
        'player_id' => $player2->id,
        'lat' => 59.3,
        'lng' => 18.05,
        'distance' => 300, // Closest
        'score' => 8,
        'guessed_at' => now()->addSecond(),
    ]);

    Guess::create([
        'round_id' => $round->id,
        'player_id' => $player3->id,
        'lat' => 59.2,
        'lng' => 18.0,
        'distance' => 500, // Middle
        'score' => 8,
        'guessed_at' => now()->addSeconds(2),
    ]);

    $round->update(['completed_at' => now()]);

    $event = new RoundCompleted($game, $round);
    $broadcastData = $event->broadcastWith();

    $guesses = $broadcastData['guesses'];

    // All should have same score
    expect($guesses)->toHaveCount(3);

    // Winner should be Player B (closest distance)
    expect($guesses[0]['player']['name'])->toBe('Player B - Closest');
    expect($guesses[0]['score'])->toBe(8);
    expect((float) $guesses[0]['distance'])->toBe(300.0);

    // Second should be Player C (middle distance)
    expect($guesses[1]['player']['name'])->toBe('Player C - Middle');
    expect($guesses[1]['score'])->toBe(8);
    expect((float) $guesses[1]['distance'])->toBe(500.0);

    // Third should be Player A (farthest)
    expect($guesses[2]['player']['name'])->toBe('Player A - Far');
    expect($guesses[2]['score'])->toBe(8);
    expect((float) $guesses[2]['distance'])->toBe(800.0);
});

test('round completed with timeout player shows correct winner', function () {
    // Create a game
    $game = Game::create([
        'code' => 'TEST03',
        'settings' => ['difficulty' => 'medium', 'rounds' => 5, 'gameTypes' => ['city']],
        'status' => 'playing',
    ]);

    // Create players
    $player1 = Player::create([
        'game_id' => $game->id,
        'name' => 'Active Player',
        'color' => '#ff0000',
        'total_score' => 0,
        'is_host' => true,
    ]);

    $player2 = Player::create([
        'game_id' => $game->id,
        'name' => 'Timeout Player',
        'color' => '#00ff00',
        'total_score' => 0,
        'is_host' => false,
    ]);

    // Create a round
    $round = Round::create([
        'game_id' => $game->id,
        'round_number' => 1,
        'place_data' => ['name' => 'Test', 'lat' => 59.3293, 'lng' => 18.0686, 'type' => 'city', 'size' => 50],
        'started_at' => now(),
    ]);

    // Player 1 gets 5 points
    Guess::create([
        'round_id' => $round->id,
        'player_id' => $player1->id,
        'lat' => 59.0,
        'lng' => 18.0,
        'distance' => 1200,
        'score' => 5,
        'guessed_at' => now(),
    ]);

    // Player 2 times out (0 points, very large distance)
    Guess::create([
        'round_id' => $round->id,
        'player_id' => $player2->id,
        'lat' => 0,
        'lng' => 0,
        'distance' => PHP_FLOAT_MAX,
        'score' => 0,
        'guessed_at' => now()->addSecond(),
    ]);

    $round->update(['completed_at' => now()]);

    $event = new RoundCompleted($game, $round);
    $broadcastData = $event->broadcastWith();

    $guesses = $broadcastData['guesses'];

    // Active player should be first (winner) even with just 5 points
    expect($guesses[0]['player']['name'])->toBe('Active Player');
    expect($guesses[0]['score'])->toBe(5);

    // Timeout player should be second with 0 points
    expect($guesses[1]['player']['name'])->toBe('Timeout Player');
    expect($guesses[1]['score'])->toBe(0);
});
