<?php

namespace App\Actions\User;

use App\Mail\MessageFlagged;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class FlagMessage
{
    /**
     * @param User $user
     * @param string $password
     */
    public function execute($message)
    {
        $message->flagged_at = Carbon::now();
        $message->save();

        Mail::to('admin@admin.com')->send(new MessageFlagged($message));
    }
}
