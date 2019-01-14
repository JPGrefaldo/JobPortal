<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Message;
use Illuminate\Database\Eloquent\Model;

class PendingFlagMessage extends Model
{
    /**
     * The protected attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
