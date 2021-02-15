<?php

namespace App\Http\Resources;

use App\Http\Resources\RankResource;
use Illuminate\Http\Resources\Json\JsonResource;

class coachResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'verified_coach' => $this->verified_coach,
            'avatar' => $this->avatar,
            'coach_rating' => $this->coach_rating,
            'rank' => new RankResource($this->rank),
            'lanes' => LaneResource::collection($this->lanes)
        ];
    }
}
