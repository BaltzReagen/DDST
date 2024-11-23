<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreeningHistory extends Model
{
    protected $fillable = [
        'user_id',
        'fname',
        'child_name',
        'child_dob',
        'child_age_in_months',
        'child_gender',
        'milestone_responses',
        'checklist_age',
        'has_delay',
        'developmental_age',
        'first_screening_id'
    ];

    protected $casts = [
        'milestone_responses' => 'array',
        'has_delay' => 'boolean',
        'child_dob' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function screening()
    {
        return $this->belongsTo(Screening::class);
    }

    public function firstScreening()
    {
        return $this->belongsTo(Screening::class, 'first_screening_id');
    }
}