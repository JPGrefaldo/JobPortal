<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCrewRequest;
use App\Services\CrewsServices;
use Auth;
use Illuminate\Http\Request;

class CrewProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crew.profile.profile-index', [
            'user' => Auth::user()->load([
                'crew',
            ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crew.profile.profile-create', [
            'user' => Auth::user()->load([
                'crew',
            ]),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCrewRequest $request)
    {
        $data = $request->validated();

        if (! Auth::user()->crew) {
            app(CrewsServices::class)->processCreate($data, Auth::user());
        } else {
            app(CrewsServices::class)->processUpdate($data, Auth::user()->crew);
        }

        dd($request->all());
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
