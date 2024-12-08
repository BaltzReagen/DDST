<?php

namespace App\Http\Controllers;

use App\Models\Screening;
use App\Models\ScreeningHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ScreeningHistoryController extends Controller
{
    public function index()
    {
        $screenings = ScreeningHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($screening) {
                return [
                    'id' => $screening->id,
                    'child_name' => $screening->child_name,
                    'created_at' => $screening->created_at,
                    'child_age_in_months' => $screening->child_age_in_months,
                    'has_delay' => $screening->has_delay,
                    'checklist_age' => $screening->checklist_age
                ];
            });

        return view('screening-history', compact('screenings'));
    }

    private function getPreviousAgeGroup($currentAge)
    {
        $ageGroups = [1, 3, 6, 9, 12, 18, 24, 36, 48, 60];
        $currentIndex = array_search($currentAge, $ageGroups);
        
        return $currentIndex > 0 ? $ageGroups[$currentIndex - 1] : null;
    }

    /**
     * Display the specified screening.
     */
    public function show($id)
    {
        $screening = ScreeningHistory::findOrFail($id);
        
        if ($screening->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->route('screening.result', ['screeningId' => $screening->id]);
    }

    /**
     * Delete the specified screening.
     */
    public function destroy($id)
    {
        $screening = ScreeningHistory::findOrFail($id);
        
        // Optional: Add authorization check
        // if ($screening->user_id !== Auth::id()) {
        //     abort(403);
        // }

        $screening->delete();

        return redirect()->route('screening.history')
            ->with('success', 'Rekod saringan telah berjaya dipadamkan.');
    }

    public function showResult($id)
    {
        $screening = ScreeningHistory::findOrFail($id);
        
        // Ensure user can only access their own screenings
        if ($screening->user_id !== auth()->id()) {
            abort(403);
        }

        $hasDelay = $screening->has_delay;
        $developmentalAge = $screening->developmental_age;
        $isViewingHistory = true;
        
        $healthcareCenter = $hasDelay ? (object)[
            'name' => 'Klinik Kesihatan Putrajaya Presint 9',
            'address' => 'Jalan P9E, Presint 9',
            'postal_code' => '62250',
            'city' => 'Putrajaya',
            'state' => 'W.P. Putrajaya',
            'latitude' => 2.9235,
            'longitude' => 101.6965
        ] : null;

        return view('result', compact('screening', 'hasDelay', 'healthcareCenter', 'developmentalAge', 'isViewingHistory'));
    }
}