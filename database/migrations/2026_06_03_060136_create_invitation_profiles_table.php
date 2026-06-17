<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('invitation_id')
                ->unique()
                ->constrained('invitations')
                ->cascadeOnDelete();

            // Nama pemilik acara
            $table->string('event_owner_name')->nullable();

            // Pihak pertama
            $table->string('first_name')->nullable();
            $table->string('first_nickname')->nullable();

            // Pihak kedua
            $table->string('second_name')->nullable();
            $table->string('second_nickname')->nullable();

            // Orang tua pihak pertama
            $table->string('first_father')->nullable();
            $table->string('first_mother')->nullable();

            // Orang tua pihak kedua
            $table->string('second_father')->nullable();
            $table->string('second_mother')->nullable();

            // Header
            $table->string('headline')->nullable();

            // Ayat / Quote
            $table->text('quote')->nullable();

            // Deskripsi
            $table->longText('description')->nullable();

            // Penutup
            $table->longText('closing_text')->nullable();

            // Alamat utama
            $table->text('address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_profiles');
    }
};