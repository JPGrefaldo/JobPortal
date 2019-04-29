<?php

namespace App\Actions\Admin;

use App\Models\PendingFlagMessage;
use Illuminate\Support\Carbon;

class DisapproveFlagMessage
{
    /**
     * @param \App\Models\PendingFlagMessage $pendingFlagMessage
     */
    public function execute(PendingFlagMessage $pendingFlagMessage): void
    {
        $pendingFlagMessage->update([
            'disapproved_at' => Carbon::now(),
        ]);

        $pendingFlagMessage->message->flagged_at = null;
        $pendingFlagMessage->message->save();
    }
}
