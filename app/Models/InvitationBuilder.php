<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvitationBuilder extends Model
{
    protected $table = 'invitation_builders';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'invitation_id',
        'html',
        'css',
        'project_data',
    ];

    protected $casts = [
        'project_data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}