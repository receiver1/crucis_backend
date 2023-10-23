<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    /**
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|min:3|max:256',
            'password' => 'required|min:6|max:64',
        ]);

        if (!auth()->attempt($request->only('email', 'password')))
            return response()->json(['message' => 'Invalid credentials'], 401);

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth-token');

        return response()->json(['token' => $token->plainTextToken]);
    }

    /**
     * @unauthenticated
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $token = $user->createToken('auth-token');

        return response()->json(['token' => $token->plainTextToken]);
    }

    /**
     */
    public function logout(Request $request)
    {
        return auth()->token()->revoke();
    }
}