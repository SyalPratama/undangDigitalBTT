<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvitationMedia extends Model
{
    use HasFactory;

    protected $table = 'invitation_media';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'invitation_id',
        'type',
        'file_path',
        'mime_type',
        'file_size',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($media) {
            if (empty($media->id)) {
                $media->id = (string) Str::uuid();
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

    // Scopes

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeGallery($query)
    {
        return $query->where('type', 'gallery');
    }

    public function scopeCover($query)
    {
        return $query->where('type', 'cover');
    }

    public function scopeVideo($query)
    {
        return $query->where('type', 'video');
    }
}