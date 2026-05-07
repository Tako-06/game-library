<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createUser(Request $request) {
        $validated = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create($validated);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['error' => 'Invalid credentials!'], 401);
        };

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 200);
    }

    public function update(Request $request) {
        $user = $request->user();

        if(!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $validated = $request->validate([
            'username' => 'sometimes|unique:users,username,' . $user->id,
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return response()->json(['user' => $user], 200);
    }

    public function updatePassword(Request $request) {
        $user = $request->user();

        if(!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!password_verify($validated['current_password'], $user->password)) {
            return response()->json(['error' => 'Current password is incorrect!'], 400);
        }

        $user->password = bcrypt($validated['new_password']);
        $user->save();

        return response()->json(['message' => 'Password updated successfully!'], 200);
    }
}
