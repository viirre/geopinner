<?php

namespace App\Events;

use App\Models\Game;
use App\Models\Guess;
use App\Models\Player;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GuessSubmitted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Game $game,
        public Player $player,
        public Guess $guess
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('game.' . $this->game->code),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'player' => [
                'id' => $this->player->id,
                'name' => $this->player->name,
            ],
            'guesses_count' => $this->guess->round->guesses()->count(),
            'total_players' => $this->game->players()->count(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'GuessSubmitted';
    }
}
