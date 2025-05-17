<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request) {
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        Log::debug($validated);
        if (Auth::attempt($validated)) {
            $user = Auth::user();
            $token = $user->createToken($user->name.now());
            return response()->json([
                "ok" => true,
                "user" => $user,
                "token" => $token->plainTextToken
            ], 200);
        }
        return response()->json([
                "ok" => false,
            ], 400);
    }

    public function register(Request $request) {
        Log::info("Register function");
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:8",
        ]);
        Log::debug($validated);

        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => Hash::make($validated["password"]),
        ]);
        $token = $user->createToken($validated["name"].now());

        return response()->json([
            "ok" => true,
            "user" => $user,
            "token" => $token->plainTextToken
        ], 201);
    }
}
