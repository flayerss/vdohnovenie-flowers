<?php

namespace App\Http\Controllers;

use App\Mail\OrderApprovedMail;
use App\Mail\OrderCancelledMail;
use App\Models\Comment;
use App\Models\Order;
use App\Models\ProductsInBasket;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    function getAdmin()
    {
        $orders = Order::all();
        $statuses = Status::all();
        $products = ProductsInBasket::all();
        return view('admin', compact('orders', 'statuses', 'products'));
    }
    function setStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if($request->status==2)
        {
            Mail::to($order->email)->queue(new OrderCancelledMail($order));
        }
        elseif ($request->status==3)
        {
            Mail::to($order->email)->queue(new OrderApprovedMail($order));
        }
        $order->status_id=$request->status;
        $order->save();
        return back();
    }
    function getComment()
    {
        $comments = Comment::all();
        $statuses = Status::all();
        return view('comments', compact('comments', 'statuses'));
    }
     function setComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->status_id=$request->status;
        $comment->save();
        return back();
    }
    function sortComment(Request $request)
    {
        $sort = $request->sort_status;
            $comments = Comment::where('status_id', $sort)->get();
             $statuses = Status::all();
        return view('comments', compact('comments', 'statuses'));
    }
    public function handleSort(Request $request)
    {
        // Параметр для сброса сортировки
        $reset = $request->input('reset');
        
        // Сбрасываем сортировку если передан параметр reset
        if ($reset) {
            return redirect()->route('admin');
        }
        
        // Получаем значения сортировки
        $dateSort = $request->input('sort');
        $statusId = $request->input('sort_status');
        
        // Создаем базовый запрос
        $orders = Order::query();
        
        // Применяем сортировку по дате если выбрано
        if ($dateSort === '1') {
            $orders = $orders->latest();
        } elseif ($dateSort === '2') {
            $orders = $orders->oldest();
        }
        
        // Фильтруем по статусу если выбран
        if ($statusId) {
            $orders = $orders->where('status_id', $statusId);
        }
        
        // Получаем данные
        $orders = $orders->get();
        
        // Дополнительные данные для представления
        $statuses = Status::all();
        $products = ProductsInBasket::all();
        
        return view('admin', compact('orders', 'statuses', 'products'));
    }
    function sortOrder(Request $request)
    {
        $sort = $request->sort;
        if($sort==2)
        {
            $orders = Order::oldest()->get();
        }
        elseif ($sort == 1)
        {
            $orders = Order::latest()->get();
        }
       $statuses = Status::all();
        $products = ProductsInBasket::all();
        return view('admin', compact('orders', 'statuses', 'products')); 
    }
    function sortStatus(Request $request)
    {
        $orders = Order::where('status_id', $request->sort_status)->get();
       $statuses = Status::all();
        $products = ProductsInBasket::all();
        return view('admin', compact('orders', 'statuses', 'products')); 
    }
}
