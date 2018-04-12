<?php

namespace App\Http\Controllers;

use App\Services\AuthServices;
use App\Services\UsersServices;
use App\Site;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserSignupController extends Controller
{
    /**
     * Handle post request to signup crew
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signup(Request $request)
    {
        $data = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:6',
            'phone'        => 'required|string|max:15',
            'receive_sms'  => 'sometimes|numeric',
            'type'         => 'required|string'
        ]);

        $user = app(UsersServices::class)->create(
            array_only($data, [
                'first_name',
                'last_name',
                'email',
                'password',
                'phone'
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
