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
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('has_auto_guest_name')->default(false)->after('is_premium_template_access');
            $table->boolean('has_event_countdown')->default(false)->after('has_auto_guest_name');
            $table->boolean('has_google_maps')->default(false)->after('has_event_countdown');
            $table->boolean('has_photo_gallery')->default(false)->after('has_google_maps');
            $table->boolean('has_love_story')->default(false)->after('has_photo_gallery');
            $table->boolean('has_background_music')->default(false)->after('has_love_story');
            $table->boolean('has_digital_envelope')->default(false)->after('has_background_music');
            $table->boolean('has_guest_comments')->default(false)->after('has_digital_envelope');
            $table->boolean('has_unopened_list')->default(false)->after('has_opened_list');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'has_auto_guest_name',
                'has_event_countdown',
                'has_google_maps',
                'has_photo_gallery',
                'has_love_story',
                'has_background_music',
                'has_digital_envelope',
                'has_guest_comments',
                'has_unopened_list',
            ]);
        });
    }
};
