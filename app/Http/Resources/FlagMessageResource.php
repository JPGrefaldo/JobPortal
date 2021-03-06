<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlagMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'message_id'     => $this->message_id,
            'reason'         => $this->reason,
            'approved_at'    => $this->approved_at,
            'disapproved_at' => $this->disapproved_at,
            'message_owner'  => $this->message->user->nickname,
            'message'        => $this->message->body,
            'thread'         => $this->message->thread->subject,
        ];
    }
}
