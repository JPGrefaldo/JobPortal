<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlagMessageResource;
use App\Models\PendingFlagMessage;

class FlagMessagesController extends Controller
{
    public function index(PendingFlagMessage $pendingFlagMessages)
    {
        return FlagMessageResource::collection($pendingFlagMessages->where([
            'approved_at'    => null,
            'disapproved_at' => null
        ])->get());
    }
}
