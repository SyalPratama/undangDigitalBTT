<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationDesign extends Model
{
    protected $fillable = [
        'invitation_id', 'primary_color', 'background_color', 'text_color', 
        'heading_font', 'body_font', 'background_image', 'cover_image', 
        'ornament_image', 'sections', 'settings'
    ];

    // Gunakan cast bawaan Laravel
    protected $casts = [
        'sections' => 'array',
        'settings' => 'array',
    ];

    // TAMBAHKAN ACCESSOR INI (Ini "pelindung" agar tidak pernah jadi string)
    public function getSectionsAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }
        return $value ?? [];
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}