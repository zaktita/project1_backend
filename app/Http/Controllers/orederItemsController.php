<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_detail_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            // Add validation rules for other attributes
        ]);

        $orderItem = OrderItem::create($validatedData);

        return response()->json([
            'data' => $orderItem,
            'message' => 'Order item created successfully.',
        ]);
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validatedData = $request->validate([
            'order_detail_id' => 'integer',
            'product_id' => 'integer',
            'quantity' => 'integer',
            // Add validation rules for other attributes
        ]);

        $orderItem->update($validatedData);

        return response()->json([
            'data' => $orderItem,
            'message' => 'Order item updated successfully.',
        ]);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->json([
            'message' => 'Order item deleted successfully.',
        ]);
    }
}
