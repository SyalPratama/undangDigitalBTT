<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'invitation_id',
        'name',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'venue_name',
        'address',
        'google_maps_url',
        'latitude',
        'longitude',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (!$event->id) {
                $event->id = (string) Str::uuid();
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}