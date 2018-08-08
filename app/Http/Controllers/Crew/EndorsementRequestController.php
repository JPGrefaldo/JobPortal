<?php

namespace App\Http\Controllers\Crew;

use App\EndorsementRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEndorsementRequestRequest;
use App\Mail\EndorsementRequestEmail;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EndorsementRequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Position $position, StoreEndorsementRequestRequest $request)
    {
        $crewPosition = CrewPosition::byCrewAndPosition(Auth::user()->crew, $position)->first();

        $endorsementRequest = EndorsementRequest::where([
            'crew_position_id' => $crewPosition->id,
        ])
            ->first();

        if (!$endorsementRequest) {
            $endorsementRequest = EndorsementRequest::create([
                'crew_position_id' => $crewPosition->id,
                'token' => EndorsementRequest::generateToken(),
            ]);
        }

        // filter endorsers, only notify them once
        $endorsers = request('endorsers');
        foreach ($endorsers as $endorser) {
            if (!$endorsement = Endorsement::where('endorsement_request_id', $endorsementRequest->id)
                ->where('endorser_email', $endorser['email'])
                ->first()
            ) {
                $endorsement = Endorsement::create([
                    'endorsement_request_id' => $endorsementRequest->id,
                    'endorser_name' => $endorser['name'],
                    'endorser_email' => $endorser['email'],
                ]);

                // send email
                Mail::to($endorsement->endorser_email)
                    ->send(new EndorsementRequestEmail($endorsement));
            }
        }
        // TODO: return statuses foreach endorser
        return ['done'];
    }
}
