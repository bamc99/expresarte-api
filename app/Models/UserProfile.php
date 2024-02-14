<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'street',
        'house_number',
        'interior_number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'emergency_name',
        'emergency_phone',
        'emergency_relationship',
        'date_of_birth',
        'date_of_hire',
        'last_work_date',
        'nss',
        'user_id',
        'branch_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacion uno a uno
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function profileImage()
    {
        return $this->hasOne(UserProfileImage::class);
    }
}
