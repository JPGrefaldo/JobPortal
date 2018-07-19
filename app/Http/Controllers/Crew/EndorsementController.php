<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Mail\EndorsementRequestEmail;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EndorsementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Position $position)
    {
        return Endorsement::where('position_id', $position->id)->get();
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
        $endorsement = Endorsement::where('crew_position_id', $crewPosition->id)
            ->where('endorser_email', $request->endorser_email)
            ->first();

        // you can only ask an endorsement from an endorser once
        if ($endorsement) {
            return response("Hey, you already asked that person for an endorsement. Don't worry, we already sent him an email about your request.", 403);
        }

        $endorsement = Endorsement::create([
            'crew_position_id' => $crewPosition->id,
            'endorser_name'    => $request->endorser_name,
            'endorser_email'   => $request->endorser_email,
            'token'            => Endorsement::generateToken(),
        ]);

        // send the email to endorser
        Mail::to($endorsement->endorser_email)->send(new EndorsementRequestEmail($endorsement));

        return response('Horay! You have asked an endorsement from your contact. We sent him an email about this.');
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
        return view('endorsements.edit', $endorsement);
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
        return Endorsement::update([
            'approved_at' => Carbon::now(),
            'comment'     => $request->comment,
        ]);
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
