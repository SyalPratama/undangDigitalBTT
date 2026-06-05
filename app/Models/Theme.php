<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theme extends Model
{
    protected $fillable = [
        'theme_category_id',
        'name',
        'slug',
        'description',
        'thumbnail',
        'view_name',
        'price',
        'is_premium',
        'is_active',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($theme) {
            if (!$theme->id) {
                $theme->id = (string) Str::uuid();
            }
        });
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ThemeCategory::class, 'theme_category_id');
    }
}