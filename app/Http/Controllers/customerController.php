<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return response()->json([
            'data' => $customers,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|integer|unique:customers',
            'email' => 'required|email|unique:customers',
        ]);

        $customer = Customer::create($validatedData);

        return response()->json([
            'data' => $customer,
            'message' => 'Customer created successfully.',
        ]);
    }

    public function show(Customer $customer)
    {
        return response()->json([
            'data' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer, $customer_id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|integer|unique:customers',
            'email' => 'email|unique:customers,email,' 
        ]);


        $customer = Customer::findOrFail($customer_id);

        $customer->update($validatedData);

        return response()->json([
            'data' => $customer,
            'message' => 'Customer updated successfully.',
        ]);
    }

    public function destroy(Customer $customer,$customer_id)
    {
        $customer->destroy($customer_id);

        return response()->json([
            'message' => 'Customer deleted successfully.',
        ]);
    }
}
