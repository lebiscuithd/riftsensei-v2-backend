<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'comments',
        'total_price'
    ];

    public function coach()
    {
        return $this->belongsTo(User::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class);
    }

}
