<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'passcode',
        'verification_token'
    ];

    protected $appends = [
        'role_names',
        'profile_image_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relacion uno a uno
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function roleNames(): Attribute
    {
        return new Attribute(
            get: fn () => $this->roles()->pluck('name')->toArray() ?? []
        );
    }

    public function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole('admin')
        );
    }

    public function profileImageUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->profile && $this->profile->profileImage && $this->profile->profileImage->attachment
                ? $this->profile->profileImage->attachment->url
                : null
        );
    }
}
