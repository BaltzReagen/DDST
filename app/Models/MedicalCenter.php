<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalCenter extends Model
{
    use HasFactory;
    public $table = 'medical_center';

    protected $fillable = [
        'id',
        'medical_center_name',
        'state',
        'contact',
    ];
}
