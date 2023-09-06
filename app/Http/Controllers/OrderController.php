<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\OrderDetails;
use App\Models\OrderItem;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::withCount('orderItems')->get();
        $items = OrderItems::all();
        $details = OrderDetails::all();
        return response()->json([
            'orders' => $orders,
            'items'=>$items,
            'details'=> $details,
        ]);
    }



    public function store(Request $request)
    {
        $orderId = 0;
        $validatedData = $request->validate([
            'total_price' => 'required|numeric',
            'status' => 'string',
            'payement_method' => 'string',
            'discount' => 'integer',
        ]);

        try {
            $order = Orders::create($validatedData);
            $orderId = $order['order_id'];

            $validatedOrderItemsData['order_id'] = $orderId;

            $validatedOrderDeailsData = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'required|string', // Use string instead of integer
                'email' => 'required|string',
                'adresse' => 'required|string',
                'city' => 'required|string',
                'country' => 'required|string',
                'zipcode' => 'required|string', // Use string instead of integer
            ]);
            $validatedOrderDeailsData['order_id'] = $orderId;

            // Check if the order exists before creating order details and items
            if (!$order) {
                throw new \Exception('Failed to create order details and items.', $orderId);
            }
            $orderDetails = OrderDetails::create($validatedOrderDeailsData);

            $orderItems = [];
            $items = json_decode($request->items, true);
            foreach ($items as $item) {
                $validatedOrderItemsData = [
                    'product_id' => null,
                    'color' => null,
                    'size' => null,
                    'quantity' => null,
                    'unit_price' => null,
                    'order_id' => $orderId,
                ];
                $validatedOrderItemsData['product_id'] = $item['product_id'];
                $validatedOrderItemsData['quantity'] = $item['quantity'];
                $validatedOrderItemsData['color'] = $item['color'];
                $validatedOrderItemsData['size'] = $item['size'];
                $validatedOrderItemsData['unit_price'] = $item['price'];
                $orderItem = OrderItems::create($validatedOrderItemsData);
                // Check if the order item exists before creating order items

                if (!$orderItem) {
                    throw new \Exception('Failed to create order items.', $orderId);
                    break;
                }
                $orderItems[] = $orderItem;
            };
            $notification = Notification::create(['order_id' => $orderId]);

            $responseData = [
                'order' => $order,
                'order_details' => $orderDetails,
                'order_item' => $orderItems,
                'notification' => $notification,
                'message' => 'Order created successfully.',
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create order.', 'order-id' => $orderId, $e, $request->all()], 500);
        }
    }


    public function show(Orders $order,string $order_id)
    {
        $order = Orders::findOrFail($order_id);
        $orderId = $order['id'];
        $orderDetails = OrderDetails::where('order_id', '=', $order_id)->first();
        $orderItems = OrderItems::
        join('products', 'order_items.product_id', '=', 'products.product_id')->where('order_id', '=', $order_id)->get();

        return response()->json([
            'order' => $order,
            'orderDetails' => $orderDetails,
            'orderItems' => $orderItems,
        ]);
    }

    public function update(Request $request, string $order_id)
    {
        $validatedData = $request->validate([
            'status' => 'string'
        ]);

        // $order= Orders::where( 'order_id', '=', $order_id)->first();
        $order= Orders::find($order_id);
        $order->update($validatedData);
        return response()->json([
            'order' => $order,
            'message' => 'Order updated successfully.',
        ]);
    }

    public function destroy(Orders $order, $order_id)
    {
        $order->destroy($order_id);

        return response()->json([
            'message' => 'Order deleted successfully.',
        ]);
    }
}
