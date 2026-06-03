<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class InvitationType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}