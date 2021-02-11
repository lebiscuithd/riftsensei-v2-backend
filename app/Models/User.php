<?php

namespace App\Models;

use App\Models\Rank;
use App\Models\Lane;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'rank_id',
        'verified_coach',
        'admin',
        'wallet',
        'twitter_link',
        'opgg_link',
        'avatar',
        'description',
        'pedagogy',
        'coaching_hours',
        'coach_rating',
        'coaching_hours_spent'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function lanes()
    {
        return $this->belongsToMany(
            Lane::class,
            'user_lanes',
            'user_id',
            'lane_id');
    }
}
