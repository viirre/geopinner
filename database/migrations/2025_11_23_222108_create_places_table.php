<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->string('type'); // stad, land, ö, plats, vin, docg, aoc
            $table->integer('size'); // radius in km
            $table->json('difficulty'); // array of: easy, medium, hard
            $table->boolean('capital')->nullable(); // for cities
            $table->timestamps();

            // Indexes for faster queries
            $table->index('type');
            $table->index('difficulty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
