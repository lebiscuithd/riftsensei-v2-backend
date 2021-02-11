<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LaneResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'admin' => $this->admin,
            'verified_coach' => $this->verified_coach,
            'wallet' => $this->wallet,
            'description' => $this->description,
            'pedagogy' => $this->pedagogy,
            'avatar' => $this->avatar,
            'coaching_hours' => $this->coaching_hours,
            'coach_rating' => $this->coach_rating,
            'coaching_hours_spent' => $this->coaching_hours_spent,
            'opgg_link' => $this->opgg_link,
            'twitter_link' => $this->twitter_link,

            'rank' => $this->rank,
            'lanes' => LaneResource::collection($this->lanes)
        ];

    }
}
