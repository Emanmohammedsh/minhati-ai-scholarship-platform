<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * POST /api/register
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'role'      => ['sometimes', Rule::in(['student', 'admin'])],
        ]);

        $user = User::create([
            'full_name'     => $validated['full_name'],
            'email'         => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role'          => $validated['role'] ?? 'student',
            'is_active'     => true,
        ]);

        return response()->json([
            'message' => 'Registered successfully. Please log in.',
            'user'    => $user,
        ], 201);
    }

    /**
     * POST /api/login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password_hash)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['This account has been deactivated.'],
            ]);
        }

        // Revoke previous tokens (optional — remove if you want multiple active sessions)
        $user->tokens()->delete();

        $user->forceFill(['last_login_at' => now()])->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'Logged in successfully.',
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    /**
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.']);
    }

    /**
     * GET /api/me
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
