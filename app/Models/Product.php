<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['img', 'name', 'price', 'count', 'type_id', 'description'];
    public function productinbasket()
    {
        return $this->hasMany(ProductsInBasket::class);
    }
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
