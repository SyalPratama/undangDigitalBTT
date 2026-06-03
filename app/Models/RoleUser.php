<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($roleUser) {
            if (empty($roleUser->id)) {
                $roleUser->id = (string) Str::uuid();
            }
        });
    }
}