<?php

namespace App\Http\Controllers\Crew\Endorsements;

use App\Actions\Endorsement\CreateEndorsementRequest;
use App\Http\Controllers\Controller;
use App\Http\Middleware\UserHasPosition;
use App\Models\Position;
use App\View\Endorsements\EndorsementIndexModel;
use App\View\Endorsements\EndorsementPositionShowModel;
use App\Http\Requests\StoreCrewEndorsementRequest;

class EndorsementPositionController extends Controller
{
    public function __construct()
    {
        $this->middleware(UserHasPosition::class)
            ->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crew.endorsement.index', (new EndorsementIndexModel(auth()->user())));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Position $position
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Position $position, StoreCrewEndorsementRequest $request)
    {
        $data = $request->validated();

        app(CreateEndorsementRequest::class)->execute(
            auth()->user(),
            $position,
            $data['email'],
            $data['message']
        );

        return response('');
    }

    /**
     * Display the specified resource.
     *
     * @param  Position $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return view('crew.endorsement.position.show', (new EndorsementPositionShowModel(auth()->user(), $position)));
    }
}
