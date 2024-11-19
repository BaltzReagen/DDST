<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'user_id',
        'fname',           // Add this line
        'child_name',
        'child_dob',
        'child_age_in_months',
        'child_gender',
        'checklist_age',
        'has_delay',
        'checklist_ages'
    ];

    protected $casts = [
        'has_delay' => 'boolean',
        'checklist_ages' => 'array'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function answers()
    {
        return $this->hasMany(ScreeningAnswer::class);
    }

    public function milestoneProgress()
    {
        return $this->hasOne(ScreeningMilestoneProgress::class);
    }
}