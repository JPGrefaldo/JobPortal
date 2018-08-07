<?php

namespace App\Http\Controllers\Crew;

use App\EndorsementRequest;
use App\Exceptions\ElectoralFraud;
use App\Http\Controllers\Controller;
use App\Models\Endorsement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EndorsementController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EndorsementRequest $endorsementRequest)
    {
        if ($endorsementRequest->isOwnedBy(Auth::user())) {
            return redirect(route('crew_position.show', $endorsementRequest->position));
        }

        if ($endorsementRequest->isApprovedBy(Auth::user())) {
            return redirect(route('endorsement.edit', ['endorsementRequest' => $endorsementRequest]));
        }

        // show form to comment
        return view('crew.endorsement.create')->with('endorsementRequest', $endorsementRequest);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EndorsementRequest $endorsementRequest, Request $request)
    {
        $endorsement = Endorsement::where('endorsement_request_id', $endorsementRequest->id)
            ->where('endorser_email', Auth::user()->email)->first();

        if ($endorsementRequest->isRequestedBy(Auth::user())) {
            throw new ElectoralFraud('You can\'t endorse yourself.');
        }

        if (!$endorsement) {
            $endorsement = Endorsement::create([
                'endorsement_request_id' => $endorsementRequest->id,
                'endorser_id' => Auth::id(),
                'endorser_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                'endorser_email' => Auth::user()->email,
                'approved_at' => Carbon::now(),
                'comment' => $request['comment'],
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Endorsement  $endorsement
     * @return \Illuminate\Http\Response
     */
    public function edit(Endorsement $endorsement)
    {
        return view('crew.endorsement.create')->with('endorsementRequest', $endorsementRequest)->with('endorsement', $endorsement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Endorsement  $endorsement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Endorsement $endorsement)
    {
        // return Endorsement::update([
        //     'approved_at' => Carbon::now(),
        //     'comment'     => $request->comment,
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Endorsement  $endorsement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Endorsement $endorsement)
    {
        //
    }
}
