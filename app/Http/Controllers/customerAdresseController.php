<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|integer',
            'address' => 'required|string',
            'city' => 'required|string',
            // Add validation rules for other attributes
        ]);

        $customerAddress = CustomerAddress::create($validatedData);

        return response()->json([
            'data' => $customerAddress,
            'message' => 'Customer address created successfully.',
        ]);
    }

    public function update(Request $request, CustomerAddress $customerAddress)
    {
        $validatedData = $request->validate([
            'customer_id' => 'integer',
            'address' => 'string',
            'city' => 'string',
            // Add validation rules for other attributes
        ]);

        $customerAddress->update($validatedData);

        return response()->json([
            'data' => $customerAddress,
            'message' => 'Customer address updated successfully.',
        ]);
    }

    public function destroy(CustomerAddress $customerAddress)
    {
        $customerAddress->delete();

        return response()->json([
            'message' => 'Customer address deleted successfully.',
        ]);
    }
}
