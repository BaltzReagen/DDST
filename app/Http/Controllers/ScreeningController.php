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


    public function showQuestionnaire($screeningId, $ageGroup = null) {
        $screening = Screening::findOrFail($screeningId);
        $childAgeInMonths = $screening->child_age_in_months;
    
        // Determine the age group if not provided
        $selectedAgeGroup = $ageGroup ?? $this->determineAgeGroup($childAgeInMonths);
    
        // Fetch milestone questions based on the selected age group
        $milestoneQuestions = Milestone::where('age_group', $selectedAgeGroup)->get();
        $domainsWithQuestions = Milestone::where('age_group', $selectedAgeGroup)
                                    ->distinct()
                                    ->pluck('domain');
    
        return view('questionnaire', [
            'screeningId' => $screeningId,
            'child_age_in_months' => (int)$selectedAgeGroup, // Cast to integer
            'milestoneQuestions' => $milestoneQuestions,
            'domains' => $domainsWithQuestions,
        ]);
    }
    
    // Helper function to determine the closest age group based on child's age
    private function determineAgeGroup($childAgeInMonths) {
        $milestoneAgeGroups = [1, 3, 6, 9, 12, 18, 24, 36, 48, 60, 72];
        $selectedAgeGroup = 1;
    
        if ($childAgeInMonths > 72) {
            return 72;
        }
    
        foreach (array_reverse($milestoneAgeGroups) as $ageGroup) {
            if ($childAgeInMonths >= $ageGroup) {
                $selectedAgeGroup = $ageGroup;
                break;
            }
        }
    
        return $selectedAgeGroup;
    }

    public function submitMilestone(Request $request) {
        $screeningId = $request->input('screening_id');

        // Ensure screeningId exists and is valid
        if (!$screeningId || !Screening::find($screeningId)) {
            return redirect()->back()->withErrors(['error' => 'Invalid screening ID']);
        }

        $milestones = $request->input('milestones'); // Array of milestone_id => response
        
        // Check responses for critical and non-critical milestones
        $criticalFailed = 0;
        $nonCriticalFailed = 0;
        
        foreach ($milestones as $milestoneId => $response) {
            $milestone = Milestone::find($milestoneId);
            
            if ($response == 0) { // 'Not Yet' response
                if ($milestone->isCritical) {
                    $criticalFailed++;
                } else {
                    $nonCriticalFailed++;
                }
            }
        }
        
        // Save the current responses in a new row in ScreeningMilestoneProgress
        ScreeningMilestoneProgress::create([
            'screening_id' => $screeningId,
            'responses' => json_encode($milestones),
        ]);
        
        // Check if we need to go back to a previous checklist
        if ($criticalFailed >= 1 || $nonCriticalFailed >= 2) {
            // Determine the previous age group to use
            $currentAgeGroup = Milestone::where('id', array_keys($milestones)[0])->value('age_group');
            $previousAgeGroup = $this->getPreviousAgeGroup($currentAgeGroup);
    
            if ($previousAgeGroup) {
                // Redirect to the previous checklist
                return redirect()->route('questionnaire.show', ['childId' => $screeningId, 'ageGroup' => $previousAgeGroup])
                                 ->with('status', 'Please try the previous checklist.');
            }
        }
        
        // Redirect to the results page with a "Developing as Expected" message if no previous checklist was needed
        return redirect()->route('thank.you')->with('status', 'The child is developing as expected.');
    }
    
    // Helper function to determine the previous age group
    private function getPreviousAgeGroup($currentAgeGroup) {
        $milestoneAgeGroups = [72, 60, 48, 36, 24, 18, 12, 9, 6, 3, 1]; // Age groups in months in descending order
    
        foreach ($milestoneAgeGroups as $index => $ageGroup) {
            if ($ageGroup == $currentAgeGroup && isset($milestoneAgeGroups[$index + 1])) {
                return $milestoneAgeGroups[$index + 1]; // Return the previous age group
            }
        }
    
        return null; // No previous age group (already at the lowest age group)
    }
    
}