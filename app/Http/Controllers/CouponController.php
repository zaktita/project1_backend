<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return response()->json($coupons);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons',
            'discount_percentage' => 'required|integer',
            'expires_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $coupon = Coupon::create($request->all());

        return response()->json($coupon, 201);
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'discount_percentage' => 'required|integer',
            'expires_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $coupon->update($request->all());

        return response()->json($coupon, 200);
    }

    public function destroy(Coupon $coupon,$id)
    {
        $coupon->destroy($id);
        return response()->json([
            'message' => 'Color deleted successfully'
            ]);

    }

    public function find(string $code)
    {
        $coupon = Coupon::where('code', $code)->first();
        
        if(!empty($coupon)&& $coupon->expires_at->isFuture()){

            return response()->json([
                'coupon' => $coupon->discount_percentage,
            ]);
        }else{
            return response()->json([
                'message' => 'Coupon expired or does not exist'
                ],400);
    }}
}
