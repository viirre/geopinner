<?php

use App\Enums\PlaceType;
use App\Services\ScoringService;

it('scores a guess 150 km off harder for wine regions and swedish provinces', function (PlaceType $type, int $expectedPoints) {
    $result = (new ScoringService)->calculateScore(150, ['type' => $type->value, 'size' => 0]);

    expect($result['points'])->toBe($expectedPoints);
})->with([
    'city' => [PlaceType::City, 9],
    'country' => [PlaceType::Country, 9],
    'wine region' => [PlaceType::WineRegion, 8],
    'docg' => [PlaceType::DOCG, 8],
    'aoc' => [PlaceType::AOC, 8],
    'swedish province' => [PlaceType::SwedishProvince, 5],
]);

it('gives full points for a guess inside the province radius', function () {
    $result = (new ScoringService)->calculateScore(40, ['type' => PlaceType::SwedishProvince->value, 'size' => 45]);

    expect($result['points'])->toBe(10);
});

it('gives full points and says so for a guess inside the province border', function () {
    $result = (new ScoringService)->calculateScore(60, ['type' => PlaceType::SwedishProvince->value, 'size' => 30], 0.0);

    expect($result['points'])->toBe(10);
    expect($result['message'])->toContain('Rätt landskap!');
});

it('never gives more than 7 points for a guess in the wrong province', function (float $kmOutsideBorder, int $expectedPoints) {
    $result = (new ScoringService)->calculateScore(20, ['type' => PlaceType::SwedishProvince->value, 'size' => 30], $kmOutsideBorder);

    expect($result['points'])->toBe($expectedPoints);
    expect($result['message'])->toContain('Fel landskap!');
})->with([
    'just over the border' => [5.0, 7],
    'one province away' => [100.0, 6],
    'across sweden' => [600.0, 1],
]);

it('treats unknown place types as standard difficulty', function () {
    $result = (new ScoringService)->calculateScore(150, ['type' => 'unknown', 'size' => 0]);

    expect($result['points'])->toBe(9);
});

it('has a scoring difficulty factor per place type', function (PlaceType $type, int $expectedFactor) {
    expect($type->scoringDifficultyFactor())->toBe($expectedFactor);
})->with([
    'city' => [PlaceType::City, 1],
    'island' => [PlaceType::Island, 1],
    'wine region' => [PlaceType::WineRegion, 2],
    'docg' => [PlaceType::DOCG, 2],
    'aoc' => [PlaceType::AOC, 2],
    'swedish province' => [PlaceType::SwedishProvince, 8],
]);
