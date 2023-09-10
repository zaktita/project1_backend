<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();

        return response()->json([
            'data' => $payments,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            // Add validation rules for other attributes
        ]);

        $payment = Payment::create($validatedData);

        return response()->json([
            'data' => $payment,
            'message' => 'Payment created successfully.',
        ]);
    }

    public function show(Payment $payment)
    {
        return response()->json([
            'data' => $payment,
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'order_id' => 'integer',
            'amount' => 'numeric',
            'payment_method' => 'string',
            // Add validation rules for other attributes
        ]);

        $payment->update($validatedData);

        return response()->json([
            'data' => $payment,
            'message' => 'Payment updated successfully.',
        ]);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully.',
        ]);
    }
}
