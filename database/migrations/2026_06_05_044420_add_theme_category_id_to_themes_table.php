<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            // Menambahkan foreign key. Jika tabel kategori memakai UUID, gunakan foreignIdFor atau uuid('theme_category_id')
            $table->foreignId('theme_category_id')
                  ->nullable() // nullable dulu jika di tabel themes sudah ada datanya
                  ->after('id') // diletakkan setelah kolom id
                  ->constrained('theme_categories')
                  ->onDelete('set null'); 
        });
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropForeign(['theme_category_id']);
            $table->dropColumn('theme_category_id');
        });
    }
};