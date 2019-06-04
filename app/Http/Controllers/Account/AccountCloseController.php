<?php

namespace App\Http\Controllers\Account;

use App\Actions\User\CloseUserAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AccountCloseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('account.account', [
            'user'        => Auth::user(),
            'accountType' => 'close',
        ]);
    }

    /**
     * @param CloseUserAccount $closeUserAccount
     * @return Response
     */
    public function destroy(CloseUserAccount $closeUserAccount)
    {
        $closeUserAccount->execute(Auth::user());

        return redirect(route('logout'));
    }
}
