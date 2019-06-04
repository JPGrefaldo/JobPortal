<?php

namespace App\Actions\Admin;

use App\Models\PendingFlagMessage;
use Illuminate\Support\Carbon;

class DisapproveFlagMessage
{
    /**
     * @param PendingFlagMessage $pendingFlagMessage
     */
    public function execute(PendingFlagMessage $pendingFlagMessage): void
    {
        $pendingFlagMessage->update([
            'disapproved_at' => Carbon::now(),
            'status'         => PendingFlagMessage::UNAPPROVED,
        ]);

        $pendingFlagMessage->message->update([
            'flagged_at' => null,
        ]);

        $pendingFlagMessage->message->update([
            'flagged_at' => null,
        ]);
    }
}
