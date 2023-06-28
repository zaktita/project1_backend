<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

use App\Models\productColors;
use App\Models\Products;
use App\Models\productSizes;


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
}
