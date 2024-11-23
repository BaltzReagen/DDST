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
use Illuminate\Support\Str;

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
    public function handleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            \Log::info('Google user retrieved', ['email' => $googleUser->email]);
            
            // Check if user exists with this email
            $existingUser = User::where('email', $googleUser->email)->first();
            
            if ($existingUser) {
                \Log::info('Existing user found', ['id' => $existingUser->id]);
                // Check if this user was created via regular registration
                if (!$existingUser->google_id) {
                    return redirect()->route('login')
                        ->with('error', 'Emel ini telah didaftarkan menggunakan kaedah pendaftaran biasa. Sila log masuk menggunakan kata laluan anda.');
                }
                
                Auth::login($existingUser);
                
                try {
                    $this->transferGuestScreenings($existingUser);
                } catch (\Exception $e) {
                    \Log::error('Error transferring guest screenings: ' . $e->getMessage());
                }
                
                return redirect()->route('dashboard');
            }

            // Create new user
            $newUser = User::create([
                'username' => $this->generateUniqueUsername($googleUser->name),
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => bcrypt(Str::random(16)),
                'isGuest' => false
            ]);

            Auth::login($newUser);
            
            try {
                $this->transferGuestScreenings($newUser);
            } catch (\Exception $e) {
                \Log::error('Error transferring guest screenings: ' . $e->getMessage());
            }
            
            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Ralat semasa log masuk menggunakan Google. Sila cuba lagi.');
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
        // Get all guest screenings from screening_milestone_progress
        $guestScreenings = \App\Models\ScreeningMilestoneProgress::whereHas('screening', function($query) {
            $query->whereHas('user', function($q) {
                $q->where('isGuest', true);
            });
        })->get();

        foreach ($guestScreenings as $guestScreening) {
            $screening = $guestScreening->screening;
            
            // Create new screening history record
            \App\Models\ScreeningHistory::create([
                'user_id' => $user->id,
                'screening_id' => $screening->id,
                'first_screening_id' => $guestScreening->first_screening_id,
                'fname' => $screening->fname,
                'child_name' => $screening->child_name,
                'child_dob' => $screening->child_dob,
                'child_age_in_months' => $screening->child_age_in_months,
                'child_gender' => $screening->child_gender,
                'milestone_responses' => $guestScreening->responses,
                'checklist_age' => $guestScreening->checklist_age,
                'has_delay' => $guestScreening->has_delay,
                'developmental_age' => $guestScreening->developmental_age
            ]);

            // Delete the guest screening progress
            $guestScreening->delete();
            
            // Delete the guest user and screening
            if ($screening->user && $screening->user->isGuest) {
                $screening->user->delete();
            }
            $screening->delete();
        }
    }

}