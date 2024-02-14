<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'house_number',
        'interior_number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country'
    ];
    protected $appends = [
        'profile_image_url',
    ];


    public function userProfile()
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function profileImage()
    {
        return $this->hasOne(BranchProfileImage::class);
    }

    public function profileImageUrl(): Attribute
    {
        return new Attribute(
            get: fn () =>  $this->profileImage && $this->profileImage->attachment
                ? $this->profileImage->attachment->url
                : null
        );
    }
}
