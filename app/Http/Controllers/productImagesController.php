<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image_url' => 'required|url',
            // Add validation rules for other attributes
        ]);
        $productImage = ProductImage::create($validatedData);

        return response()->json([
            'data' => $productImage,
            'message' => 'Product image created successfully.',
        ]);
    }

    public function update(Request $request, ProductImage $productImage)
    {
        $validatedData = $request->validate([
            'product_id' => 'integer',
            'image_url' => 'url',
            // Add validation rules for other attributes
        ]);

        $productImage->update($validatedData);

        return response()->json([
            'data' => $productImage,
            'message' => 'Product image updated successfully.',
        ]);
    }

    public function destroy(ProductImage $productImage)
    {
        $productImage->delete();

        return response()->json([
            'message' => 'Product image deleted successfully.',
        ]);
    }
}
