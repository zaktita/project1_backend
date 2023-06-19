<?php

namespace App\Http\Controllers;


use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::all();

        return response()->json([
            'data' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id ' => 'required|integer',
            'total_price' => 'required|numeric',
            'status'=> 'string'
        ]);

        $order = Orders::create($validatedData);

        return response()->json([
            'data' => $order,
            'message' => 'Order created successfully.',
        ]);
    }

    public function show(Orders $order, $order_id)
    {
        $order= Orders::findOrFail($order_id);
        return response()->json([
            'data' => $order,
        ]);
    }

    public function update(Request $request, Orders $order,$order_id)
    {
        $validatedData = $request->validate([
            'order_id ' => 'required|integer',
            'total_price' => 'required|numeric',
            'status'=> 'string'
        ]);
        $order= Orders::findOrFail($order_id);

        $order->update($validatedData);

        return response()->json([
            'data' => $order,
            'message' => 'Order updated successfully.',
        ]);
    }

    public function destroy(Orders $order,$order_id)
    {
        $order->destroy($order_id);

        return response()->json([
            'message' => 'Order deleted successfully.',
        ]);
    }
}
