<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

// Livewire versions
Route::get('/game-v2', \App\Livewire\Game::class)->name('game.v2');
Route::get('/multiplayer-v2', \App\Livewire\Multiplayer::class)->name('multiplayer.v2');

// Original vanilla JS version
Route::get('/multiplayer', function () {
    return view('multiplayer');
})->name('multiplayer');

//Route::get('broadcast', function () {
//    Broadcast::on('orders')->with(['message' => 'Orders refreshed!'])->sendNow();
//})->name('broadcast');

// API routes for multiplayer game
Route::prefix('api')->group(function () {
    Route::post('/games/create', [GameController::class, 'create'])->name('api.games.create');
    Route::post('/games/join', [GameController::class, 'join'])->name('api.games.join');
    Route::get('/games/{code}/players', [GameController::class, 'players'])->name('api.games.players');
    Route::post('/games/start', [GameController::class, 'start'])->name('api.games.start');
    Route::post('/games/guess', [GameController::class, 'submitGuess'])->name('api.games.guess');
    Route::post('/games/next-round', [GameController::class, 'nextRound'])->name('api.games.next-round');

    // Get places for single player
    Route::get('/places', [GameController::class, 'getPlaces'])->name('api.places');
});
