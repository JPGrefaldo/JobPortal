<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();

        return view('crew.position.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Position $position)
    {
        $crew = auth()->user()->crew;

        // TODO: create test
        if ($crew->hasPosition($position)) {
            return redirect(route('crew_position.edit', $position));
        }

        return view('crew.position.create', compact('position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Position $position, Request $request)
    {
        // TODO: create validation test
        $validatedData = $request->validate([
            'details' => 'required',
            'union_description' => 'required',
        ]);
        $crew = auth()->user()->crew;

        if ($crew->hasPosition($position)) {
            return redirect(route('crew_position.edit'), $position);
        }

        $crew->applyFor($position, [
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
        // TODO: create test
        $crew = auth()->user()->crew;
        return view('crew.position.show', compact('position', 'crew'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        // TODO: create test
        return view('crew.position.edit', compact('position'));
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
        // TODO: create test
        $crewPosition::byCrewAndPosition(auth()->user()->crew, $position);

        $crewPosition->delete();
    }
}
