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
        Schema::create('user_tours', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade'); // FK tour_id
            $table->foreignId('user_id')->comment('the user who booked the tour')->constrained('users')->onDelete('cascade'); // FK user_id
            $table->text('ut_comment')->nullable(false)->comment('User comment on the tour');
            $table->decimal('ut_rate', 3, 2)->nullable(false)->comment('User rating for the tour');
            $table->boolean('is_favorite')->default(false)->comment('Is tour marked as favorite');
            $table->boolean('is_added')->default(false)->comment('Has the user added the tour to their list');
            $table->enum('ut_status', ['تم الحجز', 'ملغية', 'استعد لرحلتك', 'اليوم رحلتك', 'انتهت رحلتك'])->default('تم الحجز')->comment('Tour status for the user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tours');
    }
};
