<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::with('type')->orderByDesc('id')->get();
        $types = Type::all();
        return view('admin-products', compact('products', 'types'));
    }

    public function create()
    {
        $types = Type::all();
        return view('admin-product-form', ['types' => $types, 'product' => null]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request, true);
        unset($validated['image']);
        $validated['img'] = $this->storeImage($request);

        Product::create($validated);

        return redirect()->route('admin.products')->with('status', 'Товар добавлен');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $types = Type::all();
        return view('admin-product-form', compact('product', 'types'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $this->validateProduct($request, false);
        unset($validated['image']);

        if ($request->hasFile('image')) {
            $validated['img'] = $this->storeImage($request);
        }

        $product->update($validated);

        return redirect()->route('admin.products')->with('status', 'Товар обновлён');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return back()->with('status', 'Товар удалён');
    }

    private function validateProduct(Request $request, bool $imageRequired)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'count' => 'required|integer|min:0',
            'type_id' => 'required|exists:types,id',
            'description' => 'nullable|string|max:2000',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|max:4096',
        ]);
    }

    private function storeImage(Request $request)
    {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid('prod_') . ".{$extension}";
        $file->move(public_path('img'), $filename);
        return '/img/' . $filename;
    }
}
