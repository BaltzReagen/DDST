<?php

namespace App\Listeners;

use App\Models\ScreeningHistory;
use App\Models\ScreeningMilestoneProgress;
use Illuminate\Auth\Events\Registered;

class MoveScreeningToHistory
{
    public function handle(Registered $event)
    {
        $user = $event->user;
        
        // Find any guest screenings associated with this user
        $guestScreenings = ScreeningMilestoneProgress::whereHas('screening', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        foreach ($guestScreenings as $progress) {
            $screening = $progress->screening;
            
            // Create screening history entry
            ScreeningHistory::create([
                'user_id' => $user->id,
                'fname' => $screening->fname,
                'child_name' => $screening->child_name,
                'child_dob' => $screening->child_dob,
                'child_age_in_months' => $screening->child_age_in_months,
                'child_gender' => $screening->child_gender,
                'milestone_responses' => json_decode($progress->responses, true),
                'has_delay' => $progress->has_delay,
                'developmental_age' => $screening->child_age_in_months
            ]);

            // Delete the old progress record
            $progress->delete();
        }
    }
}