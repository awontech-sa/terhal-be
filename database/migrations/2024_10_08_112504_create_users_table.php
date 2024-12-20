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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('user_type_id')->constrained('user_types')->onDelete('cascade'); // FK user_type_id
            $table->string('name')->nullable(false)->comment('User full name');
            $table->string('email')->unique()->nullable(false);
            $table->string('phone')->nullable(false);
            $table->string('password')->nullable(false);
            $table->enum('status', ['نشط', 'غير نشط','محظور'])->default('نشط')->comment('User account status');
            $table->integer('age')->unsigned()->nullable(false);
            $table->enum('gender', ['ذكر', 'أنثى'])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
