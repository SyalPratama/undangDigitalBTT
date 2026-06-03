<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvitationProfile extends Model
{
    use HasFactory;

    protected $table = 'invitation_profiles';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'invitation_id',

        'event_owner_name',

        'first_name',
        'first_nickname',

        'second_name',
        'second_nickname',

        'first_father',
        'first_mother',

        'second_father',
        'second_mother',

        'headline',
        'quote',
        'description',
        'closing_text',
        'address',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            if (empty($profile->id)) {
                $profile->id = (string) Str::uuid();
            }
        });
    }

    public function invitation()
    {
        return $this->belongsTo(
            Invitation::class,
            'invitation_id'
        );
    }
}