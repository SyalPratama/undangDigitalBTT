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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('package_id')->nullable()->after('email');
            
            // Because SQLite in tests might complain about dropping columns, we wrap it
            if (Schema::hasColumn('users', 'active_package')) {
                $table->dropColumn('active_package');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('package_id');
            $table->string('active_package')->nullable()->after('email');
        });
    }
};
