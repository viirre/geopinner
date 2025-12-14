<?php

use App\Livewire\Game;
use App\Livewire\Multiplayer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed test data
    $this->artisan('db:seed', ['--class' => 'PlacesSeeder']);
});

test('single player game screen renders without livewire errors', function () {
    // Start a game and navigate to game screen
    Livewire::test(Game::class)
        ->set('difficulty', 'medium')
        ->set('gameTypes', ['city'])
        ->set('rounds', 5)
        ->call('startGame')
        ->assertSet('screen', 'game')
        ->assertHasNoErrors();
});

test('single player can complete full game flow without errors', function () {
    // Test complete flow: setup -> game -> result
    Livewire::test(Game::class)
        ->assertSet('screen', 'setup')
        ->set('difficulty', 'medium')
        ->set('gameTypes', ['city'])
        ->set('rounds', 5)
        ->call('startGame')
        ->assertSet('screen', 'game')
        ->call('finishGame')
        ->assertSet('screen', 'result')
        ->assertHasNoErrors();
});

test('multiplayer game screen renders without livewire errors', function () {
    // Create and join a multiplayer game
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Test Player')
        ->set('difficulty', 'medium')
        ->set('gameTypes', ['city'])
        ->set('rounds', 5)
        ->call('createGame')
        ->assertSet('screen', 'waiting')
        ->assertHasNoErrors();

    // Verify game code was created
    expect($component->get('sessionGameCode'))->not->toBeEmpty();
});

test('multiplayer can create game without serialization errors', function () {
    // This specifically tests that the component doesn't have
    // non-serializable properties like function references
    Livewire::test(Multiplayer::class)
        ->set('hostName', 'Test Player')
        ->set('difficulty', 'medium')
        ->set('gameTypes', ['city'])
        ->set('rounds', 5)
        ->call('createGame')
        ->assertSet('screen', 'waiting')
        ->assertHasNoErrors()
        // Make a subsequent call to ensure component can be hydrated
        ->call('loadPlayers')
        ->assertHasNoErrors();
});

test('single player game state persists across livewire calls', function () {
    // This ensures the beforeunload handler doesn't interfere with state
    Livewire::test(Game::class)
        ->set('difficulty', 'easy')
        ->set('gameTypes', ['capital'])
        ->set('rounds', 10)
        ->call('startGame')
        ->assertSet('screen', 'game')
        ->assertSet('rounds', 10)
        ->assertSet('difficulty', 'easy')
        ->assertHasNoErrors();
});
