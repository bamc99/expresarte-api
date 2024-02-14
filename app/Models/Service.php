<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'cost',
        'duration',
        'service_category_id',
    ];

    protected $appends = [
        'category_name',
    ];

    public function category(){
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function getCategoryNameAttribute() { // Cambiar el nombre de la función
        return $this->category->name; // Acceder al nombre de la categoría asociada
    }
}
