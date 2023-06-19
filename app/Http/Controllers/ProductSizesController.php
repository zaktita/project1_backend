<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreproductSizesRequest;
use App\Http\Requests\UpdateproductSizesRequest;
use App\Models\productSizes;
use Illuminate\Http\Request;


class ProductSizesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = productSizes::all();
        return response()->json(['size' => $size]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validateData = $request->validate([
            'size' => 'required',
        ]);

        $size = productSizes::create($validateData);

        return response()->json([
            'size' => $size, 
            'message' => 'Size Created Successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreproductSizesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(productSizes $productSizes, $id)
    {
        $productSizes = productSizes::find($id);

        return response()->json([
            'size' => $productSizes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(productSizes $productSizes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateproductSizesRequest $request, productSizes $productSizes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(productSizes $productSizes, $id)
    {
        $productSizes->destroy($id);
        return response()->json([
            'message' => 'Color deleted successfully'
            ]);

    }
}
