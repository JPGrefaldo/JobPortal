<?php

namespace App\Http\Controllers\Crew\Endorsements;

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
                route('crew.endorsement.position.show', $endorsementRequest->position)
            );
        }

        if ($endorsementRequest->isApprovedBy($crew)) {
            return redirect(route('endorsements.edit', $endorsementRequest));
        }

        $endorseeName = $endorsementRequest->endorsee->user->full_name;
        $position = $endorsementRequest->position->name;

        return view('crew.endorsement.create', compact(
            'endorsementRequest',
            'endorseeName',
            'position'
        ));
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
                ['errors' => ['email' => ['You already approved this endorsement.']]],
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
        $crew = auth()->user()->crew;
        $endorsement = $endorsementRequest->endorsementBy($crew);

        if (! $endorsement) {
            return redirect(route('endorsements.create', $endorsementRequest));
        }

        $endorseeName = $endorsementRequest->endorsee->user->full_name;
        $position = $endorsementRequest->position->name;

        return view('crew.endorsement.edit', compact(
            'endorsementRequest',
            'endorsement',
            'endorseeName',
            'position'
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

        if (! $endorsement) {
            return response()->json(
                ['errors' => 'Endorsement doesn\'t exist.'],
                403
            );
        }

        $endorsement->comment = $request->comment;
        $endorsement->save();

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
    }
}
