<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AddUserToSite;
use App\Actions\Auth\CreateUserEmailVerificationCode;
use App\Actions\Auth\StubUserNotifications;
use App\Actions\Crew\CreateCrewAccount;
use App\Actions\Crew\CreateProducerAccount;
use App\Actions\User\CreateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSignupRequest;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;

class UserSignupController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('auth.signup');
    }

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

        $user = app(CreateUser::class)->execute(array_only($data, [
            'first_name',
            'last_name',
            'email',
            'password',
            'phone',
        ]));

        foreach ($data['type'] as $_ => $type) {
            if ($type == Role::CREW) {
                app(CreateCrewAccount::class)->execute($user);
            } else {
                app(CreateProducerAccount::class)->execute($user);
            }
        }

        app(StubUserNotifications::class)->execute($user, $data);

        app(CreateUserEmailVerificationCode::class)->execute($user);

        app(AddUserToSite::class)->execute($user, session('site'));

        event(new Registered($user));

        return redirect('login')->with('infoMessage', 'Please check your email to confirm');
    }
}
