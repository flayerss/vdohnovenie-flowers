<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlacedMail;
use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    $basket = Basket::where('session_id', session()->getId())->where('active', 1)->first();

    if ($basket) {
        // Проверка остатков перед оформлением
        foreach ($basket->productsinbasket as $item) {
            if ($item->count > $item->product->count) {
                return back()->withErrors([
                    'error' => 'Товара "'.$item->product->name.'" уже не осталось в нужном количестве, обновите корзину',
                ]);
            }
        }

        // Списание остатков
        foreach ($basket->productsinbasket as $item) {
            $item->product->decrement('count', $item->count);
        }

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
        Basket::create(['session_id' => session()->getId(), 'active' => 1]);

        // Отправка письма (через очередь)
        Mail::to($validator['email'])->queue(new OrderPlacedMail($order));
        $yes = 1;
        $total = $request->input('total');
        // Перенаправление с данными о заказе
        return redirect()->route('corsina')->with('order', $order)
        ->with('yes', $yes)->with('total', $total);
    }

    return back()->withErrors(['error' => 'Корзина пуста']);
}
}
