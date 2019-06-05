<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThreadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($threads)
    {
        $user = auth()->user();

        return [
            'id'                  => $this->id,
            'subject'             => $this->creator()->id === $user->id ? $this->participantsString($user->id, ['first_name', 'last_name']) : $this->creator()->full_name,
            'unreadMessagesCount' => $this->userUnreadMessagesCount($user->id),
            'updated_at'          => $this->updated_at,
        ];
    }
}
