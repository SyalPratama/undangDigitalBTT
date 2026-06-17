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
        Schema::create('invitation_builders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('invitation_id');

            $table->longText('html')->nullable();
            $table->longText('css')->nullable();
            $table->json('project_data')->nullable();

            $table->timestamps();

            $table->foreign('invitation_id')
                ->references('id')
                ->on('invitations')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_builders');
    }
};
