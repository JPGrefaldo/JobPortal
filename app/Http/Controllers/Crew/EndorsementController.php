<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use App\Models\Endorsement;
use Illuminate\Http\Request;

class EndorsementController extends Controller
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
        return Endorsement::create([
            'crew_position_id' => $crewPosition->id,
            'endorser_email'   => $request->endorser_email,
        ]);
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
        //
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
        return Endorsement::update($request);
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
