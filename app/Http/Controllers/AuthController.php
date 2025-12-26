<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'success' => true,
            'code' => 201,
            'data' => ['user' => $user],
            'message' => 'User registered'
        ], 201);
    }

    public function login(Request $request)
    {
        // similar logic for login
    }

    public function logout(Request $request)
    {
        // similar logic for logout
    }
}

?>