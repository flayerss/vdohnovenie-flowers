<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsInBasket extends Model
{
    use HasFactory;
    protected $fillable = [
        'basket_id',
        'product_id',
        'count',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
}
