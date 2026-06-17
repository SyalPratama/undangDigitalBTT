<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Package extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'price',
        'active_days',
        'is_premium_template_access',
        'has_auto_guest_name',
        'has_event_countdown',
        'has_google_maps',
        'has_photo_gallery',
        'has_love_story',
        'has_background_music',
        'has_digital_envelope',
        'has_guest_comments',
        'has_rsvp',
        'has_rsvp_stats',
        'has_realtime_tracking',
        'has_opened_list',
        'has_unopened_list',
        'has_monitoring_dashboard',
        'features_json',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_premium_template_access' => 'boolean',
        'has_auto_guest_name' => 'boolean',
        'has_event_countdown' => 'boolean',
        'has_google_maps' => 'boolean',
        'has_photo_gallery' => 'boolean',
        'has_love_story' => 'boolean',
        'has_background_music' => 'boolean',
        'has_digital_envelope' => 'boolean',
        'has_guest_comments' => 'boolean',
        'has_rsvp' => 'boolean',
        'has_rsvp_stats' => 'boolean',
        'has_realtime_tracking' => 'boolean',
        'has_opened_list' => 'boolean',
        'has_unopened_list' => 'boolean',
        'has_monitoring_dashboard' => 'boolean',
        'is_active' => 'boolean',
        'features_json' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
