<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Show the login page
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // Show the registration page
    public function showRegister(): View
    {
        return view('auth.register');
    }

    // Handle the login process
    public function login(Request $request): RedirectResponse
    {
        // 1. Validate the user input
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Attempt to log the user in
        if (Auth::attempt($validated, $request->boolean('remember'))) {
            // Success: Regenerate session to prevent attacks
            $request->session()->regenerate();

            // Restore cart from database
            \App\Http\Controllers\CartController::restoreCartSession(Auth::user());

            // Redirect to the dashboard based on user role
            return $this->redirectToDashboard(Auth::user())
                ->with('success', 'Welcome back!');
        }

        // Failure: Go back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle the registration process
    public function register(Request $request): RedirectResponse
    {
        // 1. Validate the registration data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:buyer,seller'],
            'shop_name' => ['required_if:role,seller', 'nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Create the new user in the database
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'shop_name' => $validated['shop_name'] ?? null,
            'password' => Hash::make($validated['password']), // Hash the password for security
        ]);

        // 3. Automatically log in the new user
        Auth::login($user);

        // Restore cart from database (though it's usually empty for new user, good for consistency)
        \App\Http\Controllers\CartController::restoreCartSession($user);

        // 4. Redirect to their new dashboard
        return $this->redirectToDashboard($user)
            ->with('success', 'Account created successfully!');
    }

    // Handle the logout process
    public function logout(Request $request): RedirectResponse
    {
        // Log the user out of the application
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Go back to the homepage
        return redirect()->route('home');
    }

    // Redirect user to their specific dashboard based on role
    protected function redirectToDashboard(User $user): RedirectResponse
    {
        if ($user->isSeller()) {
            return redirect()->route('seller.home');
        }

        return redirect()->route('buyer.home');
    }
}
