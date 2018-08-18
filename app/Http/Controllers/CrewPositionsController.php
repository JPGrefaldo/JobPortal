<?php

namespace App\Http\Controllers;

use App\Models\CrewPosition;
use App\Models\CrewReel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CrewPositionsController extends Controller
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
    public function createPosition(User $user, Request $request)
    {
        $validatedData = $request->validate([
        'title' => 'required',
        'biography' => 'required',
        'resume_file' => 'nullable',
        'reel_file' => 'nullable',
        'union_details' => 'required',
        ]);

        $crew_position = new CrewPosition;
        $crew_position->crew_id = $user->id;
        /*$crew_position->name = $request->input('title');*/

        $title_submit = Position::where('name', $request->title)->first();
        $crew_position->position_id = $title_submit->id;
       
        $crew_position->details = $request->biography;   
        $crew_position->union_description = $request->union_details;     
        $crew_position->save();

        if ($request->hasFile('reel_file')) {
            $reel_fileName = "fileName".time().'.'.request()->reel_file->getClientOriginalExtension();
            $user_reel = Storage::putFile('reels', $request->file('reel_file'));
            $user_reel_filepath = 'reel/' . $reel_fileName;

            if (count(CrewReel::where('crew_id', $user->id)->first()) > 0) {
                $save_reel = CrewReel::where('crew_id', $user->id)->first();
                $save_reel->url = $user_reel_filepath;
                $save_reel->save();
            } else {
                $new_reel = new CrewReel;
                $new_reel->crew_id = $user->id;
                $new_reel->url  = $user_reel_filepath;
                $new_reel->crew_position_id = $title_submit->id;
                $new_reel->save();
            }
        }



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
