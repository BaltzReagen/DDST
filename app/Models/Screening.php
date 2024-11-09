<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'fname', 'child_name', 'child_dob', 'child_age_in_months', 'child_gender'];

    public function milestoneProgress()
    {
        return $this->hasMany(ScreeningMilestoneProgress::class, 'screening_id');
    }
}
