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
        Schema::create('tour_places', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('place_id')->constrained('places')->onDelete('cascade'); // FK place_id
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade'); // FK tour_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_places');
    }
};
