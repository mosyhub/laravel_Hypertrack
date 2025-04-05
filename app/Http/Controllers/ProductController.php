<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ✅ Index - shows the list of products
    public function index()
    {
        $products = Product::with('images')->get(); // eager-load images
        return view('admin.products.index', compact('products'));
    }

    // ✅ Create - shows the form to add a product
    public function create()
    {
        return view('admin.products.create');
    }

    public function store(ProductRequest $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'required', // Ensure at least one image is uploaded
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product = Product::create($request->only('name', 'description', 'price', 'stock'));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $product->images()->create([
                    'image_path' => $imagePath
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
    }

    // ✅ Edit - shows the form to edit a product
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
{
    $request->validate([
        'name' => 'required',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $product->update($request->only(['name', 'description', 'price', 'stock']));

    if ($request->hasFile('images')) {
        // Optionally delete old images if replacing
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        foreach ($request->file('images') as $image) {
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $product->images()->create(['image_path' => $imagePath]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
}
    // ✅ Destroy - delete product (and its images optionally)
    public function destroy(Product $product)
    {
        // Optional: delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
