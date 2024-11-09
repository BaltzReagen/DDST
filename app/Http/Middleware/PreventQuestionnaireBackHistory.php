<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreventQuestionnaireBackHistory
{
    public function handle(Request $request, Closure $next)
    {
        // Check if questionnaire is completed or if there's no screening in progress
        if (Session::has('questionnaire_completed') || !Session::has('screening_in_progress')) {
            return redirect()->route('form');
        }

        $response = $next($request);
        
        return $response->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                    ->header('Pragma','no-cache')
                    ->header('Expires','0')
                    ->header('X-Frame-Options', 'DENY');
    }
}