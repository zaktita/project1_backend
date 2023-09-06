<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use \Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        
            // Initialize Stripe with your secret key
        // Stripe::setApiKey(env('STRIPE_KEY'));
        Stripe::setApiKey('sk_test_51E0BKAFKIowFZPMrfEW5hYZ9EAD4ZUpQ50pgH70zN9YHJO38uUjBSHhBmWNvpq5C6bvGwvMtgDuNcb5XyBpiJJq900Pp1mKYRl');
        $cartItems = json_decode($request->input('cartItems'), true);
        $lineItems = [];

        // Iterate through cart items and extract relevant data
        foreach ($cartItems as $cartItem) {
            // Extract relevant data (product name, price, image, etc.)
            $productName = $cartItem['title'];
            $productPrice = $cartItem['price'];
            $productImage = $cartItem['image']; // Adjust this based on your actual data structure
    
            // Create a line item with the extracted data
            $lineItem = [
                'price_data' => [
                    'currency' => 'MAD',
                    'product_data' => [
                        'name' => $productName,
                        'images' => ['https://media.jimmychoo.com/image/upload/c_fit,dpr_2.0,f_auto,h_900,q_auto:best,w_900/ROWPROD_PRODUCT/images/original/DIAMONDLIGHTMAXIFMYU_013727_SIDE.jpg'],
                        // 'images' => ['http://127.0.0.1:8000/'.$productImage,]
                    ],
                    'unit_amount' => $productPrice * 100, // Stripe uses cents
                ],
                'quantity' => $cartItem['quantity'],
            ];
    
            // Add the line item to the list
            $lineItems[] = $lineItem;
        }

        $session = Session::create([
            // 'line_items' => [
            //     [
            //         'price_data' => [
            //             'currency' => 'gbp',
            //             'product_data' => [
            //                 'name' => 'gimme money!!!!',
            //             ],
            //             'unit_amount' => 500,
            //         ],
            //         'quantity' => 1,
            //     ],
            // ],

            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => 'http://localhost:3000/thankYouPage', // Adjust this URL
            // 'cancel_url' => route('checkout'), // Adjust the cancel URL if needed
        ]);

        return response()->json(['redirectUrl' => $session->url]);

        // Set your Stripe secret key
        // Stripe::setApiKey(env('STRIPE_KEY'));

        // // Validate the incoming request (you might want to add more validation)
        // $request->validate([
        //     'amount' => 'required|integer',
        //     'currency' => 'required|string',
        // ]);

        // // Create a Payment Intent
        // $paymentIntent = PaymentIntent::create([
        //     'amount' => $request->amount,
        //     'currency' => $request->currency,
        //     // Add more options as needed
        // ]);

        // return response()->json([
        //     'clientSecret' => $paymentIntent->client_secret,
        // ]);
    }

    // Other methods as needed

    public function handlePayment() {
        Stripe::setApiKey(env('STRIPE_KEY'));


        $paymentIntent = PaymentIntent::retrieve(request()->input('payment_intent_id'));

        if ($paymentIntent->status === 'succeeded') {
            // Payment was successful
        } else {
            // Payment failed
        }
    }
}
