<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    function addOrder(Request $request)
    {
    $validator = $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email',
        'date' => 'required',
        'time' => 'required',
        'address' => 'required',
        'type' => 'required',
    ]);

    $basket = Basket::where('active', 1)->first();
    
    if ($basket) {
        // Создание заказа
        $order = Order::create([
            'basket_id' => $basket->id,
            'name' => $validator['name'],
            'phone' => $validator['phone'],
            'email' => $validator['email'],
            'date' => $validator['date'],
            'time' => $validator['time'],
            'dostavka' => $validator['address'],
            'type_oplata' => $validator['type'],
            'status_id' => 1,
        ]);

        // Деактивация корзины
        $basket->active = 0;
        $basket->save();

        // Создание новой активной корзины
        Basket::create(['active' => 1]);

        // Отправка письма
        Mail::raw('Заказ оформлен', function($message) use ($validator) {
            $message->to($validator['email'])
                    ->subject('Подтверждение заказа');
        });
        $yes = 1;
        $total = $request->input('total');
        // Перенаправление с данными о заказе
        return redirect()->route('corsina')->with('order', $order)
        ->with('yes', $yes)->with('total', $total);
    }

    return back()->withErrors(['error' => 'Корзина пуста']);
}
}
