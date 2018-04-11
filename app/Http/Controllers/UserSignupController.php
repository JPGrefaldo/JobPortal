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
    public function createCrew(Request $request)
    {
        $data = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|string|email|confirmed|max:255|unique:users',
            'password'     => 'required|string|min:6|confirmed',
            'phone'        => 'required|string|max:15',
            'receive_text' => 'required|numeric',
            'terms'        => 'required|numeric',
        ]);

        $user = app(UsersServices::class)->create(
            [
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'email'      => $data['email'],
                'password'   => $data['password'],
                'phone'      => $data['phone'],
            ],
            ['receive_sms' => $data['receive_text']]
        );

        app(AuthServices::class)->createCrew(
            $user,
            $request->session()->get('site')
        );

        event(new Registered($user));

        return redirect('login');
    }
}
