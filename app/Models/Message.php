<?php

namespace App\Models;

use Cmgmyr\Messenger\Models\Message as VendorMessage;

class Message extends VendorMessage
{
    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = ['thread_id', 'user_id', 'body', 'created_at'];
}
