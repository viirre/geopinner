<?php

namespace App\Models;

use App\Enums\Difficulty;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'name',
        'lat',
        'lng',
        'type',
        'size',
        'difficulty',
        'capital',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'decimal:6',
            'lng' => 'decimal:6',
            'size' => 'integer',
            'difficulty' => 'array',
            'capital' => 'boolean',
        ];
    }

    /**
     * Scope to filter places by difficulty
     */
    public function scopeDifficulty($query, string|Difficulty $difficulty)
    {
        return $query->whereJsonContains('difficulty', $difficulty);
    }

    /**
     * Scope to filter places by type
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter places by multiple types
     */
    public function scopeTypes($query, array $types)
    {
        return $query->whereIn('type', $types);
    }
}
