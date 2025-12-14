<?php

namespace App\Livewire;

use App\Enums\Difficulty;
use App\Enums\NumRound;
use App\Enums\PlaceType;
use App\Enums\TimeDuration;
use App\Events\GameStarted;
use App\Events\PlayerJoined;
use App\Events\RoundStarted;
use App\Models\Player;
use App\Models\Round;
use App\Services\PlaceService;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Multiplayer extends Component
{
    // Screen state
    public string $screen = 'lobby'; // lobby, waiting, game, result

    // Lobby form - Create Game
    public string $hostName = '';

    public string $difficulty = 'medium';

    public array $gameTypes = ['mixed'];

    public int $rounds = 10;

    public int $timerDuration = 10;

    public bool $showLabels = false;

    // Lobby form - Join Game
    public string $playerName = '';

    public string $gameCode = '';

    // Game session data
    public ?string $sessionGameCode = null;

    public ?int $sessionGameId = null;

    public ?int $sessionPlayerId = null;

    public ?string $sessionPlayerName = null;

    public ?string $sessionPlayerColor = null;

    public bool $isHost = false;

    // Waiting room
    public array $players = [];

    // Game state
    public int $currentRound = 0;

    public int $totalRounds = 0;

    public ?array $currentPlace = null;

    public bool $hasGuessed = false;

    public bool $showingRoundResults = false;

    public array $roundHistory = [];

    public function mount(): void
    {
        // Check if user has active session
        // (could restore from session storage via Alpine)
    }

    public function toggleGameType(string $type): void
    {
        // Same logic as Game component
        if ($type === PlaceType::Mixed->value) {
            $this->gameTypes = [PlaceType::Mixed->value];

            return;
        }

        $this->gameTypes = array_values(array_diff($this->gameTypes, [PlaceType::Mixed->value]));

        if (in_array($type, $this->gameTypes)) {
            $this->gameTypes = array_values(array_diff($this->gameTypes, [$type]));
        } else {
            $this->gameTypes[] = $type;
        }

        if (empty($this->gameTypes)) {
            $this->gameTypes = [PlaceType::Mixed->value];
        }
    }

    public function createGame(): void
    {
        $this->validate([
            'hostName' => 'required|string|max:20',
            'difficulty' => ['required', Rule::enum(Difficulty::class)],
            'rounds' => ['required', 'integer', Rule::enum(NumRound::class)],
            'gameTypes' => 'required|array|min:1',
            'timerDuration' => ['required', 'integer', 'int', 'min:5', 'max:60'],
        ]);

        // Generate unique game code
        $code = \App\Models\Game::generateUniqueCode();

        // Create game
        $game = \App\Models\Game::create([
            'code' => $code,
            'settings' => [
                'difficulty' => $this->difficulty,
                'rounds' => $this->rounds,
                'gameTypes' => $this->gameTypes,
                'timerEnabled' => true,
                'timerDuration' => $this->timerDuration,
                'showLabels' => $this->showLabels,
            ],
            'status' => 'waiting',
        ]);

        // Create host player
        $player = Player::create([
            'game_id' => $game->id,
            'name' => $this->hostName,
            'color' => Player::getNextAvailableColor($game),
            'total_score' => 0,
            'is_host' => true,
            'connected' => true,
        ]);

        // Broadcast player joined event
        broadcast(new PlayerJoined($game, $player));

        // Set session data
        $this->sessionGameCode = $game->code;
        $this->sessionGameId = $game->id;
        $this->sessionPlayerId = $player->id;
        $this->sessionPlayerName = $player->name;
        $this->sessionPlayerColor = $player->color;
        $this->isHost = true;

        // Load players
        $this->loadPlayers();

        // Transition to waiting room
        $this->screen = 'waiting';

        // Notify Alpine to subscribe to Echo channel
        $this->dispatch('subscribe-to-game', gameCode: $game->code);
    }

    public function joinGame(): void
    {
        $this->validate([
            'playerName' => 'required|string|max:20',
            'gameCode' => 'required|string|size:6',
        ]);

        // Find game
        $game = \App\Models\Game::where('code', strtoupper($this->gameCode))->first();

        if (! $game) {
            $this->addError('gameCode', 'Spelkoden finns inte. Kontrollera och försök igen.');

            return;
        }

        if ($game->status !== 'waiting') {
            $this->addError('gameCode', 'Detta spel har redan startat.');

            return;
        }

        // Check player limit
        if ($game->players()->count() >= 6) {
            $this->addError('gameCode', 'Spelet är fullt (max 6 spelare).');

            return;
        }

        // Create player
        $player = Player::create([
            'game_id' => $game->id,
            'name' => $this->playerName,
            'color' => Player::getNextAvailableColor($game),
            'total_score' => 0,
            'is_host' => false,
            'connected' => true,
        ]);

        // Broadcast player joined event
        broadcast(new PlayerJoined($game, $player));

        // Set session data
        $this->sessionGameCode = $game->code;
        $this->sessionGameId = $game->id;
        $this->sessionPlayerId = $player->id;
        $this->sessionPlayerName = $player->name;
        $this->sessionPlayerColor = $player->color;
        $this->isHost = false;

        // Load players
        $this->loadPlayers();

        // Transition to waiting room
        $this->screen = 'waiting';

        // Notify Alpine to subscribe to Echo channel
        $this->dispatch('subscribe-to-game', gameCode: $game->code);
    }

    public function loadPlayers(): void
    {
        $game = \App\Models\Game::find($this->sessionGameId);
        if ($game) {
            $this->players = $game->players()
                ->orderBy('created_at')
                ->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'color' => $p->color,
                    'is_host' => $p->is_host,
                    'total_score' => $p->total_score,
                ])
                ->toArray();
        }
    }

    public function setGameSession(string $gameCode, int $gameId, int $playerId, string $playerName, string $playerColor, bool $isHost): void
    {
        $this->sessionGameCode = $gameCode;
        $this->sessionGameId = $gameId;
        $this->sessionPlayerId = $playerId;
        $this->sessionPlayerName = $playerName;
        $this->sessionPlayerColor = $playerColor;
        $this->isHost = $isHost;

        $this->screen = 'waiting';
    }

    public function setPlayers(array $players): void
    {
        $this->players = $players;
    }

    public function startGame(): void
    {
        if (! $this->isHost) {
            return;
        }

        $game = \App\Models\Game::find($this->sessionGameId);
        if (! $game || $game->status !== 'waiting') {
            return;
        }

        // Check minimum players (at least 2)
        if ($game->players()->count() < 2) {
            $this->addError('start', 'Minst 2 spelare krävs för att starta spelet.');

            return;
        }

        // Update game status
        $game->update(['status' => 'playing']);

        // Broadcast game started event
        broadcast(new GameStarted($game));

        // Create first round
        $placeService = app(PlaceService::class);
        $settings = $game->settings;
        $places = $placeService->getPlaces($settings['difficulty'], $settings['gameTypes']);
        $shuffled = $places->shuffle();
        $placeModel = $shuffled->first();

        if ($placeModel) {
            $placeData = [
                'name' => $placeModel->name,
                'lat' => $placeModel->lat,
                'lng' => $placeModel->lng,
                'type' => $placeModel->type,
                'size' => $placeModel->size,
            ];

            $round = Round::create([
                'game_id' => $game->id,
                'round_number' => 1,
                'place_data' => $placeData,
                'started_at' => now(),
            ]);

            // Broadcast RoundStarted event
            broadcast(new RoundStarted($game, $round));
        }
    }

    public function startRound(array $roundData, array $gameData): void
    {
        $this->screen = 'game';
        $this->currentRound = $roundData['number'];
        $this->totalRounds = $gameData['total_rounds'];
        $this->currentPlace = $roundData['place'];
        $this->currentPlace['round_id'] = $roundData['id']; // Add round_id for guess submission
        $this->hasGuessed = false;
        $this->showingRoundResults = false;

        $this->dispatch('round-started-mp');
    }

    public function submitGuess(float $lat, float $lng): void
    {
        if ($this->hasGuessed) {
            return;
        }

        $this->hasGuessed = true;

        // Dispatch to Alpine to handle via API
        $this->dispatch('submit-mp-guess',
            round_id: $this->currentPlace['round_id'] ?? null,
            player_id: $this->sessionPlayerId,
            lat: $lat,
            lng: $lng
        );
    }

    public function handleTimeout(): void
    {
        if ($this->hasGuessed || ! $this->currentPlace) {
            return;
        }

        $this->hasGuessed = true;

        // Submit timeout guess (no coordinates = 0 points)
        // The server will handle this as a timeout
        $this->dispatch('submit-mp-timeout',
            round_id: $this->currentPlace['round_id'] ?? null,
            player_id: $this->sessionPlayerId
        );
    }

    public function showRoundResults(array $data): void
    {
        // Update round history
        $this->roundHistory[] = $data;

        // Show round results UI
        $this->showingRoundResults = true;

        // Dispatch to Alpine to show markers (spread to avoid array wrapping in Livewire v3)
        $this->dispatch('show-mp-round-results', ...$data);
    }

    public function nextRound(): void
    {
        // Dispatch to Alpine to call API
        $this->dispatch('next-mp-round',
            game_id: $this->sessionGameId,
            player_id: $this->sessionPlayerId
        );
    }

    public function showWinner(array $data): void
    {
        // Update players with final scores from GameCompleted event
        if (isset($data['players'])) {
            $this->players = $data['players'];
        }

        $this->screen = 'result';

        // Dispatch event in case any Alpine components need to react
        $this->dispatch('show-mp-winner', ...$data);
    }

    public function render()
    {
        return view('livewire.multiplayer')->layout('layouts.app');
    }
}
