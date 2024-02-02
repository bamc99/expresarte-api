<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'house_number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country'
    ];

    public function userProfile(){
        return $this->belongsTo(UserProfile::class);
    }

}
