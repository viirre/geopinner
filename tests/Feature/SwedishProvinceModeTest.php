<?php

use App\Enums\Difficulty;
use App\Enums\PlaceType;
use App\Events\RoundStarted;
use App\Livewire\Game;
use App\Livewire\Multiplayer;
use App\Models\Game as GameModel;
use App\Models\Guess;
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

it('seeds all 25 swedish provinces', function () {
    $provinces = Place::query()->where('type', PlaceType::SwedishProvince->value)->get();

    expect($provinces)->toHaveCount(25);
    expect($provinces->pluck('name'))->toContain('Skåne', 'Gotland', 'Lappland', 'Ångermanland');

    foreach ($provinces as $province) {
        expect((float) $province->lat)->toBeBetween(55.0, 69.5);
        expect((float) $province->lng)->toBeBetween(10.5, 24.5);
        expect($province->size)->toBeGreaterThan(0);
    }
});

it('has provinces available in every difficulty', function (Difficulty $difficulty, int $expectedCount) {
    $count = app(PlaceService::class)->getPlaceCount($difficulty, [PlaceType::SwedishProvince->value]);

    expect($count)->toBe($expectedCount);
})->with([
    'easy' => [Difficulty::Easy, 15],
    'medium' => [Difficulty::Medium, 25],
    'hard' => [Difficulty::Hard, 25],
]);

it('does not include provinces in the mixed world mode', function () {
    $places = app(PlaceService::class)->getPlaces(Difficulty::Medium, [PlaceType::Mixed->value]);

    expect($places->pluck('type'))->not->toContain(PlaceType::SwedishProvince->value);
});

it('selects provinces when switching single player region to sweden', function () {
    Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->assertSet('region', 'sweden')
        ->assertSet('gameTypes', [PlaceType::SwedishProvince->value])
        ->assertSee(['Hela Sverige', 'Norrland', 'Svealand', 'Götaland'])
        ->assertDontSee('Viner');
});

it('resets game types to mixed when leaving the sweden region', function () {
    Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->call('setRegion', 'world')
        ->assertSet('gameTypes', [PlaceType::Mixed->value]);
});

it('starts a single player game with only swedish provinces', function () {
    Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->set('difficulty', Difficulty::Medium->value)
        ->set('rounds', 20)
        ->call('startGame')
        ->assertSet('screen', 'game')
        ->assertSet('setupError', null);

    $places = session('game_places');

    expect($places)->toHaveCount(25);
    expect(collect($places)->pluck('type')->unique()->all())->toBe([PlaceType::SwedishProvince->value]);
});

it('only uses provinces in sweden region even if game types were tampered with', function () {
    Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->call('toggleGameType', PlaceType::Country->value)
        ->call('startGame')
        ->assertSet('screen', 'game');

    expect(collect(session('game_places'))->pluck('type')->unique()->all())
        ->toBe([PlaceType::SwedishProvince->value]);
});

it('shows a setup error when more rounds are requested than there are provinces', function () {
    Livewire::test(Game::class)
        ->call('setRegion', 'sweden')
        ->set('difficulty', Difficulty::Easy->value)
        ->set('rounds', 20)
        ->call('startGame')
        ->assertSet('screen', 'setup')
        ->assertSet('setupError', 'Det finns bara 15 platser i denna kombination. Välj färre rundor eller byt speltyp/svårighetsgrad.');
});

it('creates a multiplayer game with the sweden region', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', Difficulty::Medium->value)
        ->set('rounds', 10)
        ->set('timerDuration', 30)
        ->call('setRegion', 'sweden')
        ->call('createGame')
        ->assertHasNoErrors()
        ->assertSet('screen', 'waiting');

    $game = GameModel::query()->where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['gameTypes'])->toBe([PlaceType::SwedishProvince->value]);
});

it('scores a multiplayer guess 150 km off by place type', function (string $type, int $expectedScore) {
    $game = GameModel::query()->create([
        'code' => 'SWE001',
        'settings' => ['difficulty' => 'medium', 'rounds' => 5, 'gameTypes' => [$type]],
        'status' => 'playing',
    ]);

    $player = Player::query()->create([
        'game_id' => $game->id,
        'name' => 'Host',
        'color' => '#ff0000',
        'total_score' => 0,
        'is_host' => true,
    ]);

    $round = Round::query()->create([
        'game_id' => $game->id,
        'round_number' => 1,
        'place_data' => ['name' => 'Test', 'lat' => 59.33, 'lng' => 18.07, 'type' => $type, 'size' => 0],
        'started_at' => now(),
    ]);

    $this->postJson(route('api.games.guess'), [
        'round_id' => $round->id,
        'player_id' => $player->id,
        'lat' => 60.68,
        'lng' => 18.07,
    ])->assertSuccessful();

    expect(Guess::query()->where('round_id', $round->id)->value('score'))->toBe($expectedScore);
})->with([
    'swedish province without outline' => [PlaceType::SwedishProvince->value, 5],
    'wine region' => [PlaceType::WineRegion->value, 8],
    'city' => [PlaceType::City->value, 9],
]);

it('has an outline for every swedish province', function () {
    $outlines = json_decode(file_get_contents(resource_path('js/map/swedishProvinces.json')), true);
    $outlineNames = collect($outlines['features'])->pluck('properties.name');

    $provinceNames = Place::query()->where('type', PlaceType::SwedishProvince->value)->pluck('name');

    expect($outlineNames->sort()->values()->all())->toBe($provinceNames->sort()->values()->all());

    foreach ($outlines['features'] as $feature) {
        expect($feature['geometry']['type'])->toBeIn(['Polygon', 'MultiPolygon']);
    }
});

it('offers province borders on the single player map only in the sweden region', function (string $region, bool $expectsToggle) {
    $component = Livewire::test(Game::class)
        ->call('setRegion', $region)
        ->set('difficulty', Difficulty::Medium->value)
        ->set('rounds', 5)
        ->call('startGame')
        ->assertSet('screen', 'game');

    $expectsToggle
        ? $component->assertSee('Visa landskapsgränser')
        : $component->assertDontSee('Visa landskapsgränser');
})->with([
    'sweden' => ['sweden', true],
    'world' => ['world', false],
]);

it('shows the province border setting in multiplayer setup only for sweden', function () {
    Livewire::test(Multiplayer::class)
        ->assertDontSee('Visa landskapsgränser på kartan')
        ->call('setRegion', 'sweden')
        ->assertSee('Visa landskapsgränser på kartan');
});

it('stores the province border setting when creating a multiplayer game', function (string $region, bool $expected) {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('difficulty', Difficulty::Medium->value)
        ->set('rounds', 10)
        ->set('timerDuration', 30)
        ->call('setRegion', $region)
        ->set('showProvinceBorders', true)
        ->call('createGame')
        ->assertHasNoErrors();

    $game = GameModel::query()->where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['showProvinceBorders'])->toBe($expected);
})->with([
    'sweden' => ['sweden', true],
    'world ignores the setting' => ['world', false],
]);

it('broadcasts the province border setting to all players when a round starts', function () {
    $game = GameModel::query()->create([
        'code' => 'SWE002',
        'settings' => ['difficulty' => 'medium', 'rounds' => 5, 'gameTypes' => [PlaceType::SwedishProvince->value], 'showProvinceBorders' => true],
        'status' => 'playing',
    ]);

    $round = Round::query()->create([
        'game_id' => $game->id,
        'round_number' => 1,
        'place_data' => ['name' => 'Skåne', 'lat' => 55.95, 'lng' => 13.55, 'type' => PlaceType::SwedishProvince->value, 'size' => 45],
        'started_at' => now(),
    ]);

    $payload = (new RoundStarted($game, $round))->broadcastWith();

    expect($payload['game']['show_province_borders'])->toBeTrue();

    Livewire::test(Multiplayer::class)
        ->call('startRound', $payload['round'], $payload['game'])
        ->assertSet('showProvinceBorders', true)
        ->assertDispatched('round-started-mp');
});

it('shows province borders by default in a new multiplayer sweden game', function () {
    $component = Livewire::test(Multiplayer::class)
        ->set('hostName', 'Host Player')
        ->set('rounds', 10)
        ->set('timerDuration', 30)
        ->call('setRegion', 'sweden')
        ->call('createGame')
        ->assertHasNoErrors();

    $game = GameModel::query()->where('code', $component->get('sessionGameCode'))->first();

    expect($game->settings['showProvinceBorders'])->toBeTrue();
});
