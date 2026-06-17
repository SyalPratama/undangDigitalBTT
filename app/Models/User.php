<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'reseller_id',
        'email',
        'package_id',
        'active_package',
        'package_expires_at',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = (string) Str::uuid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'package_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')
                    ->using(RoleUser::class) // <-- Beritahu Laravel untuk memakai model pivot kustom Anda
                    ->withTimestamps();      // Tambahkan ini jika tabel pivot Anda punya created_at & updated_at
    }

    /**
     * Helper untuk mengecek apakah user memiliki role tertentu
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * Cek apakah user memiliki fitur paket tertentu
     */
    public function hasFeature($featureKey)
    {
        if ($this->hasRole('superadmin')) {
            return true;
        }

        if (!$this->package) {
            return false;
        }

        if ($this->package_expires_at && $this->package_expires_at->isPast()) {
            return false;
        }

        return $this->package->{$featureKey} ?? false;
    }
}