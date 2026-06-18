<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Pemilik undangan
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Jenis undangan
            $table->foreignUuid('invitation_type_id')
                ->constrained('invitation_types')
                ->cascadeOnDelete();

            // Template yang digunakan
            $table->foreignUuid('theme_id')
                ->constrained('themes')
                ->cascadeOnDelete();

            // URL undangan
            $table->string('slug')->unique();

            // Judul undangan
            $table->string('title');

            // Nama domain custom
            $table->string('custom_domain')->nullable();

            // Status publikasi
            $table->boolean('is_active')->default(false);

            // Password undangan (opsional)
            $table->string('password')->nullable();

            // Tanggal publish
            $table->timestamp('published_at')->nullable();

            // Tanggal acara utama
            $table->dateTime('event_date')->nullable();

            // Hitung jumlah kunjungan
            $table->unsignedBigInteger('visitor_count')->default(0);

            // Pengaturan SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('slug');
            $table->index('user_id');
            $table->index('is_active');
            $table->index('event_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};