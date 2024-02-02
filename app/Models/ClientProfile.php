<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'street',
        'house_number',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'date_of_birth',
        'date_of_first_visit',
        'number_of_visits',
        'client_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
