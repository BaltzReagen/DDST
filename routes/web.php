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
// Change the unnamed route to a named route
Route::get('/print-result/{screeningId}', function($screeningId) {
    try {
        // Get ALL milestone progress records for this screening
        $allProgress = App\Models\ScreeningMilestoneProgress::where('screening_id', $screeningId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($allProgress->isEmpty()) {
            throw new \Exception('No milestone progress found.');
        }

        // Get the latest progress
        $latestProgress = $allProgress->first();
        $latestResponses = json_decode($latestProgress->responses, true);
        
        // Debug all responses
        \Log::info('All Progress Records:', [
            'count' => $allProgress->count(),
            'records' => $allProgress->map(function($progress) {
                return [
                    'id' => $progress->id,
                    'responses' => json_decode($progress->responses, true),
                    'has_delay' => $progress->has_delay,
                    'created_at' => $progress->created_at
                ];
            })
        ]);

        // Get milestones for the latest progress
        $milestoneData = collect();
        $milestones = App\Models\Milestone::whereIn('id', array_keys($latestResponses))
            ->orderBy('domain')
            ->get();
            
        foreach ($milestones as $milestone) {
            $milestoneData->push([
                'milestone' => $milestone,
                'is_achieved' => $latestResponses[$milestone->id] === "1"
            ]);
        }

        // Process ALL previous milestone data
        $previousMilestonesData = [];
        
        // Get all previous progress records (excluding the latest)
        $previousProgress = $allProgress->slice(1);
        
        foreach ($previousProgress as $progress) {
            $responses = json_decode($progress->responses, true);
            if (!$responses) continue;

            // Get milestones for this progress
            $previousMilestones = App\Models\Milestone::whereIn('id', array_keys($responses))
                ->orderBy('domain')
                ->get();
            
            foreach ($previousMilestones as $milestone) {
                $ageGroup = $milestone->age_group;
                
                // Only add failed milestones
                if ($responses[$milestone->id] === "0") {
                    if (!isset($previousMilestonesData[$ageGroup])) {
                        $previousMilestonesData[$ageGroup] = collect();
                    }
                    
                    $previousMilestonesData[$ageGroup]->push([
                        'milestone' => $milestone,
                        'is_achieved' => false
                    ]);
                }
            }
        }

        // Sort by age group
        ksort($previousMilestonesData);

        \Log::info('Previous Milestones Data:', [
            'age_groups' => array_keys($previousMilestonesData),
            'milestones_per_group' => collect($previousMilestonesData)->map->count(),
            'total_failed' => collect($previousMilestonesData)->sum->count()
        ]);

        return PDF::loadView('printResult', [
            'screening' => App\Models\Screening::find($screeningId),
            'milestoneData' => $milestoneData,
            'previousMilestonesData' => $previousMilestonesData,
            'hasDelay' => $latestProgress->has_delay,
            'ageGroup' => $milestones->first()->age_group ?? null
        ])->stream('screening_result.pdf');

    } catch (\Exception $e) {
        \Log::error('PDF Generation Error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        abort(500, 'Error generating PDF');
    }
})->name('print.result');

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('google.callback');


Route::get('/privacy-policy', [App\Http\Controllers\PageController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-of-service', [App\Http\Controllers\PageController::class, 'termsOfService'])->name('terms.service');

Route::get('/terms', [App\Http\Controllers\PageController::class, 'termsOfService'])->name('terms');

