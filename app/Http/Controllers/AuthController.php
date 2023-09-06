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


        $imageUrl = asset('storage/' . 'images/avatar.webp');
        
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'image' => $imageUrl,
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

    // public function updateUser(Request $request, string $id)
    // {
    //     $fields = $request->validate([
    //         'name' => 'string',
    //         'email' => 'string|email:users,email',
    //         'password' => [ 'confirmed', RulesPassword::min(6)->mixedCase()->numbers()->symbols()]
    //     ]);


    //     $user = User::find($id);

    //     if (!$user) {
    //         return response()->json([
    //             'message' => 'User not found.',
    //         ], 404);
    //     }
    
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imagePath = $image->store('images', 'public');
    //         $imageUrl = asset('storage/' . $imagePath);
    //         $fields['image'] = $imageUrl;
    //     }

    //     $user->update($fields);
    //     $user->update(['password' => bcrypt($fields['password'])
    // ]);
    //     return response()->json([
    //         'data' => $user,
    //         'message' => 'user updated successfully.',
    //     ]);
    // }

    public function updateUser(Request $request, string $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'message' => 'User not found.',
        ], 404);
    }

    // Define the fields that are allowed to be updated
    $allowedFields = [
        'name',
        'email',
    ];

    // Filter the request data to include only allowed fields
    $fieldsToUpdate = $request->only($allowedFields);

    // Handle image upload if an image file is included in the request
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $image->store('images', 'public');
        $imageUrl = asset('storage/' . $imagePath);
        $fieldsToUpdate['image'] = $imageUrl;
    }

    // Check if the 'password' field is present and not empty in the request
    if ($request->filled('password')) {
        $fieldsToUpdate['password'] = bcrypt($request->input('password'));
    }

    // Update the user with the provided fields
    $user->update($fieldsToUpdate);

    return response()->json([
        'data' => $user,
        'message' => 'User updated successfully.',
    ]);
}

}
