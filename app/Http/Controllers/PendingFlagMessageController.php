<?php

namespace App\Http\Controllers;

use App\Actions\Admin\ApproveFlagMessage;
use App\Actions\Admin\DisapproveFlagMessage;
use App\Actions\User\CreatePendingFlagMessage;
use App\Http\Requests\StorePendingFlagMessageRequest;
use App\Models\PendingFlagMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PendingFlagMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('flagged-messages');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StorePendingFlagMessageRequest $request)
    {
        app(CreatePendingFlagMessage::class)->execute($request);

        return response()->json([
            'message' => 'Reviewing your request for flag',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PendingFlagMessage $pendingFlagMessage
     * @return Response
     */
    public function show(PendingFlagMessage $pendingFlagMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\PendingFlagMessage $pendingFlagMessage
     * @return Response
     */
    public function edit(PendingFlagMessage $pendingFlagMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\PendingFlagMessage $pendingFlagMessage
     * @return Response
     */
    public function update(Request $request, PendingFlagMessage $pendingFlagMessage)
    {
        switch ($request->action) {
            case 'disapprove':
                app(DisapproveFlagMessage::class)->execute($pendingFlagMessage);

                return response()->json([
                    'message' => 'Pending flag message disapproved',
                ]);
                break;

            case 'approve':
                app(ApproveFlagMessage::class)->execute($pendingFlagMessage);

                return response()->json([
                    'message' => 'Pending flag message approved',
                ]);
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PendingFlagMessage $pendingFlagMessage
     * @return Response
     */
    public function destroy(PendingFlagMessage $pendingFlagMessage)
    {
        //
    }
}
