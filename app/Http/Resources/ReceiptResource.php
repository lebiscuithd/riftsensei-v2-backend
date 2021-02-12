<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
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
            'user' =>
                [
                'user_id' => $this->user->id,
                'username' => $this->user->username,
                'email' => $this->user->email,
                    ],
            'product' => $this->product
        ];
    }
}
