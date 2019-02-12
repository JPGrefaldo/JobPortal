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
        $pendingFlagMessage->disapproved_at = Carbon::now();

        $pendingFlagMessage->save();
    }
}
