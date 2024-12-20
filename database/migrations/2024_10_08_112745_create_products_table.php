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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // PK id
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade'); // FK product_type_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK user_id
            $table->json('pr_images')->nullable(false)->comment('Product images in JSON format');
            $table->json('pr_videos')->nullable(true)->comment('Product videos in JSON format');
            $table->string('pr_name')->nullable(false)->comment('Product name');
            $table->decimal('pr_price', 8, 2)->nullable(false)->comment('Product price');
            $table->decimal('pr_rates', 3, 2)->nullable(false)->default(0)->comment('Product rating');
            $table->text('pr_description')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
