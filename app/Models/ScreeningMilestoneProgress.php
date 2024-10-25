<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningMilestoneProgress extends Model
{
    protected $table = 'screening_milestone_progress';
    protected $fillable = ['screening_id', 'responses'];

    // Specify that 'responses' should be cast to JSON for easy access in code
    protected $casts = [
        'responses' => 'json',
    ];
}