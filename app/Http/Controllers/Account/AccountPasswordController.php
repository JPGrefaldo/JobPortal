<?php

namespace App\Http\Controllers\Account;

use App\Actions\User\ChangeUserPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountPasswordRequest;
use Illuminate\Support\Facades\Auth;

class AccountPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.account', [
            'user'        => Auth::user(),
            'accountType' => 'password',
        ]);
    }

    /**
     * @param AccountPasswordRequest $request
     * @param ChangeUserPassword $changeUserPassword
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccountPasswordRequest $request, ChangeUserPassword $changeUserPassword)
    {
        $changeUserPassword->execute(Auth::user(), $request->get('password'));

        return back()->with('infoMessage', 'Password Updated');
    }
}
