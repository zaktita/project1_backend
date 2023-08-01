<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rules\Password as RulesPassword;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => ['required', 'confirmed', RulesPassword::min(6)->mixedCase()->numbers()->symbols()]
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }




    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        /** @var \App\Models\User $user **/
        $token = $user->createToken('myapptoken')->plainTextToken;


        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function logout(Request $request)
    {

        if (auth()->check()) {
            /** @var \App\Models\User $user */
            // $user = auth()->user();
            $user = $request->user();
            $user->tokens()->delete();
            return response([
                'message' => 'User logged out'
            ], 200);
        } else {
            return response([
                'message' => 'User not found'
            ], 401);
        }
    }
}
