<?php

namespace App\Http\Controllers;


use App\Models\OrderDetails;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            // Add validation rules for other attributes
        ]);

        $orderDetail = OrderDetails::create($validatedData);

        return response()->json([
            'data' => $orderDetail,
            'message' => 'Order detail created successfully.',
        ]);
    }

    public function update(Request $request, OrderDetails $orderDetail)
    {
        $validatedData = $request->validate([
            'order_id' => 'integer',
            'product_id' => 'integer',
            'quantity' => 'integer',
            // Add validation rules for other attributes
        ]);

        $orderDetail->update($validatedData);

        return response()->json([
            'data' => $orderDetail,
            'message' => 'Order detail updated successfully.',
        ]);
    }

    public function destroy(OrderDetails $orderDetail)
    {
        $orderDetail->delete();

        return response()->json([
            'message' => 'Order detail deleted successfully.',
        ]);
    }
}
