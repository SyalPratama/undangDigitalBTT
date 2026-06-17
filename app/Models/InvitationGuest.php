<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class InvitationGuest extends Model
{
    use HasFactory;

    protected $table = 'invitation_guests';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'invitation_id',
        'name',
        'status',
        'is_location_shared',
    ];

    protected $casts = [
        'is_location_shared' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
