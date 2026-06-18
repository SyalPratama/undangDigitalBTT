<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('invitation_id')
                ->constrained('invitations')
                ->cascadeOnDelete();

            // Nama acara
            $table->string('name');

            // Deskripsi acara
            $table->text('description')->nullable();

            // Tanggal acara
            $table->date('event_date');

            // Waktu
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Lokasi
            $table->string('venue_name')->nullable();

            $table->text('address')->nullable();

            // Google Maps
            $table->text('google_maps_url')->nullable();

            // Koordinat
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Urutan tampil
            $table->integer('sort_order')->default(0);

            // Aktif
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index([
                'invitation_id',
                'event_date'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};