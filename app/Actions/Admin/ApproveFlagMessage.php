<?php

namespace App\Actions\Admin;

use App\Models\PendingFlagMessage;
use Illuminate\Support\Carbon;

class ApproveFlagMessage
{
    /**
     * @param \App\Models\PendingFlagMessage $pendingFlagMessage
     */
    public function execute(PendingFlagMessage $pendingFlagMessage): void
    {
        $pendingFlagMessage->approved_at = Carbon::now();
        $pendingFlagMessage->save();

        $message = $pendingFlagMessage->message;

        $message->flagged_at = Carbon::now();
        $message->save();
    }
}
