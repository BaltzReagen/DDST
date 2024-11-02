<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Screening;
use App\Models\ScreeningHistory;

class MoveScreeningToHistory
{
    public function handle(Registered $event)
    {
        $user = $event->user;

        if ($user->isGuest) {
            $screenings = Screening::where('user_id', $user->id)->get();

            foreach ($screenings as $screening) {
                ScreeningHistory::create([
                    'user_id' => $user->id,
                    'fname' => $screening->fname,
                    'child_name' => $screening->child_name,
                    'child_dob' => $screening->child_dob,
                    'child_age_in_months' => $screening->child_age_in_months,
                    'child_gender' => $screening->child_gender,
                    'responses' => $screening->milestoneProgress->responses,
                    'screening_date' => $screening->created_at->toDateString(),
                    'screening_result' => $this->determineResult($screening->milestoneProgress->responses),
                ]);

                $screening->delete();
            }

            // Update the user status
            $user->isGuest = false;
            $user->save();
        }
    }

    private function determineResult($responses)
    {
        // Custom logic to determine screening result based on responses
        return 'pass'; // or other result based on your conditions
    }
}

