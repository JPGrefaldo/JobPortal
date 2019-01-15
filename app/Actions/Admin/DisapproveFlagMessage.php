<?php

namespace App\Actions\Admin;

use App\Models\PendingFlagMessage;
use Illuminate\Support\Carbon;

class DisapproveFlagMessage
{
    public function execute(PendingFlagMessage $pendingFlagMessage)
    {
        $pendingFlagMessage->disapproved_at = Carbon::now();
        $pendingFlagMessage->save();
    }
}
