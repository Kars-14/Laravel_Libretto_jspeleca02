<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create token that expires in 1 day
        $token = $user->createToken('auth-token', ['*'], now()->addDay())->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
            'token_expires_at' => now()->addDay()->toISOString()
        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Check if user has existing tokens
        $existingToken = $user->tokens()->where('name', 'auth-token')->first();
        
        if ($existingToken) {
            // Check if token is expired
            if ($existingToken->expires_at && $existingToken->expires_at->isPast()) {
                // Delete expired token
                $existingToken->delete();
                
                // Create new token
                $token = $user->createToken('auth-token', ['*'], now()->addDay())->plainTextToken;
                
                return response()->json([
                    'status' => 'success',
                    'message' => 'Previous token expired. New token generated.',
                    'user' => $user,
                    'token' => $token,
                    'token_expires_at' => now()->addDay()->toISOString()
                ]);
            } else {
                // Return existing valid token info (without exposing the actual token)
                return response()->json([
                    'status' => 'success',
                    'message' => 'Using existing valid token',
                    'user' => $user,
                    'token_expires_at' => $existingToken->expires_at->toISOString(),
                    'note' => 'Your existing token is still valid. Use your previous token.'
                ]);
            }
        } else {
            // No existing token, create new one
            $token = $user->createToken('auth-token', ['*'], now()->addDay())->plainTextToken;
            
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
                'token_expires_at' => now()->addDay()->toISOString()
            ]);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $currentToken = $request->user()->currentAccessToken();
        
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token_expires_at' => $currentToken->expires_at ? $currentToken->expires_at->toISOString() : null
        ]);
    }

    /**
     * Refresh token (manually refresh before expiry)
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();
        
        // Delete current token
        $request->user()->currentAccessToken()->delete();
        
        // Create new token
        $token = $user->createToken('auth-token', ['*'], now()->addDay())->plainTextToken;
        
        return response()->json([
            'status' => 'success',
            'message' => 'Token refreshed successfully',
            'token' => $token,
            'token_expires_at' => now()->addDay()->toISOString()
        ]);
    }
}
