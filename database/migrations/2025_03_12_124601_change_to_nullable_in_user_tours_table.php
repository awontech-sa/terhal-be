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
        Schema::table('user_tours', function (Blueprint $table) {
            $table->text('ut_comment')->nullable(true)->comment('User comment on the tour')->change();
            $table->decimal('ut_rate', 3, 2)->nullable(true)->comment('User rating for the tour')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tours', function (Blueprint $table) {
            //
        });
    }
};
