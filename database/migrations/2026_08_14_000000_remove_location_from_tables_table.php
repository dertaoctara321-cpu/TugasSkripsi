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
        Schema::table('tables', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('tables', 'location_lat')) {
                $columnsToDrop[] = 'location_lat';
            }
            if (Schema::hasColumn('tables', 'location_lng')) {
                $columnsToDrop[] = 'location_lng';
            }
            if (Schema::hasColumn('tables', 'location_radius')) {
                $columnsToDrop[] = 'location_radius';
            }
            if (Schema::hasColumn('tables', 'require_location')) {
                $columnsToDrop[] = 'require_location';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->decimal('location_lat', 10, 8)->nullable();
            $table->decimal('location_lng', 11, 8)->nullable();
            $table->integer('location_radius')->default(10);
            $table->boolean('require_location')->default(true);
        });
    }
};
