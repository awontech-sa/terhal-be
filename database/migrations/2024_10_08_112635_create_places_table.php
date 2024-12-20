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
            $table->id(); // PK id
            $table->string('p_name')->nullable(false)->comment('Place name');
            $table->decimal('p_lang', 10, 7)->nullable(false)->comment('Place longitude');
            $table->decimal('p_lat', 10, 7)->nullable(false)->comment('Place latitude');
            $table->timestamps();
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
