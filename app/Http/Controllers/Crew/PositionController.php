<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\CrewPosition;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Position::all();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Position $position, Request $request)
    {
        // find crew position
        $crew = auth()->user()->crew;
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        if ($crewPosition) {
            return redirect(route('crew_position.edit'), $position);
        }

        $position->crews()->save($crew, [
            'details'           => $request['details'],
            'union_description' => $request['union_description'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('crew.position.show')->with('position', $position);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        //
    }
}
