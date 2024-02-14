<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'verification_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    protected $appends = [
        'profile_image_url',
    ];

    public function profile(){
        return $this->hasOne(ClientProfile::class);
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
