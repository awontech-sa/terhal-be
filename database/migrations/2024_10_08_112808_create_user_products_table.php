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
        Schema::create('user_products', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // FK product_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK user_id
            $table->text('up_comment')->nullable(false)->comment('User comment on the product');
            $table->decimal('up_rate', 3, 2)->nullable(false)->comment('User rating for the product');
            $table->boolean('is_favorite')->default(false)->comment('Is product marked as favorite');
            $table->boolean('is_buy')->default(false)->comment('Has the user bought the product');
            $table->enum('up_status', ['مراجعة الطلب', 'ملغي', 'قيد التنفيذ', 'جاري التوصيل', 'تم التوصيل'])->default('مراجعة الطلب')->comment('Status of the user product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_products');
    }
};
