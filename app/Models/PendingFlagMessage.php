<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Message;
use Illuminate\Database\Eloquent\Model;

class PendingFlagMessage extends Model
{
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
