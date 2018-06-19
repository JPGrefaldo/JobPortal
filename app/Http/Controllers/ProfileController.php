<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $user = App\Models\User::first();
    $position = App\Models\CrewPosition::first();
    $jobTitle = App\Models\Position::first();
    $fb = App\Models\CrewSocial::where('social_link_type_id','=',1)->first();
    $imdb = App\Models\CrewSocial::where('social_link_type_id','=',5)->first();

     return view('profile.my-profile-edit', compact('user','position', 'jobTitle', 'fb', 'imdb'));   
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
    
    $user = App\Models\User::first();
    $position = App\Models\CrewPosition::first();
    $jobTitle = App\Models\Position::first();
    $fb = App\Models\CrewSocial::where('social_link_type_id','=',1)->first();
    $imdb = App\Models\CrewSocial::where('social_link_type_id','=',5)->first();

     return view('profile.my-profile-edit', compact('user','position', 'jobTitle', 'fb', 'imdb'));   
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
