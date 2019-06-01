<?php

namespace App\Http\Controllers\Crew;

use App\Actions\Crew\DeleteCrewProfilePhoto;
use App\Actions\Crew\StoreCrew;
use App\Actions\Crew\StoreCrewPhoto;
use App\Actions\Crew\UpdateCrew;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCrewRequest;
use App\Http\Requests\CreatePhotoRequest;
use App\Models\Crew;
use App\Models\CrewReel;
use App\Models\CrewResume;
use App\Models\SocialLinkType;
use App\Models\User;
use App\Services\DepartmentsServices;
use Auth;

class CrewProfileController extends Controller
{
    /**
     * shows the logged in user's crew profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->load([
            'crew',
            'crew.reels',
            'crew.resumes',
        ]);

        return view('crew.profile.profile-index', [
            'user'            => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user),
            'departments'     => $this->getDepartments(),
            'crewPositions'   => $this->getCrewPositions($user),
            'resume_url'      => $user->crew->getGeneralResumeLink(),
            'reelPath'        => $user->crew->getGeneralReelLink(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect(route('crew.profile.edit'));
    }

    /**
     * Get all the social link type via service.
     *
     * @return App\Models\SocialLinkType
     */
    public function getAllSocialLinkTypes($user)
    {
        $socialLinkTypes = SocialLinkType::with(['crew' => function ($q) use ($user) {
            $q->where('crew_id', $user->crew->id)->get();
        }])->get();

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
     * @param CreateCrewRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(CreateCrewRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        app(StoreCrew::class)->execute($user, $data);

        return redirect(route('crew.profile.edit'))->with('infoMessage', 'Created');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreatePhotoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storePhoto(CreatePhotoRequest $request)
    {
        disable_debugbar();
        $data = $request->validated();
        $crew = Auth::user()->crew;
        app(StoreCrewPhoto::class)->execute($crew, $data);

        return response('');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyPhoto(Crew $crew)
    {
        app(DeleteCrewProfilePhoto::class)->execute($crew);
    }

    /**
     * Display the specified resource.
     * Shows another crew's profile that is not of the logged in user
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $resume_url = '';
        if (isset($user->crew->resumes->where('general', 1)->first()->url)) {
            $resume_url = $user->crew->resumes->where('general', 1)->first()->url;
        }

        return view('crew.profile.profile-show', [
            'user'            => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user),
            'departments'     => $this->getDepartments(),
            'crewPositions'   => $this->getCrewPositions($user),
            'resume_url'      => $resume_url,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user()->load([
            'crew',
        ]);

        $resume = $user->crew->resumes->where('general', true)->first();
        $reel = $user->crew->reels->where('general', true)->first();

        return view('crew.profile.profile-edit', [
            'user'            => $user,
            'socialLinkTypes' => $this->getAllSocialLinkTypes($user),
            'departments'     => $this->getDepartments(),
            'resume'          => isset($resume) ? $resume->link : null,
            'reel'            => isset($reel) ? $reel->link : null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateCrewRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
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
