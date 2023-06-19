<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::all();

        return response()->json([
            'data' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required',
            'colors' => 'required',
            'sizes' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            // Add validation rules for other attributes
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $imageUrl = asset('storage/' . $imagePath);

            $validatedData['image'] = $imageUrl;
            $product = Products::create($validatedData);

            return response()->json([
                'data' => $product,
                'message' => 'Product created successfully.',
            ]);
        }

        // Create product


       // Return error response if image file is not present
       return response()->json([
        'message' => 'Image file is required.',
    ], 400);
    }

    public function show(Products $product)
    {
        return response()->json([
            'data' => $product,
        ]);
    }

    public function update(Request $request, Products $product)
    {
        $validatedData = $request->validate([
            'category_id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            // Add validation rules for other attributes
        ]);

        $product->update($validatedData);

        return response()->json([
            'data' => $product,
            'message' => 'Product updated successfully.',
        ]);
    }

    public function destroy(Products $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}
