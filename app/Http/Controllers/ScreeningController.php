<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Milestone;
use App\Models\User;
use App\Models\ScreeningMilestoneProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ScreeningController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->session()->has('questionnaire_completed')) {
                return redirect()->route('form')->with('error', 'Assessment already completed');
            }
            
            // Check if there's no screening in progress
            if (!$request->session()->has('screening_in_progress') && 
                $request->route()->getName() !== 'screenings.store') {
                return redirect()->route('form');
            }
            
            return $next($request);
        })->only(['showQuestionnaire', 'submitMilestone']);
    }

    public function store(Request $request)
    {

        Session::put('screening_in_progress', true);

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

    public function showQuestionnaire($childId, $ageGroup = null)
    {
        
        if (!Session::has('screening_in_progress')) {
            return redirect()->route('form');
        }
        // Find the screening record
        $screening = Screening::findOrFail($childId);

        // Check if this screening was completed
        if (session('completed_screening_' . $childId)) {
            return redirect()->route('screening.result', ['screeningId' => $childId])
                ->with('warning', 'This assessment has already been completed.');
        }

        $childAgeInMonths = $screening->child_age_in_months;

        // Determine the age group if not provided
        $selectedAgeGroup = $ageGroup ?? $this->determineAgeGroup($childAgeInMonths);

        // Fetch milestone questions based on the selected age group
        $milestoneQuestions = Milestone::where('age_group', $selectedAgeGroup)->get();
        
        // Get unique domains
        $domains = $milestoneQuestions->pluck('domain')->unique()->values();

        return view('questionnaire', [
            'childId' => $childId,
            'child_age_in_months' => (int)$selectedAgeGroup,
            'milestoneQuestions' => $milestoneQuestions,
            'domains' => $domains,
            'screening' => $screening
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

    public function submitMilestone(Request $request)
    {
        // Add this at the beginning of the method
        if (Session::has('questionnaire_completed')) {
            return redirect()->route('form');
        }

        $screeningId = $request->input('screening_id');
        $screening = Screening::findOrFail($screeningId);
        $milestones = $request->input('milestones');

        $criticalFailed = 0;
        $nonCriticalFailed = 0;
        
        foreach ($milestones as $milestoneId => $response) {
            $milestone = Milestone::find($milestoneId);
            if ($response == 0) {
                if ($milestone->isCritical) {
                    $criticalFailed++;
                } else {
                    $nonCriticalFailed++;
                }
            }
        }

        $hasDelay = ($criticalFailed >= 1 || $nonCriticalFailed >= 2);
        $currentAgeGroup = Milestone::where('id', array_keys($milestones)[0])->value('age_group');

        // Save the current responses with delay status
        ScreeningMilestoneProgress::create([
            'screening_id' => $screeningId,
            'responses' => json_encode($milestones),
            'has_delay' => $hasDelay
        ]);

        if ($hasDelay) {
            $previousAgeGroup = $this->getPreviousAgeGroup($currentAgeGroup);
            
            // If we're at 1 month checklist or no previous age group available
            if ($currentAgeGroup == 1 || !$previousAgeGroup) {
                session(['last_failed_age_group_' . $screeningId => $currentAgeGroup]);
                session(['has_delay_' . $screeningId => true]);
                session(['original_age_' . $screeningId => $screening->child_age_in_months]);
                session(['final_developmental_age_' . $screeningId => 0]); // Set to 0 to indicate less than 1 month
                
                Session::put('questionnaire_completed', true);
                session(['completed_screening_' . $screeningId => true]);
                
                return redirect()->route('screening.result', ['screeningId' => $screeningId]);
            }

            // Continue to previous age group if available
            session(['last_failed_age_group_' . $screeningId => $currentAgeGroup]);
            session(['has_delay_' . $screeningId => true]);
            session(['original_age_' . $screeningId => $screening->child_age_in_months]);
            
            return redirect()->route('questionnaire.show', [
                'childId' => $screeningId,
                'ageGroup' => $previousAgeGroup
            ])->with('status', 'Please complete the previous age group checklist.');
        }

        // Update developmental age and completion status
        $developmentalAge = session('last_failed_age_group_' . $screeningId) ? $currentAgeGroup : $screening->child_age_in_months;
        $screening->update(['child_age_in_months' => $developmentalAge]);
        
        Session::put('questionnaire_completed', true);
        session(['completed_screening_' . $screeningId => true]);
        session(['has_delay_' . $screeningId => $hasDelay]);
        session(['final_developmental_age_' . $screeningId => $developmentalAge]);

        Session::forget('screening_in_progress');
        Session::put('questionnaire_completed', true);
        
        return redirect()->route('screening.result', ['screeningId' => $screeningId]);
    }
    
    // Helper function to determine the previous age group
    private function getPreviousAgeGroup($currentAgeGroup) {
        $milestoneAgeGroups = [72, 60, 48, 36, 24, 18, 12, 9, 6, 3, 1];
    
        foreach ($milestoneAgeGroups as $index => $ageGroup) {
            if ($ageGroup == $currentAgeGroup && isset($milestoneAgeGroups[$index + 1])) {
                return $milestoneAgeGroups[$index + 1];
            }
        }
    
        return null;
    }

    public function showResult($screeningId)
    {
        $screening = Screening::with('milestoneProgress')->findOrFail($screeningId);
        
        // If they had to do a previous age group test, they have a delay
        $hasDelay = session('last_failed_age_group_' . $screeningId) !== null;
        
        $developmentalAge = session('final_developmental_age_' . $screeningId, $screening->child_age_in_months);
        $originalAge = session('original_age_' . $screeningId, $screening->child_age_in_months);
        
        $healthcareCenter = $hasDelay ? (object)[
            'name' => 'Klinik Kesihatan Putrajaya Presint 9',
            'address' => 'Jalan P9E, Presint 9',
            'postal_code' => '62250',
            'city' => 'Putrajaya',
            'state' => 'W.P. Putrajaya',
            'latitude' => 2.9235,
            'longitude' => 101.6965
        ] : null;

        return Response::view('result', [
            'screening' => $screening,
            'hasDelay' => $hasDelay,
            'healthcareCenter' => $healthcareCenter,
            'developmentalAge' => $developmentalAge,
            'originalAge' => $originalAge
        ])
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    }

    private function getNearestHealthcareCenter()
    {
        // For now, return a dummy healthcare center
        return (object)[
            'name' => 'Klinik Kesihatan Putrajaya Presint 9',
            'address' => 'Jalan P9E, Presint 9',
            'postal_code' => '62250',
            'city' => 'Putrajaya',
            'state' => 'W.P. Putrajaya'
        ];
    }
}