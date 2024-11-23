<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('login'); // Make sure to create this view
    }

    // Handle login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard'); // Redirect to the dashboard route
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
    
    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->google_id) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Emel ini telah didaftarkan menggunakan Google. Sila gunakan butang "Login dengan Google" untuk log masuk.'
                ]);
        }

        return Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        );
    }
}
