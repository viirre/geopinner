<?php

use App\Enums\Difficulty;
use App\Enums\PlaceType;
use App\Enums\SwedenPart;
use App\Events\RoundStarted;
use App\Livewire\Game;
use App\Livewire\Multiplayer;
use App\Models\Game as GameModel;
use App\Models\Place;
use App\Models\Player;
use App\Models\Round;
use App\Services\PlaceService;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;

beforeEach(function () {
    Event::fake();

    $this->artisan('db:seed', ['--class' => 'PlacesSeeder']);
});

it('splits all seeded provinces into the three parts of sweden', function () {
    $seededNames = Place::query()->where('type', PlaceType::SwedishProvince->value)->pluck('name')->sort()->values()->all();

    $partNames = collect([SwedenPart::Norrland, SwedenPart::Svealand, SwedenPart::Gotaland])
        ->flatMap(fn (SwedenPart $part) => $part->provinceNames());

    expect($partNames->duplicates())->toBeEmpty();
    expect($partNames->sort()->values()->all())->toBe($seededNames);
    expect(collect(SwedenPart::All->provinceNames())->sort()->values()->all())->toBe($seededNames);
});

it('tags every province outline with the part it belongs to', function () {
    $outlines = json_decode(file_get_contents(resource_path('js/map/swedishProvinces.json')), true);

    foreach ($outlines['features'] as $feature) {
        $part = SwedenPart::from($feature['properties']['part']);

        expect($part->provinceNames())->toContain($feature['properties']['name']);
    }
});

it('returns every province in a part regardless of difficulty', function (SwedenPart $part, int $expectedCount) {
    $places = app(PlaceService::class)->getPlaces(Difficulty::Easy, [PlaceType::SwedishProvince->value], $part);

    expect($places)->toHaveCount($expectedCount);
    expect($places->pluck('name')->sort()->values()->all())->toBe(collect($part->provinceNames())->sort()->values()->all());
})->with([
    'norrland' => [SwedenPart::Norrland, 9],
    'svealand' => [SwedenPart::Svealand, 6],
    'götaland' => [SwedenPart::Gotaland, 10],
]);

it('keeps the difficulty filter for the whole of sweden', function () {
    $count = app(PlaceService::class)->getPlaceCount(Difficulty::Easy, [PlaceType::SwedishProvince->value], SwedenPart::All);

    expect($count)->toBe(15);
});

it('plays every province in the chosen part once in single player', function () {
    $component = Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->call('setSwedenPart', SwedenPart::Svealand->value)
        ->set('difficulty', Difficulty::Easy->value)
        ->set('rounds', 20)
        ->assertSee('Alla 6 landskap i Svealand, ett per runda.')
        ->call('startGame')
        ->assertSet('screen', 'game')
        ->assertSet('setupError', null)
        ->assertSet('totalRounds', 6)
        ->assertSee('/ 6');

    expect(collect(session('game_places'))->pluck('name')->sort()->values()->all())
        ->toBe(collect(SwedenPart::Svealand->provinceNames())->sort()->values()->all());

    $component->set('currentRound', 6)
        ->call('continueToNextRound')
        ->assertSet('screen', 'result');
});

it('uses the round setting when playing the whole of sweden', function () {
    Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->call('setSwedenPart', SwedenPart::All->value)
        ->set('rounds', 10)
        ->call('startGame')
        ->assertSet('totalRounds', 10);
});

it('ignores the part outside the sweden region', function () {
    Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->call('setSwedenPart', SwedenPart::Norrland->value)
        ->call('setRegion', 'world')
        ->set('rounds', 10)
        ->call('startGame')
        ->assertSet('totalRounds', 10);

    expect(collect(session('game_places'))->pluck('type'))->not->toContain(PlaceType::SwedishProvince->value);
});

it('ignores an unknown part', function () {
    Livewire::test(Game::class)
        ->call('setSwedenPart', 'lappland')
        ->assertSet('swedenPart', SwedenPart::All);
});

it('creates a multiplayer game with every province in the chosen part', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', Difficulty::Easy->value)
        ->set('rounds', 20)
        ->set('timerDuration', 30)
        ->call('setRegion', 'sweden')
        ->call('setSwedenPart', SwedenPart::Norrland->value)
        ->assertSee('Alla 9 landskap i Norrland, ett per runda.')
        ->call('createGame')
        ->assertHasNoErrors()
        ->assertSet('setupError', null)
        ->assertSet('screen', 'waiting');

    $game = GameModel::query()->where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['rounds'])->toBe(9);
    expect($game->settings['swedenPart'])->toBe(SwedenPart::Norrland->value);
});

it('does not store a part for multiplayer games outside sweden', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('rounds', 10)
        ->set('timerDuration', 30)
        ->call('setSwedenPart', SwedenPart::Norrland->value)
        ->call('createGame')
        ->assertHasNoErrors();

    $game = GameModel::query()->where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['rounds'])->toBe(10);
    expect($game->settings['swedenPart'])->toBeNull();
});

it('broadcasts the part so every player frames the same map', function () {
    $game = GameModel::query()->create([
        'code' => 'PART01',
        'settings' => ['difficulty' => 'medium', 'rounds' => 6, 'gameTypes' => [PlaceType::SwedishProvince->value], 'swedenPart' => SwedenPart::Svealand->value],
        'status' => 'playing',
    ]);

    $round = Round::query()->create([
        'game_id' => $game->id,
        'round_number' => 1,
        'place_data' => ['name' => 'Uppland', 'lat' => 59.95, 'lng' => 17.95, 'type' => PlaceType::SwedishProvince->value, 'size' => 45],
        'started_at' => now(),
    ]);

    $payload = (new RoundStarted($game, $round))->broadcastWith();

    expect($payload['game']['sweden_part'])->toBe(SwedenPart::Svealand->value);

    Livewire::test(Multiplayer::class)
        ->call('startRound', $payload['round'], $payload['game'])
        ->assertSet('swedenPart', SwedenPart::Svealand);
});

it('never repeats a province before every province in the part has been played', function () {
    $game = GameModel::query()->create([
        'code' => 'PART02',
        'settings' => ['difficulty' => 'medium', 'rounds' => 10, 'gameTypes' => [PlaceType::SwedishProvince->value], 'swedenPart' => SwedenPart::Gotaland->value],
        'status' => 'playing',
    ]);

    $host = Player::query()->create([
        'game_id' => $game->id,
        'name' => 'Host',
        'color' => '#ff0000',
        'total_score' => 0,
        'is_host' => true,
    ]);

    foreach (range(1, 10) as $roundNumber) {
        $this->postJson(route('api.games.next-round'), [
            'game_id' => $game->id,
            'player_id' => $host->id,
        ])->assertSuccessful();
    }

    $playedNames = $game->rounds()->orderBy('round_number')->get()->pluck('place_data.name');

    expect($playedNames)->toHaveCount(10);
    expect($playedNames->sort()->values()->all())->toBe(collect(SwedenPart::Gotaland->provinceNames())->sort()->values()->all());
});
