<?php

namespace App\Http\Controllers\Account;

use App\Actions\User\UpdateUserNotificationSettings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountNotificationsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountNotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.account', [
            'user' => Auth::user()->load([
                'notificationSettings',
            ]),
            'accountType' => 'notifications',
        ]);
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
     * @param  AccountNotificationsRequest $request
     * @param UpdateUserNotificationSettings $updateUserNotificationSettings
     * @return \Illuminate\Http\Response
     */
    public function store(AccountNotificationsRequest $request, UpdateUserNotificationSettings $updateUserNotificationSettings)
    {
        $updateUserNotificationSettings->execute(Auth::user(), $request->all());

        return back()->with('infoMessage', 'Settings updated');
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
