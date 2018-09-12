<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Models\Endorsement;
use App\Models\EndorsementRequest;
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
        $crew = auth()->user()->crew;
        if ($endorsementRequest->isRequestedBy($crew)) {
            return redirect(
                route('crew_position.show', $endorsementRequest->position)
            );
        }

        if ($endorsementRequest->isApprovedBy($crew)) {
            return redirect(route('endorsements.edit', ['endorsementRequest' => $endorsementRequest]));
        }

        // show form to comment
        return view('crew.endorsement.create', compact('endorsementRequest'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EndorsementRequest $endorsementRequest, Request $request)
    {
        $crew = auth()->user()->crew;
        if ($endorsementRequest->isRequestedBy($crew)) {
            return response()->json(
                ['errors' => ['email' => ['You can\'t endorse yourself.']]],
                403
            );
        }

        if ($endorsementRequest->endorsementBy($crew)) {
            return response()->json(
                ['errors' => 'You already approved this endorsement.'],
                403
            );
        }

        return $crew->approve($endorsementRequest, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Endorsement $endorsement
     * @return \Illuminate\Http\Response
     */
    public function edit(EndorsementRequest $endorsementRequest)
    {
        $endorsement = $endorsementRequest->endorsementBy(auth()->user());

        // TODO: endorsee_is_redirected_to_endorsement_create_page_when_editing_non_existent_endorsement

        return view('crew.endorsement.edit', compact(
            'endorsementRequest',
            'endorsement'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Endorsement $endorsement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EndorsementRequest $endorsementRequest)
    {
        $crew = auth()->user()->crew;
        $endorsement = $endorsementRequest->endorsementBy($crew);
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
     * @param  \App\Endorsement $endorsement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Endorsement $endorsement)
    {
        // TODO: discuss if endorsement deletion is a thing
    }
}
