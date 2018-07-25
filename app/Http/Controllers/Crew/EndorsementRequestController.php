<?php

namespace App\Http\Controllers\Crew;

use App\EndorsementRequest;
use App\Http\Controllers\Controller;
use App\Mail\EndorsementRequestEmail;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EndorsementRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CrewPosition $crewPosition, Request $request)
    {
        $endorsementRequest = EndorsementRequest::where([
            'crew_position_id' => $crewPosition->id,
        ])->first();

        if (!$endorsementRequest) {
            $endorsementRequest = EndorsementRequest::create([
                'crew_position_id' => $crewPosition->id,
                'token'            => EndorsementRequest::generateToken(),
            ]);
        }

        // filter endorsers, only notify them once
        $endorsers = request('endorsers');
        foreach ($endorsers as $endorser) {
            $endorsement = Endorsement::where('endorsement_request_id', $endorsementRequest->id)
                ->where('endorser_email', $endorser['email'])
                ->first();

            if (!$endorsement) {
                $endorsement = Endorsement::create([
                    'endorsement_request_id' => $endorsementRequest->id,
                    'endorser_name'          => $endorser['name'],
                    'endorser_email'         => $endorser['email'],
                ]);

                // send email
                Mail::to($endorsement->endorser_email)->send(new EndorsementRequestEmail($endorsement));
            }
        }

        // return statuses foreach endorser
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EndorsementRequest  $endorsementRequest
     * @return \Illuminate\Http\Response
     */
    public function show(EndorsementRequest $endorsementRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EndorsementRequest  $endorsementRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(EndorsementRequest $endorsementRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EndorsementRequest  $endorsementRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EndorsementRequest $endorsementRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EndorsementRequest  $endorsementRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(EndorsementRequest $endorsementRequest)
    {
        //
    }
}
