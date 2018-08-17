<?php

namespace App\Http\Controllers\Crew;

use App\Models\EndorsementRequest;
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
        if ($endorsementRequest->isRequestedBy(Auth::user())) {
            return redirect(route('crew_position.show', $endorsementRequest->position));
        }

        if ($endorsementRequest->isApprovedBy(Auth::user())) {
            return redirect(route('endorsements.edit', ['endorsementRequest' => $endorsementRequest]));
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
        if ($endorsementRequest->isRequestedBy(auth()->user())) {
            // TODO: defer to model
            throw new ElectoralFraud('You can\'t endorse yourself.');
            // TODO: respond with errors instead
        }

        $endorsement = $endorsementRequest->endorsementBy(auth()->user())->first();

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

        // respond with sucess
        // TODO: create test for success
        return $endorsement;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Endorsement  $endorsement
     * @return \Illuminate\Http\Response
     */
    public function edit(EndorsementRequest $endorsementRequest)
    {
        $endorsement = $endorsementRequest->endorsementBy(auth()->user());

        // TODO: endorsee_is_redirected_to_endorsement_create_page_when_editing_non_existent_endorsement

        return view('crew.endorsement.edit')->with('endorsementRequest', $endorsementRequest)->with('endorsement', $endorsement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Endorsement  $endorsement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EndorsementRequest $endorsementRequest)
    {
        $endorsement = $endorsementRequest->endorsementBy(auth()->user())->first();
        // TODO: create test for this
        if (! $endorsement) {
            return redirect()->back();
        }
        $endorsement->comment = $request->comment;
        $endorsement->save();
        // TODO: test resonse on update
        return $endorsement;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Endorsement  $endorsement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Endorsement $endorsement)
    {
        // TODO: discuss if endorsement deletion is a thing
    }
}
