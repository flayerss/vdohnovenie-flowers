<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAll()
    {
        $products = Product::all();
        $types = Type::all();
        return view("index", compact("products", "types"));
    }
    public function getTypeProducts($id)
    {
        $products = Product::where('type_id', $id)->get();
        $types = Type::all();
        return view('index', compact('products', 'types'));
    }
    public function getCard($id)
    {
        $product = Product::find($id);
        $types = Type::all();
        return view('card', compact('product', 'types'));
    }
}
