<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEndorsementRequestRequest;
use App\Mail\EndorsementRequestEmail;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
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
        $crew = auth()->user()->crew;
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $this->endorsementRequest = EndorsementRequest::firstOrCreate(
            ['crew_position_id' => $crewPosition->id],
            ['token' => EndorsementRequest::generateToken()]
        );

        // filter endorsers, only notify them once
        if ($this->endorsementRequest->isAskedToEndorse($request['email'])) {
            return response()->json([
                'errors' => [
                    'email' => ['We already sent ' . $request['email'] . ' a request'],
                ],
                'message' => 'We already sent ' . $request['name'] . ' a request'
            ], 422);
        }

        $endorsement = Endorsement::create([
            'endorsement_request_id' => $this->endorsementRequest->id,
            'endorser_id' => null,
            'endorser_name' => $request['name'],
            'endorser_email' => $request['email'],
        ]);

        // TODO: defer to queue
        Mail::to($request['email'])
            ->send(new EndorsementRequestEmail($endorsement));

        return response()->json([
            'message' => 'Success!',
        ]);
    }
}
