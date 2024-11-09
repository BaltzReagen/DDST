<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;
    
    public $table = 'milestones';

    protected $fillable = [
        'id',
        'age_group',
        'domain',
        'isCritical',
        'description',
        'youtube_title',
        'key',
        'image',
    ];

    public function progress(): HasMany
    {
        return $this->hasMany(ScreeningMilestoneProgress::class);
    }
}
