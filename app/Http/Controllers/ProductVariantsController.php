<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\ProductColors;
use App\Models\Products;
use App\Models\ProductSizes;
use App\Models\ProductImage;


class ProductVariantsController extends Controller
{
    public function index()
    {
        $colors = ProductColors::all();
        $sizes = ProductSizes::all();
        $category = Category::all();

        return response()->json([
            'colors' => $colors,
            'sizes' => $sizes,
            'category' => $category,
        ]);
    }


    public function find(string $product_id)
    {
        $colors = ProductColors::all();
        $sizes = ProductSizes::all();
        $category = Category::all();
        $product = Products::find($product_id);


        return response()->json([
            'colors' => $colors,
            'sizes' => $sizes,
            'category' => $category,
            'product' => $product,
        ]);
    }

    // method for fetching the product and similar products
    public function findproductwithimages(string $product_id)
    {
        $colors = ProductColors::all();
        $sizes = ProductSizes::all();
        $product_images = ProductImage::where('product_id', $product_id)->get();
        $product = Products::find($product_id);
        
        $categoryId = $product->category_id[0];
        $similar_products = Products::whereJsonContains('category_id', $categoryId)
        ->where('product_id', '!=', $product_id) // Exclude the current product
        ->limit(4)
        ->get();
        
        $category = Category::where('category_id', $categoryId)->first();

    
        

        return response()->json([
            // 'colors' => $colors,
            // 'sizes' => $sizes,
            'category' => $category,
            'product' => $product,
            'productImages' => $product_images,
            'similarProducts' => $similar_products,
        ]);
    }
}
