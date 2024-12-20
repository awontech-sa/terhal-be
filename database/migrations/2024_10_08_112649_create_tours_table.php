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
        Schema::create('tours', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK user_id
            $table->string('t_name')->nullable(false)->comment('Tour name');
            $table->text('t_description')->nullable(false)->comment('Tour description');
            $table->json('t_image')->nullable(false)->comment('Tour image in JSON format');
            $table->decimal('t_rate', 3, 2)->nullable(true)->comment('Tour rating')->default(0);
            $table->dateTime('t_date')->nullable(false)->comment('Tour date and time');
            $table->decimal('t_price', 8, 2)->nullable(false)->comment('Tour price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
