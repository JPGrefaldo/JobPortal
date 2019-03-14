<?php

namespace App\Http\Controllers\Crew\Endorsements;

use App\Http\Controllers\Controller;
use App\Models\EndorsementRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class EndorsementRequestController extends Controller
{
    public function destroy(EndorsementRequest $endorsementRequest)
    {
        if ($endorsementRequest->endorsement->crewPosition->crew->user->id != auth()->user()->id) {
            throw new Exception('Cannot delete');
        }

        $endorsementRequest->endorsement->update([
            'deleted_at' => Carbon::now(),
        ]);

        $endorsementRequest->update([
            'deleted_at' => Carbon::now(),
        ]);

        return response('');
    }
}
