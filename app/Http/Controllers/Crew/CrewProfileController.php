<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCrewRequest;
use App\Services\CrewsServices;
use App\Services\SocialLinksServices;
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
        $user = Auth::user()->load([
            'crew'
        ]);
        return view('crew.profile.profile-index', [
            'user' => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user()->load([
                'crew'
            ]);
        return view('crew.profile.profile-create', [
            'user' => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user)

            
        ]);
    }

    /**
     * Get all the social link type via service.
     *
     * @return App\Models\SocialLinkType
     */
    public function getAllSocialLinkTypes($user){
        $socialLinkTypes =  app(SocialLinksServices::class)->getAllSocialLinkTypes();
        $socialLinkTypes = app(CrewsServices::class)->mergeSocialLinkAndCrewData($user->crew->socials , $socialLinkTypes);
        return $socialLinkTypes;
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
        $user = Auth::user();
        $new = (! $user->crew);

        if ($new) {
            app(CrewsServices::class)->processCreate($data, $user);
        } else {
            app(CrewsServices::class)->processUpdate($data, $user->crew);
        }

        return back()->with('infoMessage', ($new) ? 'Created' : 'Updated');
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
