<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invitations';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'invitation_type_id',
        'theme_id',
        'slug',
        'title',
        'custom_domain',
        'password',
        'is_active',
        'published_at',
        'event_date',
        'visitor_count',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'published_at'   => 'datetime',
        'event_date'     => 'datetime',
        'visitor_count'  => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invitation) {
            if (empty($invitation->id)) {
                $invitation->id = (string) Str::uuid();
            }
        });
    }

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(
            InvitationType::class,
            'invitation_type_id'
        );
    }

    public function theme()
    {
        return $this->belongsTo(
            Theme::class,
            'theme_id'
        );
    }

    public function profile()
    {
        return $this->hasOne(
            InvitationProfile::class,
            'invitation_id'
        );
    }

    public function media()
    {
        return $this->hasMany(
            InvitationMedia::class,
            'invitation_id'
        );
    }

    public function cover()
    {
        return $this->hasOne(
            InvitationMedia::class,
            'invitation_id'
        )->where('type', 'cover');
    }

    public function galleries()
    {
        return $this->hasMany(
            InvitationMedia::class,
            'invitation_id'
        )
        ->where('type', 'gallery')
        ->orderBy('sort_order');
    }

    public function videos()
    {
        return $this->hasMany(
            InvitationMedia::class,
            'invitation_id'
        )
        ->where('type', 'video')
        ->orderBy('sort_order');
    }

    public function firstPersonPhoto()
    {
        return $this->hasOne(
            InvitationMedia::class,
            'invitation_id'
        )->where('type', 'first_person');
    }

    public function secondPersonPhoto()
    {
        return $this->hasOne(
            InvitationMedia::class,
            'invitation_id'
        )->where('type', 'second_person');
    }


    //  Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeBySlug($query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    // EVENT
    public function events()
    {
        return $this->hasMany(
            Event::class,
            'invitation_id'
        )->orderBy('event_date')
        ->orderBy('start_time');
    }

    public function builder()
    {
        return $this->hasOne(
            InvitationBuilder::class,
            'invitation_id'
        );
    }
}