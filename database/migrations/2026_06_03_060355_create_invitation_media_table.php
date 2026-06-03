<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_media', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('invitation_id')
                ->constrained('invitations')
                ->cascadeOnDelete();

            $table->enum('type', [
                'cover',
                'gallery',
                'first_person',
                'second_person',
                'video'
            ]);

            $table->string('file_path');

            $table->string('mime_type')->nullable();

            $table->unsignedBigInteger('file_size')->nullable();

            $table->string('title')->nullable();

            $table->text('description')->nullable();

            $table->integer('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index([
                'invitation_id',
                'type',
                'sort_order'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_media');
    }
};