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
            $table->integer('ut_count')->nullable();
            $table->decimal('ut_total_price')->nullable();
            $table->string('ut_uuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tours', function (Blueprint $table) {
            $table->dropColumn('ut_count');
            $table->dropColumn('ut_total_price');
            $table->dropColumn('ut_uuid');
        });
    }
};
