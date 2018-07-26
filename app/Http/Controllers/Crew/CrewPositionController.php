<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Models\CrewPosition;
use Illuminate\Http\Request;

class CrewPositionController extends Controller
{
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
}
