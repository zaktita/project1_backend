<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreproductColorsRequest;
use App\Http\Requests\UpdateproductColorsRequest;
use App\Models\productColors;
use Illuminate\Http\Request;


class ProductColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = productColors::all();
        return response()->json(['data' => $colors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'color_name' => 'required|string|max:255',
        ]);
    
        $colors = productColors::create($validatedData);
    
        return response()->json([
            'colors' => $colors,
            'message' => 'Color created successfully'
        ]);
    }
    
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreproductColorsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(productColors $productColors, $id)
    {
        $productColors = productColors::find($id);
        return response()->json([
            'colors' => $productColors,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(productColors $productColors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproductColorsRequest $request, productColors $productColors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(productColors $productColors,$id)
    {
        $productColors->destroy($id);
        return response()->json([
            'message' => 'Color deleted successfully'
            ]);


    }
}
