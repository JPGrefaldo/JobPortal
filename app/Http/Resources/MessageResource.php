<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'body'      => $this->body,
            'user_id'   => $this->user->hash_id,
            'user_name' => $this->user->nickname_or_fullname,
        ];
    }
}
