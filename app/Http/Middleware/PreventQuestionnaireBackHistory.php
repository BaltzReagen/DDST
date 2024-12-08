<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreventQuestionnaireBackHistory
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();
        
        \Log::debug('PreventQuestionnaireBackHistory Middleware', [
            'route' => $routeName,
            'session' => [
                'questionnaire_completed' => Session::has('questionnaire_completed'),
                'screening_in_progress' => Session::has('screening_in_progress')
            ]
        ]);

        // Always allow the retry route
        if ($routeName === 'questionnaire.retry') {
            return $next($request);
        }

        if (Session::has('questionnaire_completed') || !Session::has('screening_in_progress')) {
            return redirect()->route('form');
        }

        return $next($request);
    }
}