<?php

namespace App\Http\Controllers\Crew\Endorsements;

use App\Actions\Endorsement\GetEndorsements;
use App\Http\Controllers\Controller;
use App\Models\Position;

class EndorsementEndorsedController extends Controller
{
    /**
     * @param Position $position
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Position $position)
    {
        $endorsements = app(GetEndorsements::class)->execute(auth()->user(), $position, true);

        return response()->json($endorsements->toArray());
    }
}
