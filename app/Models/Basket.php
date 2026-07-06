<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'active'
    ];
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function productsinbasket()
    {
        return $this->hasMany(ProductsInBasket::class);
    }
}
