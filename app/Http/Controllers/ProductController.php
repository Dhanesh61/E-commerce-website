<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // Middleware definitions here

    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        $products = Product::orderBy($sortBy, $sortOrder)->paginate(10);

        return view('index', compact('products', 'sortOrder', 'sortBy'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');

        $productsQuery = Product::query();

        if (!empty($query)) {
            $productsQuery->where('name', 'like', '%' . $query . '%');
        }

        if (!empty($minPrice) && !empty($maxPrice)) {
            $productsQuery->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif (!empty($minPrice)) {
            $productsQuery->where('price', '>=', $minPrice);
        } elseif (!empty($maxPrice)) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        $products = $productsQuery->paginate(10);
        $sortOrder = $request->get('sort_order', 'asc');
        $sortBy = $request->get('sort_by', 'name');

        return view('index', compact('products', 'sortOrder', 'sortBy'));
    }

    public function bulkDelete(Request $request)
    {
        $productIds = $request->input('selected_products');
        if ($productIds) {
            Product::whereIn('id', $productIds)->delete();
        }
        return redirect()->route('product.index');
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000'
        ], [
            'name.required' => '**The name field is required.',
            'description.required' => '**The description field is required.',
            'price.required' => '**The price field is required.',
            'image.required' => '**The image field is required.',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('img'), $imageName);

        $product = new Product;
        $product->image = $imageName;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        $product->save();
        return redirect()->route('product.index')->with('success', 'Product Created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1000'
        ], [
            'name.required' => '**The name field is required.',
            'description.required' => '**The description field is required.',
            'price.required' => '**The price field is required.',
        ]);

        $product = Product::findOrFail($id);
        $oldData = json_decode($product->old_data, true) ?? [];
        $newData = json_decode($product->new_data, true) ?? [];
        $currentOldData = [];
        $currentNewData = [];

        $fieldsToUpdate = ['name', 'description', 'price'];
        foreach ($fieldsToUpdate as $field) {
            if ($product->$field != $request->$field) {
                $currentOldData[$field] = $product->$field;
                $currentNewData[$field] = $request->$field;
                $product->$field = $request->$field;
            }
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('img'), $imageName);
            if ($product->image != $imageName) {
                $currentOldData['image'] = $product->image;
                $currentNewData['image'] = $imageName;
                $product->image = $imageName;
            }
        }

        foreach ($currentOldData as $key => $value) {
            $oldData[$key][] = $value;
        }
        foreach ($currentNewData as $key => $value) {
            $newData[$key] = $value;
        }

        $product->old_data = json_encode($oldData);
        $product->new_data = json_encode($newData);

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product Updated');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $imagePath = public_path('img') . '/' . $product->image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $product->delete();
        return back()->with('success', 'Product Deleted');
    }

    public function showHistory($id)
    {
        $product = Product::findOrFail($id);
        $oldData = json_decode($product->old_data, true);
        $newData = json_decode($product->new_data, true);

        return view('layouts.history', compact('product', 'oldData', 'newData'));
    }

}