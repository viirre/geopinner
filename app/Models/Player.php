<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        'game_id',
        'name',
        'color',
        'total_score',
        'is_host',
        'connected',
    ];

    protected function casts(): array
    {
        return [
            'is_host' => 'boolean',
            'connected' => 'boolean',
            'total_score' => 'integer',
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function guesses(): HasMany
    {
        return $this->hasMany(Guess::class);
    }

    public static function getAvailableColors(): array
    {
        return [
            '#ef4444', // red
            '#3b82f6', // blue
            '#10b981', // green
            '#f59e0b', // amber
            '#8b5cf6', // violet
            '#ec4899', // pink
        ];
    }

    public static function getNextAvailableColor(Game $game): string
    {
        $usedColors = $game->players()->pluck('color')->toArray();
        $availableColors = collect(static::getAvailableColors())
            ->diff($usedColors)
            ->values();

        return $availableColors->first() ?? static::getAvailableColors()[0];
    }
}
