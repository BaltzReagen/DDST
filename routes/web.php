<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScreeningController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ScreeningHistoryController;


/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Default route
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Custom routes
// Form page
Route::get("form", function(){
    return view('form');
});

// Login and Registration routes using controllers
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('register.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

// Screening routes
Route::post('/screenings', [ScreeningController::class, 'store'])->name('screenings.store');

// Define the dashboard route
Route::get('/dashboard', function () {
    return view('dashboard'); // Ensure this points to your actual view file
})->name('dashboard')->middleware(['auth', 'no.cache']);

// Logout routes
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login'); // Redirect to the login page after logout
})->name('logout');

//Questionnaire
Route::get('/questionnaire/{childId}/{ageGroup?}', [ScreeningController::class, 'showQuestionnaire'])
    ->name('questionnaire.show')
    ->middleware('prevent-questionnaire-back');
Route::post('/submit-milestone', [ScreeningController::class, 'submitMilestone'])->name('submit.milestone');

//Thank You Page
Route::get('/thank-you', function () {
    return view('thankyou'); // Ensure you have a thankyou.blade.php view file.
})->name('thank.you');

//Back Button
Route::get('/form', function () {
    return view('form');
})->name('form');

//Result Screen
Route::get('/screening/{screeningId}/result', [ScreeningController::class, 'showResult'])
    ->name('screening.result')
    ->middleware('prevent-back');

// Result page actions (To be implemented later)
Route::get('/retake-test', function() {
    return redirect('form'); 
})->name('retake.test');

Route::get('/feedback', function() {
    return back(); 
})->name('feedback');

Route::get('/signup', function() {
    return redirect()->route('register'); 
})->name('signup');

//Print Result
Route::get('/print-result/{screeningId}', function($screeningId) {
    try {
        // First determine if this is a logged-in user's screening
        if (Auth::check() && !Auth::user()->isGuest) {
            // Get the screening history record
            $screening = App\Models\ScreeningHistory::findOrFail($screeningId);
            
            // Verify ownership
            if ($screening->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access');
            }

            // Get milestone responses directly from screening_history
            $responses = json_decode($screening->milestone_responses, true);
            if (!$responses) {
                throw new \Exception('No milestone responses found.');
            }

            // Get milestones
            $milestones = App\Models\Milestone::whereIn('id', array_keys($responses))
                ->orderBy('domain')
                ->get();

            $milestoneData = collect();
            foreach ($milestones as $milestone) {
                $response = $responses[$milestone->id];
                $milestoneData->push([
                    'milestone' => $milestone,
                    'is_achieved' => $response == 1 || $response === "1",
                    'status' => ($response == 1 || $response === "1") ? '/' : 'X'
                ]);
            }

            // Get all screening history for this user to check for previous attempts
            $previousScreenings = App\Models\ScreeningHistory::where('user_id', Auth::id())
                ->where('id', '<', $screeningId)
                ->orderBy('created_at', 'desc')
                ->get();

            // Process previous screenings
            $previousMilestonesData = [];
            foreach ($previousScreenings as $prevScreening) {
                $prevResponses = json_decode($prevScreening->milestone_responses, true);
                if (!$prevResponses) continue;

                $prevMilestones = App\Models\Milestone::whereIn('id', array_keys($prevResponses))
                    ->orderBy('domain')
                    ->get();
                
                foreach ($prevMilestones as $milestone) {
                    $ageGroup = $milestone->age_group;
                    $response = $prevResponses[$milestone->id];
                    
                    if (!($response == 1 || $response === "1")) {
                        if (!isset($previousMilestonesData[$ageGroup])) {
                            $previousMilestonesData[$ageGroup] = collect();
                        }
                        
                        $previousMilestonesData[$ageGroup]->push([
                            'milestone' => $milestone,
                            'is_achieved' => false,
                            'status' => 'X'
                        ]);
                    }
                }
            }

            ksort($previousMilestonesData);

            // Generate filename
            $timestamp = now()->format('Ymd_His');
            $childName = str_replace(' ', '_', $screening->child_name);
            $filename = "{$timestamp}_{$childName}_Screening_Result.pdf";

            \Log::info('Generating PDF for logged-in user:', [
                'screening_id' => $screeningId,
                'user_id' => Auth::id(),
                'milestone_count' => $milestoneData->count(),
                'has_delay' => $screening->has_delay
            ]);

            return PDF::loadView('printResult', [
                'screening' => $screening,
                'milestoneData' => $milestoneData,
                'previousMilestonesData' => $previousMilestonesData,
                'hasDelay' => $screening->has_delay,
                'ageGroup' => $screening->checklist_age
            ])->stream($filename);

        } else {
            // Guest user logic
            $allProgress = App\Models\ScreeningMilestoneProgress::where('screening_id', $screeningId)
                ->orderBy('created_at', 'desc')
                ->get();
            
            if ($allProgress->isEmpty()) {
                throw new \Exception('No milestone progress found.');
            }

            $screening = App\Models\Screening::find($screeningId);
            if (!$screening) {
                throw new \Exception('Screening not found.');
            }

            $latestProgress = $allProgress->first();
            $latestResponses = json_decode($latestProgress->responses, true);

            // Modified milestone data collection to explicitly set achievement status
            $milestoneData = collect();
            $milestones = App\Models\Milestone::whereIn('id', array_keys($latestResponses))
                ->orderBy('domain')
                ->get();
                
            foreach ($milestones as $milestone) {
                $response = $latestResponses[$milestone->id];
                $milestoneData->push([
                    'milestone' => $milestone,
                    'is_achieved' => $response == 1 || $response === "1",
                    'status' => ($response == 1 || $response === "1") ? '/' : 'X'
                ]);
            }

            // Modified previous milestones data collection
            $previousMilestonesData = [];
            $previousProgress = $allProgress->slice(1);
            
            foreach ($previousProgress as $progress) {
                $responses = json_decode($progress->responses, true);
                if (!$responses) continue;

                $previousMilestones = App\Models\Milestone::whereIn('id', array_keys($responses))
                    ->orderBy('domain')
                    ->get();
                
                foreach ($previousMilestones as $milestone) {
                    $ageGroup = $milestone->age_group;
                    $response = $responses[$milestone->id];
                    
                    if (!($response == 1 || $response === "1")) {
                        if (!isset($previousMilestonesData[$ageGroup])) {
                            $previousMilestonesData[$ageGroup] = collect();
                        }
                        
                        $previousMilestonesData[$ageGroup]->push([
                            'milestone' => $milestone,
                            'is_achieved' => false,
                            'status' => 'X'
                        ]);
                    }
                }
            }

            ksort($previousMilestonesData);

            // Generate filename
            $timestamp = now()->format('Ymd_His');
            $childName = str_replace(' ', '_', $screening->child_name);
            $filename = "{$timestamp}_{$childName}_Screening_Result.pdf";

            \Log::info('Generating PDF for guest:', [
                'screening_id' => $screeningId,
                'milestone_count' => $milestoneData->count(),
                'has_delay' => $latestProgress->has_delay
            ]);

            return PDF::loadView('printResult', [
                'screening' => $screening,
                'milestoneData' => $milestoneData,
                'previousMilestonesData' => $previousMilestonesData,
                'hasDelay' => $latestProgress->has_delay,
                'ageGroup' => $milestones->first()->age_group ?? null
            ])->stream($filename);
        }

    } catch (\Exception $e) {
        \Log::error('PDF Generation Error: ' . $e->getMessage(), [
            'screening_id' => $screeningId,
            'user_id' => Auth::check() ? Auth::id() : 'guest',
            'trace' => $e->getTraceAsString()
        ]);
        abort(500, 'Error generating PDF');
    }
})->name('print.result');

Route::middleware(['web'])->group(function () {
    Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])
        ->name('google.login');
    Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleCallback'])
        ->name('google.callback');
});

// Protected routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/privacy-policy', [App\Http\Controllers\PageController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-of-service', [App\Http\Controllers\PageController::class, 'termsOfService'])->name('terms.service');

Route::get('/terms', [App\Http\Controllers\PageController::class, 'termsOfService'])->name('terms');

// Screening History Routes
Route::middleware(['auth'])->group(function () {
    // View all screening history
    Route::get('/screening-history', [App\Http\Controllers\ScreeningHistoryController::class, 'index'])
        ->name('screening.history');

    // View specific screening result
    Route::get('/screening/{screening}/view', [App\Http\Controllers\ScreeningHistoryController::class, 'show'])
        ->name('screening.view');

    // Delete screening record
    Route::delete('/screening/{screening}', [App\Http\Controllers\ScreeningHistoryController::class, 'destroy'])
        ->name('screening.destroy');
});

Route::delete('/screening/{id}/delete', [App\Http\Controllers\ScreeningController::class, 'destroy'])
    ->name('screening.delete');

Route::middleware(['auth'])->group(function () {
    // Screening History routes
    Route::get('/screening-history', [ScreeningHistoryController::class, 'index'])->name('screening.history');
    Route::get('/screening/{id}/view', [ScreeningHistoryController::class, 'show'])->name('screening.view');
    Route::delete('/screening/{id}/delete', [ScreeningHistoryController::class, 'destroy'])->name('screening.delete');
});

Route::get('/screening-history/{id}/result', [ScreeningHistoryController::class, 'showResult'])
    ->name('screening.history.result')
    ->middleware('auth');