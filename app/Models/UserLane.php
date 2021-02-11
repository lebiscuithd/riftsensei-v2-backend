<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLane extends Model
{
    use HasFactory;

    public $table = 'user_lanes';

    protected $fillable = [
        'user_id', 'lane_id'
    ];
}
