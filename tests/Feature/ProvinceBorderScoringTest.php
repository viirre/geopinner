<?php

use App\Enums\PlaceType;
use App\Models\Game as GameModel;
use App\Models\Guess;
use App\Models\Player;
use App\Models\Round;
use App\Services\ProvinceGeometry;
use Illuminate\Support\Facades\Event;

$uppland = ['name' => 'Uppland', 'lat' => 59.95, 'lng' => 17.95, 'type' => PlaceType::SwedishProvince->value, 'size' => 45];

it('knows when a guess is inside a province', function () use ($uppland) {
    $uppsala = [59.86, 17.64];

    expect(app(ProvinceGeometry::class)->kmOutsideBorder($uppland, ...$uppsala))->toBe(0.0);
});

it('measures how far outside the border a guess in a neighbouring province is', function () use ($uppland) {
    $vasteras = [59.61, 16.55];

    expect(app(ProvinceGeometry::class)->kmOutsideBorder($uppland, ...$vasteras))->toBeBetween(10.0, 60.0);
});

it('has no border for places that are not provinces', function () {
    $stockholm = ['name' => 'Stockholm', 'lat' => 59.33, 'lng' => 18.07, 'type' => PlaceType::City->value, 'size' => 10];

    expect(app(ProvinceGeometry::class)->kmOutsideBorder($stockholm, 59.33, 18.07))->toBeNull();
});

it('scores multiplayer province guesses by the border', function (float $lat, float $lng, int $expectedScore) use ($uppland) {
    Event::fake();

    $game = GameModel::query()->create([
        'code' => 'BORD01',
        'settings' => ['difficulty' => 'medium', 'rounds' => 5, 'gameTypes' => [PlaceType::SwedishProvince->value]],
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
        'place_data' => $uppland,
        'started_at' => now(),
    ]);

    $this->postJson(route('api.games.guess'), [
        'round_id' => $round->id,
        'player_id' => $player->id,
        'lat' => $lat,
        'lng' => $lng,
    ])->assertSuccessful();

    expect(Guess::query()->where('round_id', $round->id)->value('score'))->toBe($expectedScore);
})->with([
    'inside, far from the centre' => [60.55, 17.45, 10],
    'neighbouring province, close to the centre' => [59.61, 16.55, 7],
]);
