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
        Schema::create('game_worlds', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('world_name'); // Name of the game world
            $table->string('world_url'); // URL to access the game world
            $table->string('type'); // Type of the world (e.g., Free, Members)
            $table->unsignedInteger('population')->nullable(); // Population of the world
            $table->string('country')->nullable(); // Country of the world
            $table->string('activity')->nullable(); // Activity (e.g., PvP Arena)
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }
};
