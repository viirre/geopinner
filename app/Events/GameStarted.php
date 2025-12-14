<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameStarted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Game $game
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
            'game' => [
                'id' => $this->game->id,
                'code' => $this->game->code,
                'status' => $this->game->status,
            ],
            'message' => 'Spelet startar nu!',
        ];
    }

    public function broadcastAs(): string
    {
        return 'GameStarted';
    }
}
