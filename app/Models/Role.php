<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            if (empty($role->id)) {
                $role->id = (string) Str::uuid();
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'role_user'
        );
    }
}