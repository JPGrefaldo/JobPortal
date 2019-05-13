<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlagMessageResource;
use App\Models\PendingFlagMessage;

class FlagMessageController extends Controller
{
    public function index(PendingFlagMessage $pendingFlagMessages)
    {
        return FlagMessageResource::collection($pendingFlagMessages->where([
            'status'         => PendingFlagMessage::UNAPPROVED,
            'disapproved_at' => null,
        ])->get());
    }
}
