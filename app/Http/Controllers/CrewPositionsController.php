<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function createPositionProduction()
    {
        $validatedData = $request->validate([
        'title' => 'required|max:255',
        'bio' => 'required',
        'resume_file' => 'nullable',
        'reel_file' => 'nullable',
        ]);

       $crew_position = new CrewPosition;
       $crew_position->crew_id = $user->id;

        if ($request->title == '1st Assistant Director') {
            $post_id = 1;
        } else {
            $post_id = 2;
        }

        $crew_position->position_id = $post_id;
        $crew_position->details = $request->biography;
        $crew_position->union_description = $request->biography;
        $crew_position->save();

         return back();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
