<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use App\Models\ProductsInBasket;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    function addProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $basket = Basket::firstOrCreate(
            ['session_id' => session()->getId(), 'active' => 1]
        );
        $productinbasket = ProductsInBasket::where('product_id', $product->id)->where('basket_id', $basket->id)->first();
        $currentCount = $productinbasket ? $productinbasket->count : 0;

        if ($currentCount + 1 > $product->count)
        {
            $message = 'Недостаточно товара "'.$product->name.'" на складе';
            if ($request->ajax() || $request->wantsJson())
            {
                return response()->json(['error' => $message], 422);
            }
            return back()->withErrors(['error' => $message]);
        }

        if (!$productinbasket)
        {
            $productinbasket = ProductsInBasket::create([
                'basket_id' => $basket->id,
                'product_id' => $product->id,
                'count' => '1'
            ]);
        }
        else
        {
            $productinbasket->count = $productinbasket->count + 1;
            $productinbasket->save();
        }

        if ($request->ajax() || $request->wantsJson())
        {
            $cartCount = ProductsInBasket::where('basket_id', $basket->id)->sum('count');
            return response()->json(['cartCount' => (int) $cartCount]);
        }
        return redirect()->route('corsina');
    }
    function getBasket()
    {
        $basket = Basket::where('session_id', session()->getId())->where('active', 1)->first();
        $basketproducts = $basket
            ? ProductsInBasket::where('basket_id', $basket->id)->get()
            : collect();
        if ($basketproducts->count()>0)
        {
            return view('corsina', compact('basketproducts'));
        }
        else
        {
            return view('corsina');
        }
    }
    function updateQuantity(Request $request, $id)
    {
        $item = ProductsInBasket::findOrFail($id);
        if (!$item->basket || $item->basket->session_id !== session()->getId())
        {
            abort(403);
        }

        $count = (int) $request->input('count', 1);
        $count = max(1, min($count, $item->product->count));
        $item->count = $count;
        $item->save();

        return redirect()->route('corsina');
    }

    function delProduct($id)
    {
        $product = ProductsInBasket::findOrFail($id);
        if (!$product->basket || $product->basket->session_id !== session()->getId())
        {
            abort(403);
        }
        $product->delete();
        return redirect()->route('corsina');
    }
}
