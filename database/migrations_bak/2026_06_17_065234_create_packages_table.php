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
        Schema::create('packages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('active_days')->default(30);
            $table->boolean('is_premium_template_access')->default(false);
            $table->boolean('has_rsvp')->default(false);
            $table->boolean('has_rsvp_stats')->default(false);
            $table->boolean('has_realtime_tracking')->default(false);
            $table->boolean('has_opened_list')->default(false);
            $table->boolean('has_monitoring_dashboard')->default(false);
            $table->json('features_json')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
