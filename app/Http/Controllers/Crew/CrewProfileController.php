<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\StoreCrew;
use App\Actions\Crew\UpdateCrew;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCrewRequest;
use App\Services\DepartmentsServices;
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
            'crew',
        ]);

        $resume_url = '';
        if (isset($user->crew->resumes->where('general', 1)->first()->url)) {
            $resume_url = $user->crew->resumes->where('general', 1)->first()->url;
        }

        return view('crew.profile.profile-index', [
            'user'            => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user),
            'departments'     => $this->getDepartments(),
            'crewPositions'   => $this->getCrewPositions($user),
            'resume_url'      => $resume_url,
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
            'crew',
        ]);

        return view('crew.profile.profile-create', [
            'user'            => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user),
            'departments'     => $this->getDepartments(),
        ]);
    }

    /**
     * Get all the social link type via service.
     *
     * @return App\Models\SocialLinkType
     */
    public function getAllSocialLinkTypes($user)
    {
        $socialLinkTypes =  app(SocialLinksServices::class)->getAllSocialLinkTypeWithCrew($user);
        return $socialLinkTypes;
    }

    /**
     * @return \App\Services\DepartmentsServices[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDepartments()
    {
        $departments = app(DepartmentsServices::class)->getAllWithPositions();
        return $departments;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function getCrewPositions($user)
    {
        $positions =  $user->crew->positions;
        return $positions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCrewRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCrewRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        app(StoreCrew::class)->execute($user, $data);

        return back()->with('infoMessage', 'Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user()->load([
            'crew',
        ]);
        return view('crew.profile.profile-show', compact('user'));
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
     * @param  CreateCrewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCrewRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        app(UpdateCrew::class)->execute($user->crew, $data);

        return back()->with('infoMessage', 'Updated');
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
