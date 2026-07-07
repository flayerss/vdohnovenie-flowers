<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;
use App\Models\ProductsInBasket;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    function addProduct($id)
    {
        $product = Product::find($id);
        $basket = Basket::firstOrCreate(
            ['session_id' => session()->getId(), 'active' => 1]
        );
        $productinbasket = ProductsInBasket::where('product_id', $product->id)->where('basket_id', $basket->id)->first();
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
    function delProduct($id)
    {
        $product = ProductsInBasket::find($id);
        $product->delete();
        return redirect()->route('corsina');
    }
}
