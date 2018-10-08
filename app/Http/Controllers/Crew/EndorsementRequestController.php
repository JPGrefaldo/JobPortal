<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEndorsementRequestRequest;
use App\Mail\EndorsementRequestEmail;
use App\Models\CrewPosition;
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
        foreach ($this->filterEndorsers($request->endorsers) as $endorser) {
            $endorsement = $this->endorsementRequest->endorsements()->create([
                'endorser_name'  => $endorser['name'],
                'endorser_email' => $endorser['email'],
            ]);

            // send email
            // TODO: defer to queue
            Mail::to($endorser['email'])
                ->send(new EndorsementRequestEmail($endorsement));
        }

        return response('Emails Sent');
    }

    protected function filterEndorsers($endorsers)
    {
        $endorserCollection = collect($endorsers);
        $emails = $endorserCollection->pluck('email');
        $pastEndorsers = $this->endorsementRequest
            ->endorsements()
            ->whereIn('endorser_email', $emails)
            ->get(['endorser_email'])
            ->pluck('endorser_email');

        return $endorserCollection->whereNotIn('email', $pastEndorsers);
    }
}
