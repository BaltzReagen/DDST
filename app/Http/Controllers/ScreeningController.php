<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ScreeningController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'fname' => 'required|string|max:255',
            'child_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:M,F'
        ]);

        // If the user is not authenticated, create a guest user
        if (!Auth::check()) {
            $guestUser = User::create([
                'username' => 'guest_' . Str::random(8), // Generate a random username for the guest
                'password' => bcrypt(Str::random(16)), // Generate a random password for the guest
                'isGuest' => true, // Mark this user as a guest
                'email' => null, // No email for guest users
            ]);

            $userId = $guestUser->id;
        } else {
            $userId = Auth::id(); // Use the logged-in user's ID
        }

        // Save the data to the screenings table
        Screening::create([
            'user_id' => Auth::id(), // Assuming the user is authenticated
            'fname' => $request->input('fname'),
            'child_name' => $request->input('child_name'),
            'child_dob' => $request->input('dob'),
            'child_gender' => $request->input('gender')
        ]);

        // Redirect or show a success message
        return redirect()->back()->with('success', 'Test has been submitted successfully.');
    }
}

