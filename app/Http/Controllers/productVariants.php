<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

use App\Models\productColors;
use App\Models\Products;
use App\Models\productSizes;
use App\Models\ProductImage;


class productVariants extends Controller
{
    public function index()
    {
        $colors = productColors::all();
        $sizes = productSizes::all();
        $category = category::all();

        return response()->json([
            'colors' => $colors,
            'sizes' => $sizes,
            'category' => $category,
        ]);
    }


    public function find(string $product_id)
    {
        $colors = productColors::all();
        $sizes = productSizes::all();
        $category = category::all();
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
        $colors = productColors::all();
        $sizes = productSizes::all();
        $product_images = ProductImage::where('product_id', $product_id)->get();
        $product = Products::find($product_id);
        
        $categoryId = $product->category_id[0];
        $similar_products = Products::whereJsonContains('category_id', $categoryId)
        ->where('product_id', '!=', $product_id) // Exclude the current product
        ->limit(4)
        ->get();
        
        $category = category::where('category_id', $categoryId)->first();

    
        

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
