<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard')
                ->with('info', 'You are already logged in.');
        }
        
        return view('auth.login');
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard')
                ->with('info', 'You are already logged in.');
        }
        
        return view('auth.register');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user has existing tokens and if they're expired
            $existingTokens = $user->tokens()->where('name', 'web-token')->get();
            
            foreach ($existingTokens as $token) {
                if ($token->expires_at && $token->expires_at->isPast()) {
                    $token->delete();
                } else {
                    // If token exists and is not expired, keep using it
                    $request->session()->regenerate();
                    return redirect()->intended(route('dashboard'))
                        ->with('success', 'Welcome back! Using existing session.');
                }
            }
            
            // Create new token that expires in 1 day
            $token = $user->createToken('web-token', ['*'], now()->addDay());
            
            // Store token in session for web usage
            session(['api_token' => $token->plainTextToken]);
            
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login successful! New session created.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create token that expires in 1 day
        $token = $user->createToken('web-token', ['*'], now()->addDay());
        
        // Store token in session
        session(['api_token' => $token->plainTextToken]);
        
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registration successful! Welcome to Libretto.');
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            // Revoke all tokens for this user
            $user->tokens()->delete();
        }
        
        // Clear session token
        session()->forget('api_token');
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
