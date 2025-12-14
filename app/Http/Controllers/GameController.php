<?php

namespace App\Http\Controllers;

use App\Enums\Difficulty;
use App\Enums\NumRound;
use App\Enums\PlaceType;
use App\Enums\TimeDuration;
use App\Events\GameCompleted;
use App\Events\GameStarted;
use App\Events\GuessSubmitted;
use App\Events\PlayerJoined;
use App\Events\RoundCompleted;
use App\Events\RoundStarted;
use App\Models\Game;
use App\Models\Guess;
use App\Models\Place;
use App\Models\Player;
use App\Models\Round;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GameController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20|min:1',
            'settings' => 'nullable|array',
            'settings.difficulty' => ['nullable', Rule::enum(Difficulty::class)],
            'settings.rounds' => ['nullable', Rule::enum(Round::class)],
            'settings.gameTypes' => 'nullable|array',
            'settings.gameTypes.*' => [Rule::enum(PlaceType::class)],
            'settings.timerEnabled' => 'nullable|boolean',
            'settings.timerDuration' => ['nullable', Rule::enum(TimeDuration::class)],
            'settings.showLabels' => 'nullable|boolean',
        ]);

        $code = Game::generateUniqueCode();

        // Use provided settings or defaults
        $settings = $validated['settings'] ?? [];
        $gameSettings = [
            'difficulty' => Difficulty::tryFrom($settings['difficulty'])?->value ?? Difficulty::Medium->value,
            'rounds' => NumRound::tryFrom($settings['rounds'])?->value ?? NumRound::Ten->value,
            'gameTypes' => $settings['gameTypes'] ?? [PlaceType::Mixed->value],
            'timerEnabled' => $settings['timerEnabled'] ?? true,
            'timerDuration' => TimeDuration::tryFrom($settings['timerDuration'])?->value ?? TimeDuration::ThirtySeconds->value,
            'showLabels' => $settings['showLabels'] ?? false,
        ];

        $game = Game::query()->create([
            'code' => $code,
            'settings' => $gameSettings,
            'status' => 'waiting',
        ]);

        $player = Player::query()->create([
            'game_id' => $game->id,
            'name' => $validated['name'],
            'color' => Player::getNextAvailableColor($game),
            'total_score' => 0,
            'is_host' => true,
            'connected' => true,
        ]);

        broadcast(new PlayerJoined($game, $player));

        return response()->json([
            'success' => true,
            'game' => [
                'id' => $game->id,
                'code' => $game->code,
                'status' => $game->status,
            ],
            'player' => [
                'id' => $player->id,
                'name' => $player->name,
                'color' => $player->color,
                'is_host' => $player->is_host,
            ],
        ], 201);
    }

    public function join(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20|min:1',
            'code' => 'required|string|size:6',
        ]);

        $game = Game::query()
            ->where('code', strtoupper($validated['code']))
            ->first();

        if (! $game) {
            throw ValidationException::withMessages([
                'code' => ['Spelkoden finns inte. Kontrollera och försök igen.'],
            ]);
        }

        if ($game->status !== 'waiting') {
            throw ValidationException::withMessages([
                'code' => ['Detta spel har redan startat eller är avslutat.'],
            ]);
        }

        if ($game->players()->count() >= 6) {
            throw ValidationException::withMessages([
                'code' => ['Detta spel är fullt. Max 6 spelare.'],
            ]);
        }

        $player = Player::query()->create([
            'game_id' => $game->id,
            'name' => $validated['name'],
            'color' => Player::getNextAvailableColor($game),
            'total_score' => 0,
            'is_host' => false,
            'connected' => true,
        ]);

        broadcast(new PlayerJoined($game, $player));

        return response()->json([
            'success' => true,
            'game' => [
                'id' => $game->id,
                'code' => $game->code,
                'status' => $game->status,
            ],
            'player' => [
                'id' => $player->id,
                'name' => $player->name,
                'color' => $player->color,
                'is_host' => $player->is_host,
            ],
        ], 200);
    }

    public function players(string $code): JsonResponse
    {
        $game = Game::query()
            ->where('code', strtoupper($code))
            ->with('players')
            ->first();

        if (! $game) {
            return response()->json([
                'error' => 'Spelet finns inte',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'game' => [
                'id' => $game->id,
                'code' => $game->code,
                'status' => $game->status,
            ],
            'players' => $game->players->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'color' => $p->color,
                'is_host' => $p->is_host,
                'connected' => $p->connected,
            ]),
        ]);
    }

    public function start(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6',
            'player_id' => 'required|integer|exists:players,id',
        ]);

        $game = Game::query()
            ->where('code', strtoupper($validated['code']))
            ->with('players')
            ->first();

        if (! $game) {
            throw ValidationException::withMessages([
                'code' => ['Spelet finns inte.'],
            ]);
        }

        // Verify the player is the host
        $player = Player::query()->find($validated['player_id']);
        if (! $player || $player->game_id !== $game->id || ! $player->is_host) {
            throw ValidationException::withMessages([
                'player_id' => ['Endast värden kan starta spelet.'],
            ]);
        }

        // Check game is in waiting status
        if ($game->status !== 'waiting') {
            throw ValidationException::withMessages([
                'code' => ['Spelet har redan startat eller är avslutat.'],
            ]);
        }

        // Require at least 2 players
        if ($game->players()->count() < 2) {
            throw ValidationException::withMessages([
                'code' => ['Minst 2 spelare krävs för att starta spelet.'],
            ]);
        }

        // Update game status
        $game->update(['status' => 'playing']);

        // Broadcast GameStarted event
        broadcast(new GameStarted($game));

        // Create first round with a place based on game settings
        $placeData = $this->getNextPlace(1, $game);

        $round = Round::query()->create([
            'game_id' => $game->id,
            'round_number' => 1,
            'place_data' => $placeData,
            'started_at' => now(),
        ]);

        // Broadcast RoundStarted event
        broadcast(new RoundStarted($game, $round));

        return response()->json([
            'success' => true,
            'game' => [
                'id' => $game->id,
                'code' => $game->code,
                'status' => $game->status,
            ],
            'round' => [
                'id' => $round->id,
                'number' => $round->round_number,
            ],
            'message' => 'Spelet startar!',
        ]);
    }

    public function submitGuess(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'round_id' => 'required|integer|exists:rounds,id',
            'player_id' => 'required|integer|exists:players,id',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
        ]);

        $round = Round::query()->with('game.players')->findOrFail($validated['round_id']);
        $player = Player::query()->findOrFail($validated['player_id']);

        // Verify player belongs to this game
        if ($player->game_id !== $round->game_id) {
            throw ValidationException::withMessages([
                'player_id' => ['Spelaren tillhör inte detta spel.'],
            ]);
        }

        // Check if player has already guessed in this round
        $existingGuess = Guess::query()
            ->where('round_id', $round->id)
            ->where('player_id', $player->id)
            ->first();

        if ($existingGuess) {
            throw ValidationException::withMessages([
                'round_id' => ['Du har redan gissat i denna runda.'],
            ]);
        }

        // Get place data (needed for both timeout and normal guesses)
        $placeLat = (float) $round->place_data['lat'];
        $placeLng = (float) $round->place_data['lng'];
        $placeSize = (float) ($round->place_data['size'] ?? 0);

        // Handle timeout (null coordinates)
        if ($validated['lat'] === null || $validated['lng'] === null) {
            $distance = PHP_FLOAT_MAX; // Infinite distance
            $score = 0;
        } else {
            // Calculate distance using Haversine formula
            $distance = $this->calculateDistance(
                $validated['lat'],
                $validated['lng'],
                $placeLat,
                $placeLng
            );

            // Calculate score based on distance
            $score = $this->calculateScore($distance, $placeSize);
        }

        // Log for debugging
        \Log::info('Guess submitted', [
            'player_id' => $player->id,
            'guess_lat' => $validated['lat'],
            'guess_lng' => $validated['lng'],
            'place_lat' => $placeLat,
            'place_lng' => $placeLng,
            'place_size' => $placeSize,
            'distance' => $distance,
            'score' => $score,
        ]);

        // Create guess
        $guess = Guess::query()->create([
            'round_id' => $round->id,
            'player_id' => $player->id,
            'lat' => $validated['lat'] ?? 0, // Default to 0 for timeout
            'lng' => $validated['lng'] ?? 0,
            'distance' => $distance,
            'score' => $score,
            'guessed_at' => now(),
        ]);

        // Update player total score
        $player->increment('total_score', $score);

        // Broadcast GuessSubmitted event
        broadcast(new GuessSubmitted($round->game, $player, $guess));

        // Check if all players have guessed
        $totalPlayers = $round->game->players()->count();
        $totalGuesses = $round->guesses()->count();

        if ($totalGuesses >= $totalPlayers) {
            // Round is complete
            $round->update(['completed_at' => now()]);

            // Refresh game and players to get updated scores
            $round->game->refresh();
            $round->game->load('players');

            broadcast(new RoundCompleted($round->game, $round));
        }

        return response()->json([
            'success' => true,
            'guess' => [
                'id' => $guess->id,
                'distance' => $guess->distance,
                'score' => $guess->score,
            ],
            'round_complete' => $totalGuesses >= $totalPlayers,
        ]);
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

    private function calculateScore(float $distance, float $placeSize): int
    {
        // Adjust distance by place size (radius)
        $adjustedDistance = max(0, $distance - $placeSize);

        // Distance thresholds in km for scoring
        $thresholds = [
            50 => 10,
            200 => 9,
            500 => 8,
            750 => 7,
            1000 => 6,
            1500 => 5,
            2000 => 4,
            3000 => 3,
            5000 => 2,
            10000 => 1,
        ];

        foreach ($thresholds as $threshold => $points) {
            if ($adjustedDistance < $threshold) {
                return $points;
            }
        }

        return 0;
    }

    public function nextRound(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'player_id' => 'required|integer|exists:players,id',
        ]);

        $game = Game::query()->with('players', 'rounds')->findOrFail($validated['game_id']);
        $player = Player::query()->findOrFail($validated['player_id']);

        // Verify player belongs to this game
        if ($player->game_id !== $game->id) {
            throw ValidationException::withMessages([
                'player_id' => ['Spelaren tillhör inte detta spel.'],
            ]);
        }

        // Check game is still playing
        if ($game->status !== 'playing') {
            throw ValidationException::withMessages([
                'game_id' => ['Spelet är inte aktivt.'],
            ]);
        }

        // Get current round number
        $currentRoundNumber = $game->rounds()->max('round_number') ?? 0;
        $nextRoundNumber = $currentRoundNumber + 1;
        $totalRounds = $game->settings['rounds'] ?? 10;

        // Check if game is complete
        if ($nextRoundNumber > $totalRounds) {
            // Game is complete - determine winner
            $winner = $game->players()->orderBy('total_score', 'desc')->first();

            $game->update([
                'status' => 'finished',
                'winner_id' => $winner?->id,
            ]);

            broadcast(new GameCompleted($game));

            return response()->json([
                'success' => true,
                'game_complete' => true,
                'winner' => $winner ? [
                    'id' => $winner->id,
                    'name' => $winner->name,
                    'total_score' => $winner->total_score,
                ] : null,
            ]);
        }

        // Create next round with a new place
        $placeData = $this->getNextPlace($nextRoundNumber, $game);

        $round = Round::query()->create([
            'game_id' => $game->id,
            'round_number' => $nextRoundNumber,
            'place_data' => $placeData,
            'started_at' => now(),
        ]);

        // Broadcast RoundStarted event
        broadcast(new RoundStarted($game, $round));

        return response()->json([
            'success' => true,
            'game_complete' => false,
            'round' => [
                'id' => $round->id,
                'number' => $round->round_number,
            ],
        ]);
    }

    public function getPlaces(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'difficulty' => ['required', Rule::enum(Difficulty::class)],
            'gameTypes' => ['required', 'array'],
            'gameTypes.*' => [Rule::enum(PlaceType::class)],
        ]);

        $difficulty = $validated['difficulty'];
        $placeTypes = $validated['gameTypes'];

        // Build query based on settings
        $query = Place::query()->difficulty($difficulty);

        // Filter by game types
        // If 'mixed' is selected, include all types
        if (in_array(PlaceType::Mixed->value, $placeTypes)) {
            $placeTypes = PlaceType::regularTypesValues();
        }

        $query->types($placeTypes);

        $places = $query->get(['name', 'lat', 'lng', 'type', 'size']);

        return response()->json([
            'success' => true,
            'places' => $places,
            'count' => $places->count(),
        ]);
    }

    private function getNextPlace(int $roundNumber, Game $game): array
    {
        $settings = $game->settings;
        $difficulty = $settings['difficulty'] ?? 'medium';
        $gameTypes = $settings['gameTypes'] ?? ['blandat'];

        // Build query based on game settings
        $query = Place::query()->difficulty($difficulty);

        // Filter by game types
        // If 'blandat' is selected, include all types
        if (! in_array('blandat', $gameTypes)) {
            // Map game types to place types
            $placeTypes = [];
            foreach ($gameTypes as $gameType) {
                match ($gameType) {
                    'land' => $placeTypes[] = 'land',
                    'stad' => $placeTypes[] = 'stad',
                    default => null,
                };
            }

            if (! empty($placeTypes)) {
                $query->types($placeTypes);
            }
        }

        // Get all matching places
        $places = $query->get();

        if ($places->isEmpty()) {
            // Fallback to any place if no matches
            $places = Place::query()->limit(50)->get();
        }

        // Convert to array for shuffling
        $placesArray = $places->toArray();

        // Shuffle and pick one
        shuffle($placesArray);
        $selectedPlace = $placesArray[0];

        // Return in the format expected by the round
        return [
            'name' => $selectedPlace['name'],
            'lat' => (float) $selectedPlace['lat'],
            'lng' => (float) $selectedPlace['lng'],
            'type' => $selectedPlace['type'],
            'size' => (int) $selectedPlace['size'],
        ];
    }
}
