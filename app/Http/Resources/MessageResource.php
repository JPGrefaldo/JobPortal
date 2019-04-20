<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'body'      => $this->body,
            'user_id'   => $this->user->id,
            'user_name' => $this->user->nickname_or_fullname,
            'id'        => $this->id,
        ];
    }
}
