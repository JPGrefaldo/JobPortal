<?php

namespace App\Http\Controllers\Crew;

use App\EndorsementRequest;
use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use Illuminate\Http\Request;

class EndorsementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
    public function store(CrewPosition $crewPosition, Request $request)
    {
        // $endorsement = Endorsement::where('crew_position_id', $crewPosition->id)
        //     ->where('endorser_name', $request->endorser_name)
        //     ->where('endorser_email', $request->endorser_email)
        //     ->first();

        // // you can only ask an endorsement from the same endorser once
        // if ($endorsement) {
        //     return response("Hey, you already asked that person for an endorsement. Don't worry, we already sent him an email about your request.", 403);
        // }

        // $endorsement = Endorsement::create([
        //     'crew_position_id' => $crewPosition->id,
        //     'endorser_name'    => $request->endorser_name,
        //     'endorser_email'   => $request->endorser_email,
        //     'token'            => Endorsement::generateToken(),
        // ]);

        // // send the email to endorser
        // Mail::to($endorsement->endorser_email)->send(new EndorsementRequestEmail($endorsement));

        // return response('Horay! You have asked an endorsement from your contact. We sent him an email about this.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Endorsement  $endorsement
     * @return \Illuminate\Http\Response
     */
    public function show(Endorsement $endorsement)
    {
        //
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
