<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'brand', 
        'quantity',
        'unit',
        'price',
        'cost',
        'stock',
        'reorder_limit',
        'product_category_id'
    ];

    protected $appends = [
        'category_name',
    ];

    public function category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function getCategoryNameAttribute() { // Cambiar el nombre de la función
        return $this->category->name; // Acceder al nombre de la categoría asociada
    }
}
