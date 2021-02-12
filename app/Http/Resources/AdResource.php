<?php

namespace App\Http\Resources;

use App\Http\Resources\CoachResource;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'ad' => parent::toArray($request),
            'coach' => new CoachResource($this->coach),
            'student' => new StudentResource($this->student),
        ];
    }
}
