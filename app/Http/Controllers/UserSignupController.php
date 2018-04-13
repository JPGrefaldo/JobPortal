<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSignupRequest;
use App\Services\AuthServices;
use App\Services\UsersServices;
use App\Models\Site;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserSignupController extends Controller
{
    /**
     * Handle post request to signup
     *
     * @param \App\Http\Requests\UserSignupRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function signup(UserSignupRequest $request)
    {
        $data = $request->validated();

        $user = app(UsersServices::class)->create(
            array_only($data, [
                'first_name',
                'last_name',
                'email',
                'password',
                'phone',
            ]),
            array_only($data, 'receive_sms')
        );

        app(AuthServices::class)->createByRoleName(
            $data['type'],
            $user,
            $request->session()->get('site')
        );

        event(new Registered($user));

        return redirect('login');
    }
}
