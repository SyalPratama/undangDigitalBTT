<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('theme_categories', function (Blueprint $blueprint) {
            // Menggunakan UUID jika project Anda standar menggunakan UUID, atau id() jika auto-increment
            $blueprint->id(); 
            $blueprint->string('name')->unique(); // Contoh: 'Pernikahan', 'Birthday'
            $blueprint->string('slug')->unique(); // Contoh: 'pernikahan', 'birthday'
            $blueprint->text('description')->nullable();
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_categories');
    }
};