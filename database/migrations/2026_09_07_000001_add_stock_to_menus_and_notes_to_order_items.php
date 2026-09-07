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
        if (Schema::hasTable('menus') && !Schema::hasColumn('menus', 'stock')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->integer('stock')->default(20)->after('price');
            });
        }

        if (Schema::hasTable('order_items') && !Schema::hasColumn('order_items', 'notes')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->text('notes')->nullable()->after('price');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('menus') && Schema::hasColumn('menus', 'stock')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->dropColumn('stock');
            });
        }

        if (Schema::hasTable('order_items') && Schema::hasColumn('order_items', 'notes')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('notes');
            });
        }
    }
};
