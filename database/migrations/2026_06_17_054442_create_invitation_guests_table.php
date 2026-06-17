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
        Schema::create('invitation_guests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invitation_id');
            $table->string('name')->nullable();
            $table->enum('status', ['hadir', 'mungkin', 'tidak_hadir'])->default('hadir');
            $table->boolean('is_location_shared')->default(false);
            $table->timestamps();

            $table->foreign('invitation_id')->references('id')->on('invitations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_guests');
    }
};
