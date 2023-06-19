<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::all();

        return response()->json([
            'data' => $cartItems,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cart_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            // Add validation rules for other attributes
        ]);

        $cartItem = CartItem::create($validatedData);

        return response()->json([
            'data' => $cartItem,
            'message' => 'Cart item created successfully.',
        ]);
    }

    public function show(CartItem $cartItem, $cart_id)
    {
        $cartItem=CartItem::find($cart_id);
        return response()->json([
            'data' => $cartItem,
        ]);
    }

    public function update(Request $request, CartItem $cart_id)
    {
        $validatedData = $request->validate([
            'cart_id' => 'integer',
            'product_id' => 'integer',
            'quantity' => 'integer',
            // Add validation rules for other attributes
        ]);
        $cartItem = CartItem::findOrFail($cart_id);

        $cartItem->update($validatedData);

        return response()->json([
            'data' => $cartItem,
            'message' => 'Cart item updated successfully.',
        ]);
    }

    public function destroy(CartItem $cartItem, $cart_id)
    {
        $cartItem->delete($cart_id);

        return response()->json([
            'message' => 'Cart item deleted successfully.',
        ]);
    }
}
