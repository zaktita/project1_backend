<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'data' => $categories,
        ]);
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'category_name' => 'required|string',
    //         'category_slug' => 'required|string',
    //         'category_description' => 'required|text',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         // Add validation rules for other attributes
    //     ]);


    //     $category = Category::create($validatedData);

    //     return response()->json([
    //         'data' => $category,
    //         'message' => 'Category created successfully.',
    //     ]);
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'category_slug' => 'required|string',
            'category_description' => 'required|string',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

            // 'image' => 'required|array|max:8',
            // 'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imagePath = $image->store('images', 'public');
            $imageUrl = asset('storage/' . $imagePath);

            $validatedData['category_image'] = $imageUrl;
            $category = Category::create($validatedData);

            return response()->json([
                'data' => $category,
                'message' => 'Category created successfully.',
            ]);
        }

        // Return error response if image file is not present
        return response()->json([
            'message' => 'Image file is required.',
        ], 400);
    }



    public function show(Category $category, $category_id)
    {
        $category = Category::find($category_id);
        return response()->json([
            'data' => $category,
        ]);
    }




    public function update(Request $request, $category_id)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string',
            'category_slug' => 'required|string',
            'category_description' => 'required|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // Add validation rules for other attributes
        ]);
    
        $category = Category::find($category_id);
    
        if (!$category) {
            return response()->json([
                'message' => 'Category not found.',
            ], 404);
        }
    
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imagePath = $image->store('images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
    
            $validatedData['category_image'] = $imageUrl;
        }
    
        $category->update($validatedData);
    
        return response()->json([
            'data' => $category,
            'message' => 'Category updated successfully.',
        ]);
    }
    

    public function destroy(Category $category, $category_id)
    {
        $category->destroy($category_id);

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
