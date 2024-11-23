<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register'); // Ensure you have a view named 'register.blade.php'
    }

    public function create(Request $request)
    {
        // First check if email is already used by a Google account
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->google_id) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Emel ini telah didaftarkan menggunakan Google. Sila gunakan butang "Login dengan Google" untuk log masuk.']);
        }

        // Validate the registration data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'isGuest' => false
        ]);

        // Transfer any guest screenings
        $this->transferGuestScreenings($user);

        // Redirect to the login page with success message
        return redirect()
            ->route('login')
            ->with('success', 'Pendaftaran berjaya! Sila log masuk.');
    }

    private function transferGuestScreenings($user)
    {
        // Get all guest screenings from screening_milestone_progress
        $guestScreenings = \App\Models\ScreeningMilestoneProgress::whereHas('screening', function($query) {
            $query->whereHas('user', function($q) {
                $q->where('isGuest', true);
            });
        })->get();

        foreach ($guestScreenings as $guestScreening) {
            try {
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
            } catch (\Exception $e) {
                \Log::error('Error transferring guest screening: ' . $e->getMessage());
                continue;
            }
        }
    }
}

