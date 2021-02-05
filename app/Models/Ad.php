<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'student_id',
        'coaching_date',
        'description',
        'status',
        'ad_rating',
        'duration',
        'hourly_rate',
        'comments'
    ];

}
