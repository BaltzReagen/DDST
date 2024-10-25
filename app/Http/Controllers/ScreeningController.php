<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Milestone;
use App\Models\User;
use App\Models\ScreeningMilestoneProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        // Calculate child's age in months
        $childDob = Carbon::parse($request->input('dob'));
        $currentDate = Carbon::now();
        $ageInMonths = $childDob->diffInMonths($currentDate);

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
        $screening = Screening::create([
            'user_id' => $userId, // Either guest or authenticated user ID
            'fname' => $request->input('fname'),
            'child_name' => $request->input('child_name'),
            'child_dob' => $request->input('dob'),
            'child_age_in_months' => $ageInMonths, // Save calculated age in months
            'child_gender' => $request->input('gender'),
        ]);

        // Redirect to the questionnaire page with the screening's child ID
        return redirect()->route('questionnaire.show', ['childId' => $screening->id]);
    }


    public function showQuestionnaire($screeningId) {
        // Fetch the screening data for the guest or registered user
        $screening = Screening::findOrFail($screeningId); // Fetch screening based on ID
        $childAgeInMonths = $screening->child_age_in_months; // Child's age in months from screening data
    
        // Determine the appropriate checklist based on child's age
        $milestoneAgeGroups = [1, 3, 6, 9, 12, 18, 24, 36, 48, 60, 72]; // Age groups in months
        $selectedAgeGroup = 1; // Default to 1 month
    
        foreach (array_reverse($milestoneAgeGroups) as $ageGroup) {
            if ($childAgeInMonths >= $ageGroup) {
                $selectedAgeGroup = $ageGroup;
                break;
            }
        }
    
        // Fetch milestone questions based on the selected age group
        $milestoneQuestions = Milestone::where('age_group', $selectedAgeGroup)->get();
    
        // Only fetch distinct domains that have questions for the selected age group
        $domainsWithQuestions = Milestone::where('age_group', $selectedAgeGroup)
                                ->distinct()
                                ->pluck('domain');
    
        // Format title to display '1 year' instead of '12 months'
        $formattedTitle = $selectedAgeGroup >= 12 ? ($selectedAgeGroup / 12) . ' Year' : $selectedAgeGroup . ' Month';
    
        // Pass the data to the view
        return view('questionnaire', [
            'child_age_in_months' => $formattedTitle,
            'milestoneQuestions' => $milestoneQuestions,
            'domains' => $domainsWithQuestions, // Only pass domains with questions
        ]);
    }

    public function submitMilestone(Request $request) {
        $screeningId = 1; // Replace with the actual screening_id if applicable
        $milestones = $request->input('milestones'); // Array of milestone_id => response
    
        // Encode the milestones array to JSON
        $responseJson = json_encode($milestones);
    
        // Save responses in a single row
        ScreeningMilestoneProgress::updateOrCreate(
            ['screening_id' => $screeningId],
            ['responses' => $responseJson]
        );
    
        return redirect()->route('thank.you')->with('success', 'Milestone responses saved successfully.');
    }
}