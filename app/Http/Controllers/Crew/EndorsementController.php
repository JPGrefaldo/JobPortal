<?php

namespace App\Http\Controllers\Crew;

use App\EndorsementRequest;
use App\Http\Controllers\Controller;
use App\Models\Endorsement;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EndorsementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Position $position)
    {
        // return Endorsement::where('position_id', $position->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EndorsementRequest $endorsementRequest)
    {
        // show form to comment
        // if user already approved request, redirect to edit form for comment
        return view('endorsement.create')->with($endorsementRequest);
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
            ->where('endorser_id', Auth::id())->first();

        if (!$endorsement) {
            $endorsement = Endorsement::create([
                'endorsement_request_id' => $endorsementRequest->id,
                'endorser_id'            => Auth::id(),
                'approved_at'            => Carbon::now(),
                'comment'                => $request['comment'],
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
        // $endorsement->approved_at = Carbon::now()->toDateTimeString();
        // $endorsement->save();
        // return view('crew.endorsement.edit', $endorsement)->with('endorsement', $endorsement);
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
