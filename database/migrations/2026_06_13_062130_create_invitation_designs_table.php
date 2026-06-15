<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('invitation_designs', function (Blueprint $table) {


            $table->id();


            /*
            |--------------------------------------------------------------------------
            | hanya ambil invitation
            |--------------------------------------------------------------------------
            */

            $table->uuid('invitation_id')
                ->unique();


            $table->foreign('invitation_id')
                ->references('id')
                ->on('invitations')
                ->cascadeOnDelete();



            /*
            |--------------------------------------------------------------------------
            | THEME CUSTOM
            |--------------------------------------------------------------------------
            */


            $table->string('primary_color')
                ->nullable();


            $table->string('background_color')
                ->nullable();


            $table->string('text_color')
                ->nullable();


            $table->string('heading_font')
                ->nullable();


            $table->string('body_font')
                ->nullable();



            /*
            |--------------------------------------------------------------------------
            | BACKGROUND
            |--------------------------------------------------------------------------
            */


            $table->string('background_image')
                ->nullable();


            $table->string('cover_image')
                ->nullable();


            $table->string('ornament_image')
                ->nullable();



            /*
            |--------------------------------------------------------------------------
            | SECTION ORDER
            |--------------------------------------------------------------------------
            |
            | contoh:
            |
            | [
            |  {"type":"cover","order":1},
            |  {"type":"gallery","order":2}
            | ]
            |
            */

            $table->json('sections')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | GLOBAL CONFIG
            |--------------------------------------------------------------------------
            |
            | radius
            | shadow
            | animation
            | spacing
            |
            */


            $table->json('settings')
                ->nullable();



            $table->timestamps();


        });

    }



    public function down(): void
    {

        Schema::dropIfExists('invitation_designs');

    }

};