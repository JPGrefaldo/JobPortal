<?php

namespace App\Http\Controllers\Crew;

use App\Models\CrewPosition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrewPositionController extends Controller
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
    public function store(Request $request)
    {
        return CrewPosition::create($request->validate());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CrewPosition  $crewPosition
     * @return \Illuminate\Http\Response
     */
    public function show(CrewPosition $crewPosition)
    {
        return view('crew.crew_position');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CrewPosition  $crewPosition
     * @return \Illuminate\Http\Response
     */
    public function edit(CrewPosition $crewPosition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CrewPosition  $crewPosition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CrewPosition $crewPosition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CrewPosition  $crewPosition
     * @return \Illuminate\Http\Response
     */
    public function destroy(CrewPosition $crewPosition)
    {
        //
    }
}
