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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('table_id')->constrained('tables')->onDelete('cascade');
            $table->string('customer_name')->nullable();
            $table->string('waiter_name')->nullable();
            $table->unsignedTinyInteger('food_rating')->default(5); // 1-5 bintang
            $table->unsignedTinyInteger('table_rating')->default(5); // 1-5 bintang kenyamanan meja
            $table->unsignedTinyInteger('waiter_rating')->nullable()->default(5); // 1-5 bintang pelayanan waiter
            $table->boolean('is_favorite_table')->default(false);
            $table->text('review')->nullable(); // Ulasan umum / makanan
            $table->text('waiter_review')->nullable(); // Ulasan khusus waiter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
