<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $existingUser = User::where('google_id', $googleUser->id)
                                ->orWhere('email', $googleUser->email)
                                ->first();
            
            if ($existingUser) {
                if (empty($existingUser->google_id)) {
                    $existingUser->update([
                        'google_id' => $googleUser->id
                    ]);
                }
                
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'username' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => encrypt('my-google'),
                    'isGuest' => false
                ]);
                
                Auth::login($newUser);
            }
            
            return redirect()->route('dashboard');
            
        } catch (Exception $e) {
            return redirect()->route('login')
                           ->with('error', 'Something went wrong with Google login!');
        }
    }
}