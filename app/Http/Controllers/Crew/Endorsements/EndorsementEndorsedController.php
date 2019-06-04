<?php

namespace App\Http\Controllers\Crew\Endorsements;

use App\Actions\Endorsement\GetEndorsements;
use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\JsonResponse;

class EndorsementEndorsedController extends Controller
{
    /**
     * @param Position $position
     * @return JsonResponse
     */
    public function index(Position $position)
    {
        $endorsements = app(GetEndorsements::class)->execute(auth()->user(), $position, true);

        return response()->json($endorsements->toArray());
    }
}
