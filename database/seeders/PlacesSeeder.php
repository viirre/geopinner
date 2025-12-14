<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlacesSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/places-data.json');

        if (! file_exists($jsonPath)) {
            $this->command->error('places-data.json not found. Run: node export-places.mjs');

            return;
        }

        $placesData = json_decode(file_get_contents($jsonPath), true);

        if (! $placesData) {
            $this->command->error('Failed to parse places-data.json');

            return;
        }

        $this->command->info('Seeding '.(is_countable($placesData) ? count($placesData) : 0).' places...');

        // Truncate existing places
        Place::query()->truncate();

        // Insert places in chunks for better performance
        $chunks = array_chunk($placesData, 100);
        $progressBar = $this->command->getOutput()->createProgressBar(count($chunks));
        $progressBar->start();

        foreach ($chunks as $chunk) {
            $records = array_map(function ($place) {
                return [
                    'name' => $place['name'],
                    'lat' => $place['lat'],
                    'lng' => $place['lng'],
                    'type' => $place['type'],
                    'size' => $place['size'],
                    'difficulty' => json_encode($place['difficulty']),
                    'capital' => $place['capital'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $chunk);

            Place::query()->insert($records);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->newLine();
        $this->command->info('✓ Successfully seeded '.(is_countable($placesData) ? count($placesData) : 0).' places');
    }
}
