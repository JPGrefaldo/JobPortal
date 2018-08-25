<?php

namespace App\Http\Controllers\Account;

use App\Actions\User\CloseUserAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountCloseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account.account', [
            'user' => Auth::user(),
            'accountType' => 'close',
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        app(CloseUserAccount::class)->execute(Auth::user());

        return redirect(route('logout'));
    }
}
