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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('user_id')->nullable()->comment('Receiver User')->constrained('users')->onDelete('cascade'); // FK user_id
            $table->string('n_title')->nullable(false)->comment('Notification title');
            $table->text('n_message')->nullable(false)->comment('Notification message');
            $table->enum('n_type', ['عام', 'جولة', 'متجر','حدث'])->comment('Notification type');
            $table->boolean('is_read')->default(false)->comment('Has the notification been read');
            $table->enum('role_target', ['الكل', 'مرشد', 'سائح','متجر'])->comment('Role target of the notification');
            $table->timestamp('sent_at')->nullable()->comment('Notification sent timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
