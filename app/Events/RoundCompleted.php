<?php

namespace App\Events;

use App\Models\Game;
use App\Models\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoundCompleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Game $game,
        public Round $round
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
        $guesses = $this->round->guesses()
            ->with('player')
            ->get()
            ->sortByDesc('score') // Sort by score descending so winner is first
            ->values() // Re-index array after sorting
            ->map(fn($guess) => [
                'player' => [
                    'id' => $guess->player->id,
                    'name' => $guess->player->name,
                    'color' => $guess->player->color,
                ],
                'lat' => $guess->lat,
                'lng' => $guess->lng,
                'distance' => $guess->distance,
                'score' => $guess->score,
            ]);

        return [
            'round' => [
                'id' => $this->round->id,
                'number' => $this->round->round_number,
                'place' => $this->round->place_data,
                'completed_at' => $this->round->completed_at,
            ],
            'guesses' => $guesses,
            'players' => $this->game->players->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'color' => $p->color,
                'total_score' => $p->total_score,
            ]),
        ];
    }

    public function broadcastAs(): string
    {
        return 'RoundCompleted';
    }
}
