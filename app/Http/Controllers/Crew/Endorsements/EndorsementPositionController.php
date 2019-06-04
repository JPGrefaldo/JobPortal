<?php

namespace App\Http\Controllers\Crew\Endorsements;

use App\Actions\Endorsement\CreateEndorsementRequest;
use App\Http\Controllers\Controller;
use App\Http\Middleware\UserHasPosition;
use App\Http\Requests\StoreCrewEndorsementRequest;
use App\Models\EndorsementEndorser;
use App\Models\Position;
use App\View\Endorsements\EndorsementIndexModel;
use App\View\Endorsements\EndorsementPositionShowModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return Response
     */
    public function index()
    {
        return view('crew.endorsement.index', (new EndorsementIndexModel(auth()->user())));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Position $position
     * @param Request $request
     * @return Response
     */
    public function store(Position $position, StoreCrewEndorsementRequest $request)
    {
        $data = $request->validated();

        $data['request_owner_id'] = auth()->user()->id;

        app(CreateEndorsementRequest::class)->execute(
            auth()->user(),
            $position,
            $data['email'],
            $data['message'],
            $data['request_owner_id']
        );

        return response('');
    }

    /**
     * Display the specified resource.
     *
     * @param Position $position
     * @return Response
     */
    public function show(Position $position)
    {
        return view('crew.endorsement.position.show', (new EndorsementPositionShowModel(auth()->user(), $position)));
    }

    public function destroy(EndorsementEndorser $endorsementEndorser)
    {
        $endorsementEndorser->delete();

        return redirect(route('crew.endorsement.index'));
    }
}
