<?php

namespace App\Http\Controllers;

use App\Actions\Admin\ApproveFlagMessage;
use App\Actions\Admin\DisapproveFlagMessage;
use App\Actions\User\CreatePendingFlagMessage;
use App\Models\PendingFlagMessage;
use Illuminate\Http\Request;

class PendingFlagMessageController extends Controller
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
        app(CreatePendingFlagMessage::class)->execute($request);

        return response()->json([
            'message' => 'Reviewing your request for flag'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PendingFlagMessage  $pendingFlagMessage
     * @return \Illuminate\Http\Response
     */
    public function show(PendingFlagMessage $pendingFlagMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PendingFlagMessage  $pendingFlagMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(PendingFlagMessage $pendingFlagMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PendingFlagMessage  $pendingFlagMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendingFlagMessage $pendingFlagMessage)
    {
        if ($request->action === 'disapprove') {
            app(DisapproveFlagMessage::class)->execute($pendingFlagMessage);

            return 'Pending flag message disapproved';
        } elseif ($request->action === 'approve') {
            app(ApproveFlagMessage::class)->execute($pendingFlagMessage);

            return 'Pending flag message approved';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PendingFlagMessage  $pendingFlagMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendingFlagMessage $pendingFlagMessage)
    {
        //
    }
}
