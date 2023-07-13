<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::all();

        return response()->json([
            'data' => $products,
        ]);
    }
    public function fetchProductwhitcategories()
    {


        $products = Products::all();
        $categories = category::all();

        return response()->json([
            'product' => $products,
            'category' => $categories,
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

        $category = json_decode($request->input('category_id'), true);
        $sizes = json_decode($request->input('sizes'), true);
        $colors = json_decode($request->input('colors'), true);

        if ($request->hasFile('image') && $request->hasFile('product_images')) {
            $image = $request->file('image');
            $imagePath = $image->store('main', 'public');
            // $imageUrl = asset('storage/' . $imagePath);

            $validatedData['image'] = $imagePath;
            $validatedData['sizes'] = $sizes;
            $validatedData['colors'] = $colors;
            $validatedData['category_id'] = $category;


            $product = Products::create($validatedData);
            foreach ($request->file('product_images') as $product_images) {
                $product_imagesPath = $product_images->store('secondary', 'public');
                // $product_imagesUrl = asset('storage/' . $product_imagesPath);


                //  $product_images   = ProductImage::create([
                //     'product_id' => $product->product_id,
                //     'filename' => $product_imagesUrl,
                //  ]);

                DB::table('product_images')->insert([
                    'product_id' => $product->product_id,
                    'filename' => $product_imagesPath,
                ]);
            }

            return response()->json([
                'data' => $product, $product_images,
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
        //
    }

    public function update(Request $request, Products $product, $product_id)
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

        $category = json_decode($request->input('category_id'), true);
        $sizes = json_decode($request->input('sizes'), true);
        $colors = json_decode($request->input('colors'), true);

        $product = Products::find($product_id);
        if (!$product) {
            return response()->json([
                'message' => 'product not found.',
            ], 404);
        }

        if ($request->hasFile('image') && $request->hasFile('product_images')) {


            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $image = $request->file('image');
            $imagePath = $image->store('main', 'public');
            $imageUrl = asset('storage/' . $imagePath);


            $validatedData['image'] = $imageUrl;
            $validatedData['sizes'] = $sizes;
            $validatedData['colors'] = $colors;
            $validatedData['category_id'] = $category;



            $product->update($validatedData);

            // delete the product images from storage
            $productimages = DB::table('product_images')->where('product_id', $product_id)->get();
            foreach ($productimages as $productimage) {
                Storage::disk('public')->delete($productimage->filename);
                // DB::table('product_images')->where('product_id', $product_id)->delete();
            }


            // add the new product images
            foreach ($request->file('product_images') as $product_images) {

                $product_imagesPath = $product_images->store('secondary', 'public');
                $product_imagesUrl = asset('storage/' . $product_imagesPath);


                DB::table('product_images')->insert([
                    'product_id' => $product->product_id,
                    'filename' => $product_imagesUrl,
                ]);
            }
            return response()->json([
                'data' => $product,
                'message' => 'Product updated successfully.',
            ]);
        }
    }

    // public function destroy(Products $product, $product_id)
    // {
    //     $product = Products::find($product_id);
    //     Storage::disk('public')->delete($product->image);
    //     $product->destroy($product_id);

    //     return response()->json([
    //         'message' => 'Product deleted successfully.',
    //     ]);
    // }

    public function destroy(Products $product, $product_id)
    {
        $product = Products::find($product_id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        // Delete the product image from storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $productimages = DB::table('product_images')->where('product_id', $product_id)->get();
        foreach ($productimages as $productimage) {
            Storage::disk('public')->delete($productimage->filename);
            // DB::table('product_images')->where('product_id', $product_id)->delete();
        }


        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }


    public function search(string $keyword){
        $productresults = Products::where('title', 'LIKE' ,'%'.$keyword.'%' )
        ->get();
        return response()->json([
            'products' => $productresults,
        ]);
    }
}
