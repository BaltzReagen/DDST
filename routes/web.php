<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScreeningController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
Route::get('/questionnaire/{childId}', [ScreeningController::class, 'showQuestionnaire'])->name('questionnaire.show');
Route::post('/submit-milestone', [ScreeningController::class, 'submitMilestone'])->name('submit.milestone');

//Thank You Page
Route::get('/thank-you', function () {
    return view('thankyou'); // Ensure you have a thankyou.blade.php view file.
})->name('thank.you');

//Back Button
Route::get('/form', function () {
    return view('form');
})->name('form');