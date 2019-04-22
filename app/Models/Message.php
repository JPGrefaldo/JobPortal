<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Message as VendorMessage;

class Message extends VendorMessage
{
    /**
     * @var array
     */
    protected $fillable = ['thread_id', 'user_id', 'body', 'created_at'];
}
