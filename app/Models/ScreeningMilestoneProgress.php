<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ScreeningMilestoneProgress extends Model
{
    use HasFactory;

    protected $table = 'screening_milestone_progress';
    
    protected $fillable = [
        'screening_id',
        'first_screening_id',
        'responses',
        'is_achieved',
        'has_delay',
        'checklist_age',
        'developmental_age'
    ];

    protected $casts = [
        'responses' => 'json',
        'has_delay' => 'boolean',
    ];

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class, 'milestone_id');
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