<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public route (no authentication required)
Route::get('/test-public', function () {
    return response()->json(['message' => 'Public API is working']);
});

// Protected route (requires authentication)
Route::middleware('auth:api')->get('/test-auth', function (Request $request) {
    return response()->json([
        'message' => 'You are authenticated!',
        'user' => $request->user()
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Passport OAuth routes
Route::prefix('oauth')->group(function () {
    Route::post('/token', [AccessTokenController::class, 'issueToken'])->middleware(['throttle']);
    Route::get('/authorize', [AuthorizationController::class, 'authorize']);
    Route::post('/authorize', [AuthorizationController::class, 'approve']);
    Route::delete('/authorize', [AuthorizationController::class, 'deny']);
});
