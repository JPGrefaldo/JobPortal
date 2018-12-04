<?php

namespace App\Http\Controllers\Crew\Endorsements;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEndorsementRequestRequest;
use App\Mail\EndorsementRequestEmail;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
use App\Models\Position;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EndorsementRequestController extends Controller
{
    public function destroy(EndorsementRequest $endorsementRequest)
    {
        if ($endorsementRequest->endorsement->crewPosition->crew->user->id != auth()->user()->id) {
            throw new Exception('Cannot delete');
        }

        $endorsementRequest->endorsement->update([
            'deleted_at' => Carbon::now()
        ]);

        $endorsementRequest->update([
            'deleted_at' => Carbon::now(),
        ]);

        return response('');
    }
}
