<?php

namespace App\Http\Controllers\Crew;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCrewRequest;
use App\Services\CrewsServices;
use App\Services\SocialLinksServices;
use App\Services\DepartmentsServices;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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

        $resume_url = '';
        if(isset($user->crew->resumes->where( 'general',1)->first()->url)){
            $resume_url = $user->crew->resumes->where( 'general',1)->first()->url;
        }

        return view('crew.profile.profile-index', [
            'user' => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user),
            'departments' => $this->getDepartments(),
            'resume_url' => $resume_url,
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
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user),
            'departments' => $this->getDepartments()
        ]);
    }

    /**
     * Get all the social link type via service.
     *
     * @return App\Models\SocialLinkType
     */
    public function getAllSocialLinkTypes($user){
        $socialLinkTypes =  app(SocialLinksServices::class)->getAllSocialLinkTypeWithCrew($user);
        return $socialLinkTypes;
    }

    public function getDepartments(){
        $departments = app(DepartmentsServices::class)->getAllWithPositions();
        return $departments;
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
