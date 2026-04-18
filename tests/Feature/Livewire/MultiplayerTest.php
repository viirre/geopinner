<?php

use App\Livewire\Multiplayer;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    // Fake broadcasting events to avoid Pusher dependency in tests
    Event::fake();

    // Seed places so createGame can satisfy its availability check
    $this->artisan('db:seed', ['--class' => 'PlacesSeeder']);
});

it('can create a multiplayer game', function () {
    Livewire::test(Multiplayer::class)
        ->set('hostName', 'Player 1')
        ->set('difficulty', 'medium')
        ->set('rounds', 10)
        ->set('gameTypes', ['mixed'])
        ->set('timerDuration', 30)
        ->set('showLabels', false)
        ->call('createGame')
        ->assertHasNoErrors()
        ->assertSet('screen', 'waiting')
        ->assertSet('isHost', true);

    // Verify game was created in database
    assertDatabaseHas('games', [
        'status' => 'waiting',
    ]);

    // Verify host player was created
    assertDatabaseHas('players', [
        'name' => 'Player 1',
        'is_host' => true,
    ]);
});

it('can join an existing game', function () {
    // Create a game first
    $hostComponent = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', 'easy')
        ->set('rounds', 5)
        ->set('gameTypes', ['mixed'])
        ->set('timerDuration', 10)
        ->call('createGame');

    $gameCode = $hostComponent->get('sessionGameCode');

    // Join the game as second player
    Livewire::test(Multiplayer::class)
        ->set('playerName', 'Player 2')
        ->set('gameCode', $gameCode)
        ->call('joinGame')
        ->assertHasNoErrors()
        ->assertSet('screen', 'waiting')
        ->assertSet('isHost', false)
        ->assertSet('sessionGameCode', $gameCode);

    // Verify second player was created
    assertDatabaseHas('players', [
        'name' => 'Player 2',
        'is_host' => false,
    ]);

    // Verify game now has 2 players
    $game = Game::where('code', $gameCode)->first();
    expect($game->players()->count())->toBe(2);
});

it('validates game code when joining', function () {
    Livewire::test(Multiplayer::class)
        ->set('playerName', 'Player 2')
        ->set('gameCode', 'INVALID')
        ->call('joinGame')
        ->assertHasErrors(['gameCode']);
});

it('prevents joining a full game', function () {
    // Create a game
    $hostComponent = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host')
        ->set('difficulty', 'easy')
        ->set('rounds', 5)
        ->set('gameTypes', ['mixed'])
        ->set('timerDuration', 10)
        ->call('createGame');

    $gameCode = $hostComponent->get('sessionGameCode');
    $game = Game::where('code', $gameCode)->first();

    // Add 5 more players (total 6, which is max)
    for ($i = 1; $i <= 5; $i++) {
        Player::create([
            'game_id' => $game->id,
            'name' => "Player {$i}",
            'color' => "#00000{$i}",
            'total_score' => 0,
            'is_host' => false,
        ]);
    }

    // Try to join as 7th player
    Livewire::test(Multiplayer::class)
        ->set('playerName', 'Player 7')
        ->set('gameCode', $gameCode)
        ->call('joinGame')
        ->assertHasErrors(['gameCode']);
});

it('host can start game with minimum 2 players', function () {
    // Create game as host
    $hostComponent = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host')
        ->set('difficulty', 'medium')
        ->set('rounds', 10)
        ->set('gameTypes', ['mixed'])
        ->set('timerDuration', 30)
        ->call('createGame');

    $gameCode = $hostComponent->get('sessionGameCode');

    // Join as second player
    Livewire::test(Multiplayer::class)
        ->set('playerName', 'Player 2')
        ->set('gameCode', $gameCode)
        ->call('joinGame');

    // Host starts the game
    $hostComponent
        ->call('startGame')
        ->assertHasNoErrors();

    // Verify game status changed
    assertDatabaseHas('games', [
        'code' => $gameCode,
        'status' => 'playing',
    ]);
});

it('requires minimum 2 players to start', function () {
    // Create game as solo host
    $hostComponent = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Solo Host')
        ->set('difficulty', 'medium')
        ->set('rounds', 10)
        ->set('gameTypes', ['mixed'])
        ->set('timerDuration', 30)
        ->call('createGame');

    // Try to start with only 1 player
    $hostComponent
        ->call('startGame')
        ->assertHasErrors(['start']);

    // Verify game status didn't change
    $gameCode = $hostComponent->get('sessionGameCode');
    assertDatabaseHas('games', [
        'code' => $gameCode,
        'status' => 'waiting',
    ]);
});

it('only host can start the game', function () {
    // Create game as host
    $hostComponent = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host')
        ->set('difficulty', 'medium')
        ->set('rounds', 10)
        ->set('gameTypes', ['mixed'])
        ->set('timerDuration', 30)
        ->call('createGame');

    $gameCode = $hostComponent->get('sessionGameCode');

    // Join as second player (non-host)
    $playerComponent = Livewire::test(Multiplayer::class)
        ->set('playerName', 'Player 2')
        ->set('gameCode', $gameCode)
        ->call('joinGame');

    // Non-host tries to start game - should be ignored
    $playerComponent->call('startGame');

    // Game should still be waiting
    assertDatabaseHas('games', [
        'code' => $gameCode,
        'status' => 'waiting',
    ]);
});

it('loads players correctly after creation', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', 'medium')
        ->set('rounds', 10)
        ->set('gameTypes', ['mixed'])
        ->set('timerDuration', 30)
        ->call('createGame');

    $players = $component->get('players');

    expect($players)->toBeArray()
        ->and($players)->toHaveCount(1)
        ->and($players[0]['name'])->toBe('Host Player')
        ->and($players[0]['is_host'])->toBeTrue();
});

it('validates required fields when creating game', function () {
    Livewire::test(Multiplayer::class)
        ->set('hostName', '')
        ->call('createGame')
        ->assertHasErrors(['hostName']);
});

it('validates required fields when joining game', function () {
    Livewire::test(Multiplayer::class)
        ->set('playerName', '')
        ->set('gameCode', '')
        ->call('joinGame')
        ->assertHasErrors(['playerName', 'gameCode']);
});

it('handles timeout when timer runs out', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('sessionPlayerId', 1)
        ->set('currentPlace', [
            'name' => 'Test Place',
            'lat' => 0,
            'lng' => 0,
            'round_id' => 1,
        ])
        ->set('hasGuessed', false);

    // Call handleTimeout
    $component->call('handleTimeout')
        ->assertSet('hasGuessed', true)
        ->assertDispatched('submit-mp-timeout');
});

it('prevents timeout if already guessed', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('sessionPlayerId', 1)
        ->set('currentPlace', [
            'name' => 'Test Place',
            'lat' => 0,
            'lng' => 0,
            'round_id' => 1,
        ])
        ->set('hasGuessed', true);

    // Call handleTimeout - should do nothing
    $component->call('handleTimeout')
        ->assertSet('hasGuessed', true)
        ->assertNotDispatched('submit-mp-timeout');
});

it('defaults region to world', function () {
    Livewire::test(Multiplayer::class)->assertSet('region', 'world');
});

it('switches region and resets game types to mixed', function () {
    $component = Livewire::test(Multiplayer::class)
        ->call('toggleGameType', \App\Enums\PlaceType::City->value);

    expect($component->get('gameTypes'))->toBe([\App\Enums\PlaceType::City->value]);

    $component->call('setRegion', 'europe');

    expect($component->get('region'))->toBe('europe');
    expect($component->get('gameTypes'))->toBe([\App\Enums\PlaceType::Mixed->value]);
});

it('creates a multiplayer game with europe region using resolved place types', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', 'medium')
        ->set('rounds', 5)
        ->set('timerDuration', 30)
        ->call('setRegion', 'europe')
        ->call('toggleGameType', \App\Enums\PlaceType::Country->value)
        ->call('createGame')
        ->assertHasNoErrors()
        ->assertSet('screen', 'waiting');

    $game = Game::where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['gameTypes'])->toBe([\App\Enums\PlaceType::CountryEurope->value]);
});

it('creates a multiplayer game with europe region and mixed type expands to all europe variants', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', 'easy')
        ->set('rounds', 5)
        ->set('timerDuration', 30)
        ->call('setRegion', 'europe')
        ->call('createGame')
        ->assertHasNoErrors();

    $game = Game::where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['gameTypes'])->toEqualCanonicalizing([
        \App\Enums\PlaceType::CountryEurope->value,
        \App\Enums\PlaceType::CapitalEurope->value,
        \App\Enums\PlaceType::CityEurope->value,
    ]);
});

it('exposes a setup error when not enough european places match settings', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', 'hard')
        ->set('rounds', 10)
        ->set('timerDuration', 30)
        ->call('setRegion', 'europe')
        ->call('toggleGameType', \App\Enums\PlaceType::Capital->value)
        ->call('createGame');

    expect($component->get('setupError'))->toBeString()->not->toBeEmpty();
    expect($component->get('screen'))->toBe('lobby');
});

it('clears setup error when changing region or toggling type', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('setupError', 'något gick fel');

    $component->call('setRegion', 'europe');
    expect($component->get('setupError'))->toBeNull();

    $component->set('setupError', 'något annat');
    $component->call('toggleGameType', \App\Enums\PlaceType::Country->value);
    expect($component->get('setupError'))->toBeNull();
});
