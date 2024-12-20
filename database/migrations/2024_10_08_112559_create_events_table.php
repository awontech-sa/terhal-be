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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Primary Key: id
            $table->foreignId('user_id')->comment('Foreign Key: for event owner')->constrained('users')->onDelete('cascade'); // Foreign Key: user_id
            $table->foreignId('event_type_id')->comment('Foreign Key: for event type')->constrained('event_types')->onDelete('cascade'); // Foreign Key: event_type_id
            $table->string('e_name')->nullable(false)->comment('Event name');
            $table->json('e_images')->nullable(true)->comment('Event images in JSON format');
            $table->string('e_location')->nullable(false)->comment('Event location');
            $table->decimal('e_price', 8, 2)->nullable(false)->comment('Event price');
            $table->text('e_description')->nullable(false)->comment('Event description');
            $table->dateTime('e_date')->nullable(false)->comment('Event date and time');
            $table->decimal('e_rate', 3, 2)->nullable(false)->default(0)->comment('Event rating');
            $table->json('e_videos')->nullable(true)->comment('Event videos in JSON format');
            $table->timestamps(); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
