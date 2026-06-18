<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            // Thumbnail tema
            $table->string('thumbnail')->nullable();

            // Folder/view blade
            $table->string('view_name');

            // Harga tema jika berbayar
            $table->decimal('price', 12, 2)->default(0);

            // Tema premium?
            $table->boolean('is_premium')->default(false);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};