<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Screening;
use App\Models\ScreeningHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // First try to find user by google_id
            $user = User::where('google_id', $googleUser->id)->first();
            
            // If not found by google_id, try to find by email
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    // Update existing user with google_id
                    $user->update([
                        'google_id' => $googleUser->id
                    ]);
                } else {
                    // Create new user with unique username
                    $username = $this->generateUniqueUsername($googleUser->name);
                    $user = User::create([
                        'username' => $username,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => encrypt('dummy-password'),
                        'isGuest' => false
                    ]);
                }
            }

            Auth::login($user);
            return redirect()->route('dashboard');

        } catch (Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Google login failed. Please try again.');
        }
    }

    /**
     * Generate a unique username based on the Google name
     */
    private function generateUniqueUsername($name)
    {
        $baseUsername = str_replace(' ', '', $name); // Remove spaces
        $username = $baseUsername;
        $counter = 1;

        // Keep checking and incrementing until we find a unique username
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Transfer guest screenings to user's screening history
     */
    private function transferGuestScreenings($user)
    {
        // Get the guest user's screenings from the current session
        $screeningId = session('screening_id');
        if ($screeningId) {
            $screening = Screening::with('milestoneProgress')->find($screeningId);
            
            if ($screening) {
                // Create new screening history entry
                ScreeningHistory::create([
                    'user_id' => $user->id,
                    'fname' => $screening->fname,
                    'child_name' => $screening->child_name,
                    'child_dob' => $screening->child_dob,
                    'child_age_in_months' => $screening->child_age_in_months,
                    'child_gender' => $screening->child_gender,
                    'milestone_responses' => $screening->milestoneProgress ? 
                        json_decode($screening->milestoneProgress->responses, true) : null,
                    'has_delay' => session('has_delay_' . $screeningId, false),
                    'developmental_age' => session('final_developmental_age_' . $screeningId, 
                        $screening->child_age_in_months)
                ]);

                // Clean up guest data
                if ($screening->user && $screening->user->isGuest) {
                    $screening->user->delete(); // Delete guest user
                }
                $screening->delete(); // Delete original screening
            }
        }

        // Clear session data
        session()->forget([
            'screening_id',
            'has_delay_' . $screeningId,
            'final_developmental_age_' . $screeningId
        ]);
    }
}