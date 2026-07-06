<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'basket_id',
        'name',
        'phone',
        'email',
        'date',
        'time',
        'dostavka',
        'type_oplata',
        'status_id',
    ];
    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
