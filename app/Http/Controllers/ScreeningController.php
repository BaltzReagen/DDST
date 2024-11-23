<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\Milestone;
use App\Models\User;
use App\Models\ScreeningMilestoneProgress;
use App\Models\ScreeningHistory;
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
            'user_id' => $userId,
            'fname' => $request->input('fname'),  // Add this line
            'child_name' => $request->input('child_name'),
            'child_dob' => $request->input('dob'),
            'child_age_in_months' => $ageInMonths,
            'child_gender' => $request->input('gender')
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
        if (Session::has('questionnaire_completed')) {
            return redirect()->route('form');
        }

        $screeningId = $request->input('screening_id');
        $screening = Screening::findOrFail($screeningId);
        $submittedMilestones = $request->input('milestones', []);
        
        // Get or set first_screening_id from session
        $firstScreeningId = session('first_screening_id') ?? $screeningId;
        session(['first_screening_id' => $firstScreeningId]);

        \Log::info('Starting milestone submission:', [
            'screening_id' => $screeningId,
            'first_screening_id' => $firstScreeningId,
            'user_id' => Auth::id(),
            'is_guest' => Auth::guest()
        ]);

        // Calculate results
        $currentAgeGroup = Milestone::where('id', array_keys($submittedMilestones)[0])->value('age_group');
        $allMilestones = Milestone::where('age_group', $currentAgeGroup)->get();
        
        $criticalFailed = 0;
        $nonCriticalFailed = 0;
        $milestoneResponses = [];

        foreach ($allMilestones as $milestone) {
            $response = isset($submittedMilestones[$milestone->id]) ? 
                (int)$submittedMilestones[$milestone->id] : 0;
            
            $milestoneResponses[$milestone->id] = $response;

            if ($response == 0) {  // If milestone not achieved
                if ($milestone->isCritical) {
                    $criticalFailed++;
                } else {
                    $nonCriticalFailed++;
                }
            }
        }

        // Determine if there's a delay
        $hasDelay = ($criticalFailed > 0 || $nonCriticalFailed >= 2);

        // If there's a delay, check if there's a previous age group to test
        if ($hasDelay) {
            $previousAgeGroup = $this->getPreviousAgeGroup($currentAgeGroup);
            
            if ($previousAgeGroup) {
                // Store progress differently based on user type
                if (Auth::check() && !Auth::user()->isGuest) {
                    // For logged-in users, store in ScreeningHistory
                    $screeningHistory = ScreeningHistory::create([
                        'user_id' => Auth::id(),
                        'screening_id' => $screeningId,
                        'first_screening_id' => $firstScreeningId,
                        'fname' => $screening->fname,
                        'child_name' => $screening->child_name,
                        'child_dob' => $screening->child_dob,
                        'child_age_in_months' => $screening->child_age_in_months,
                        'child_gender' => $screening->child_gender,
                        'milestone_responses' => json_encode($milestoneResponses),
                        'checklist_age' => $currentAgeGroup,
                        'has_delay' => $hasDelay,
                        'developmental_age' => $currentAgeGroup
                    ]);
                } else {
                    // For guests, store in ScreeningMilestoneProgress
                    $milestoneProgress = ScreeningMilestoneProgress::create([
                        'screening_id' => $screeningId,
                        'first_screening_id' => $firstScreeningId,
                        'responses' => json_encode($milestoneResponses),
                        'checklist_age' => $currentAgeGroup,
                        'has_delay' => $hasDelay,
                        'developmental_age' => $currentAgeGroup
                    ]);
                }

                return redirect()->route('questionnaire.show', [
                    'childId' => $screeningId,
                    'ageGroup' => $previousAgeGroup
                ]);
            }
        }

        // If no delay or no previous age group available, store final results
        if (Auth::check() && !Auth::user()->isGuest) {
            $screeningHistory = ScreeningHistory::create([
                'user_id' => Auth::id(),
                'screening_id' => $screeningId,
                'first_screening_id' => $firstScreeningId,
                'fname' => $screening->fname,
                'child_name' => $screening->child_name,
                'child_dob' => $screening->child_dob,
                'child_age_in_months' => $screening->child_age_in_months,
                'child_gender' => $screening->child_gender,
                'milestone_responses' => json_encode($milestoneResponses),
                'checklist_age' => $currentAgeGroup,
                'has_delay' => $hasDelay,
                'developmental_age' => $currentAgeGroup
            ]);

            Session::forget(['first_screening_id', 'screening_in_progress']);
            Session::put('questionnaire_completed', true);
            
            return redirect()->route('screening.result', ['screeningId' => $screeningHistory->id]);
        } else {
            $milestoneProgress = ScreeningMilestoneProgress::create([
                'screening_id' => $screeningId,
                'first_screening_id' => $firstScreeningId,
                'responses' => json_encode($milestoneResponses),
                'checklist_age' => $currentAgeGroup,
                'has_delay' => $hasDelay,
                'developmental_age' => $currentAgeGroup
            ]);

            Session::forget(['first_screening_id', 'screening_in_progress']);
            Session::put('questionnaire_completed', true);
            
            return redirect()->route('screening.result', ['screeningId' => $screeningId]);
        }
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
        try {
            $screening = null;
            $allProgress = null;
            $developmentalAge = null;
            $hasDelay = false;

            if (Auth::check() && !Auth::user()->isGuest) {
                $screening = ScreeningHistory::where('id', $screeningId)
                    ->where('user_id', Auth::id())
                    ->first();

                if (!$screening) {
                    \Log::error('Could not find screening history record', [
                        'id' => $screeningId,
                        'user_id' => Auth::id()
                    ]);
                    abort(404, 'No screening history found');
                }

                // Get all related screening history records for this screening session
                $allScreeningHistory = ScreeningHistory::where('user_id', Auth::id())
                    ->where('first_screening_id', $screening->first_screening_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $allProgress = $allScreeningHistory->count();
                
                // Check if any screening in this session had a delay
                $hasDelay = $allScreeningHistory->contains('has_delay', true);
                // Use the developmental age from the last successful screening
                $developmentalAge = $allScreeningHistory->where('has_delay', false)->first()?->developmental_age 
                    ?? $screening->developmental_age;
            } else {
                $screening = Screening::findOrFail($screeningId);
            
                // Get all progress records for this screening session
                $allProgress = ScreeningMilestoneProgress::where('screening_id', $screeningId)
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                // Check if any screening had a delay
                $hasDelay = $allProgress->contains('has_delay', true);
                
                // Get the developmental age from the most recent progress record
                $developmentalAge = $allProgress->first()?->developmental_age ?? $screening->child_age_in_months;
            }

            $redirectUrl = Auth::check() && !Auth::user()->isGuest 
                ? route('dashboard') 
                : route('home');

            return view('result', compact(
                'screening',
                'hasDelay',
                'developmentalAge',
                'redirectUrl',
                'allProgress'
            ));

        } catch (\Exception $e) {
            \Log::error('Error showing screening result: ' . $e->getMessage());
            abort(404);
        }
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

    public function destroy($id)
    {
        $screening = Screening::findOrFail($id);
        
        // Check if the user owns this screening
        if (Auth::id() !== $screening->user_id) {
            abort(403);
        }
        
        $screening->delete();
        
        return redirect()
            ->route('screening.history')
            ->with('success', 'Rekod saringan telah berjaya dipadamkan.');
    }
}