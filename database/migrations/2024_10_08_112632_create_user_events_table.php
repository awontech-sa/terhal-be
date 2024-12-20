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
        Schema::create('user_events', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade'); // FK event_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK user_id
            $table->text('ue_comment')->nullable(true)->comment('User comment on the event');
            $table->decimal('ue_rate', 3, 2)->nullable(true)->comment('User rating for the event')->default(0);
            $table->boolean('is_favorite')->default(false)->comment('Is event marked as favorite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_events');
    }
};
