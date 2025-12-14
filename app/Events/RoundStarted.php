<?php

namespace App\Events;

use App\Models\Game;
use App\Models\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoundStarted implements ShouldBroadcastNow
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
        return [
            'round' => [
                'id' => $this->round->id,
                'number' => $this->round->round_number,
                'place' => $this->round->place_data,
                'started_at' => $this->round->started_at,
            ],
            'game' => [
                'id' => $this->game->id,
                'total_rounds' => $this->game->settings['rounds'] ?? 10,
                'timer_duration' => $this->game->settings['timerDuration'] ?? 30,
                'show_labels' => $this->game->settings['showLabels'] ?? false,
            ],
        ];
    }

    public function broadcastAs(): string
    {
        return 'RoundStarted';
    }
}
