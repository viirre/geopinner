<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameCompleted implements ShouldBroadcastNow
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
        // Get final rankings
        $players = $this->game->players()
            ->orderBy('total_score', 'desc')
            ->get()
            ->map(fn($p, $index) => [
                'id' => $p->id,
                'name' => $p->name,
                'color' => $p->color,
                'total_score' => $p->total_score,
                'position' => $index + 1,
            ]);

        $winner = $this->game->winner;

        return [
            'game' => [
                'id' => $this->game->id,
                'code' => $this->game->code,
                'status' => $this->game->status,
            ],
            'winner' => $winner ? [
                'id' => $winner->id,
                'name' => $winner->name,
                'color' => $winner->color,
                'total_score' => $winner->total_score,
            ] : null,
            'players' => $players,
            'total_rounds' => $this->game->rounds()->count(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'GameCompleted';
    }
}
