<?php

namespace App\Actions\Admin;

use App\Models\PendingFlagMessage;
use Illuminate\Support\Carbon;

class ApproveFlagMessage
{
    /**
     * @param PendingFlagMessage $pendingFlagMessage
     */
    public function execute(PendingFlagMessage $pendingFlagMessage): void
    {
        $pendingFlagMessage->update([
            'approved_at' => Carbon::now(),
            'status'      => PendingFlagMessage::APPROVED,
        ]);

        $pendingFlagMessage->message->flagged_at = Carbon::now();
        $pendingFlagMessage->message->save();
    }
}
