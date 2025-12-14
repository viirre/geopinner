<?php

namespace App\Livewire;

use App\Enums\PlaceType;
use App\Models\Place;
use App\Services\PlaceService;
use App\Services\ScoringService;
use Livewire\Component;

class Game extends Component
{
    // Settings
    public string $difficulty = 'medium';

    public array $gameTypes = ['mixed'];

    public int $rounds = 10;

    public bool $zoomEnabled = true;

    public bool $timerEnabled = true;

    public int $timerDuration = 10;

    public bool $showLabels = false;

    // Game state
    public string $screen = 'setup'; // setup, game, result

    public int $currentRound = 0;

    public int $totalScore = 0;

    public int $totalBonus = 0;

    public ?array $currentPlace = null;

    public array $roundHistory = [];

    public bool $hasGuessed = false;

    // Timer state
    public ?int $roundStartTime = null;

    // UI feedback
    public ?array $lastFeedback = null;

    public function mount(): void
    {
        // Initialize with default settings
    }

    public function toggleGameType(string $type): void
    {
        // Handle "Blandat" (Mixed) exclusivity
        if ($type === PlaceType::Mixed->value) {
            $this->gameTypes = [PlaceType::Mixed->value];

            return;
        }

        // Remove "Blandat" if selecting specific type
        $this->gameTypes = array_values(array_diff($this->gameTypes, [PlaceType::Mixed->value]));

        if (in_array($type, $this->gameTypes)) {
            $this->gameTypes = array_values(array_diff($this->gameTypes, [$type]));
        } else {
            $this->gameTypes[] = $type;
        }

        // If empty, default back to Mixed
        if (empty($this->gameTypes)) {
            $this->gameTypes = [PlaceType::Mixed->value];
        }
    }

    public function startGame(): void
    {
        // Fetch places using PlaceService
        $placeService = app(PlaceService::class);
        $places = $placeService->getPlaces($this->difficulty, $this->gameTypes);

        // Check if we have any places
        if ($places->isEmpty()) {
            $this->dispatch('error', message: 'Inga platser hittades för denna kombination. Välj andra inställningar.');

            return;
        }

        // Check if enough places for selected rounds
        if ($places->count() < $this->rounds) {
            $this->dispatch('error', message: 'Det finns bara '.$places->count().' platser i denna kombination. Välj färre rundor eller byt speltyp/svårighetsgrad.');

            return;
        }

        // Store places in session (not in component state)
        session(['game_places' => $this->fisherYatesShuffle($places->toArray())]);

        // Reset game state
        $this->currentRound = 0;
        $this->totalScore = 0;
        $this->totalBonus = 0;
        $this->roundHistory = [];

        // Transition to game screen and start first round
        $this->screen = 'game';
        $this->nextRound();
    }

    public function nextRound(): void
    {
        $this->currentRound++;
        $this->hasGuessed = false;
        $this->lastFeedback = null;

        // Get next place from session
        $places = session('game_places', []);
        $placeIndex = ($this->currentRound - 1) % count($places);
        $this->currentPlace = $places[$placeIndex];

        // Start timer if enabled
        if ($this->timerEnabled) {
            $this->roundStartTime = time();
        }

        // Clear map markers
        $this->dispatch('clear-map');
        $this->dispatch('round-started');
    }

    public function submitGuess(float $lat, float $lng): void
    {
        if ($this->hasGuessed || ! $this->currentPlace) {
            return;
        }

        $this->hasGuessed = true;

        // Calculate actual elapsed time
        $timeTaken = $this->roundStartTime ? (time() - $this->roundStartTime) : 0;

        // Calculate distance using Haversine formula
        $distance = $this->calculateDistance($lat, $lng, $this->currentPlace['lat'], $this->currentPlace['lng']);

        // Score calculation
        $scoreResult = app(ScoringService::class)->calculateScore($distance, $this->currentPlace);

        // Time bonus calculation
        $timeBonus = 0;
        if ($this->timerEnabled && $scoreResult['points'] >= 7) {
            $timeBonus = $this->calculateTimeBonus($timeTaken, $scoreResult['points']);
        }

        // Update state
        $this->totalScore += $scoreResult['points'];
        $this->totalBonus += $timeBonus;

        // Store feedback for display
        $this->lastFeedback = [
            'message' => $scoreResult['message'],
            'class' => $scoreResult['feedback'],
            'emoji' => $scoreResult['emoji'],
            'points' => $scoreResult['points'],
            'timeBonus' => $timeBonus,
        ];

        if ($timeBonus > 0) {
            $this->lastFeedback['message'] .= " +{$timeBonus} snabbhetsbonus!";
        }

        $this->roundHistory[] = [
            'place' => $this->currentPlace['name'],
            'points' => $scoreResult['points'],
            'timeBonus' => $timeBonus,
            'distance' => $scoreResult['distance'],
            'timeTaken' => $timeTaken,
        ];

        // Dispatch event to Alpine for visual feedback
        $this->dispatch('show-result',
            userLat: $lat,
            userLng: $lng,
            placeLat: $this->currentPlace['lat'],
            placeLng: $this->currentPlace['lng']
        );

        $this->dispatch('round-complete');
    }

    public function handleTimeout(): void
    {
        if ($this->hasGuessed || ! $this->currentPlace) {
            return;
        }

        // Submit with 0 points
        $this->hasGuessed = true;

        $this->lastFeedback = [
            'message' => '⏰ Tiden är ute!',
            'class' => 'poor',
            'emoji' => '⏰',
            'points' => 0,
            'timeBonus' => 0,
        ];

        $this->roundHistory[] = [
            'place' => $this->currentPlace['name'],
            'points' => 0,
            'timeBonus' => 0,
            'distance' => '∞',
            'timeTaken' => $this->timerDuration,
        ];

        // Show correct location
        $this->dispatch('show-timeout-result',
            placeLat: $this->currentPlace['lat'],
            placeLng: $this->currentPlace['lng']
        );

        $this->dispatch('round-complete');
    }

    public function continueToNextRound(): void
    {
        if ($this->currentRound >= $this->rounds) {
            $this->finishGame();
        } else {
            $this->nextRound();
        }
    }

    public function finishGame(): void
    {
        $this->screen = 'result';
        $this->dispatch('game-finished');
    }

    public function playAgain(): void
    {
        // Reset to setup screen
        $this->screen = 'setup';
        $this->currentRound = 0;
        $this->totalScore = 0;
        $this->totalBonus = 0;
        $this->roundHistory = [];
        $this->currentPlace = null;
        $this->hasGuessed = false;
        $this->lastFeedback = null;

        // Clear session data
        session()->forget('game_places');
    }

    private function calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    private function calculateTimeBonus(int $timeTaken, int $basePoints): int
    {
        $duration = $this->timerDuration;

        if ($timeTaken < $duration * 0.25) {
            return 3;
        }
        if ($timeTaken < $duration * 0.5) {
            return 2;
        }
        if ($timeTaken < $duration * 0.75) {
            return 1;
        }

        return 0;
    }

    private function fisherYatesShuffle(array $array): array
    {
        $shuffled = $array;
        $count = count($shuffled);

        for ($i = $count - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$shuffled[$i], $shuffled[$j]] = [$shuffled[$j], $shuffled[$i]];
        }

        return $shuffled;
    }

    public function getFinalMessageProperty(): string
    {
        $maxScore = $this->rounds * 10;
        $percentage = ($this->totalScore / $maxScore) * 100;

        if ($percentage >= 90) {
            return '🏆 Fantastiskt! Du är en geografigenius!';
        } elseif ($percentage >= 75) {
            return '⭐ Excellent! Mycket bra jobbat!';
        } elseif ($percentage >= 60) {
            return '👍 Bra jobbat! Fortsätt öva!';
        } elseif ($percentage >= 40) {
            return '😊 Inte dåligt! Du lär dig mer och mer!';
        } else {
            return '💪 Bra försök! Prova igen så blir det bättre!';
        }
    }

    public function render()
    {
        return view('livewire.game')->layout('layouts.app');
    }
}
