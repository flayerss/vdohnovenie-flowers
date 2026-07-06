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
        $basket = Basket::where('active', 1)->first();
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
        $basket = Basket::where('active', 1)->first();
        if ($basket)
        {
            $basketproducts = ProductsInBasket::where('basket_id', $basket->id)->get();
        }
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
