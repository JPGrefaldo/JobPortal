<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AddRoleToUserByRoleName;
use App\Actions\Auth\AddUserToSite;
use App\Actions\Auth\CreateUserEmailVerificationCode;
use App\Actions\Auth\StubUserNotifications;
use App\Actions\Crew\StubCrew;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSignupRequest;
use App\Models\Role;
use App\Models\UserNotificationSetting;
use App\Services\User\UsersServices;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

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

        $user = app(UsersServices::class)->create(array_only($data, [
            'first_name',
            'last_name',
            'email',
            'password',
            'phone',
        ]));

        app(StubUserNotifications::class)->execute($user, $data);

        foreach ($data['type'] as $_ => $type) {
            app(AddRoleToUserByRoleName::class)->execute($user, $type);

            if ($type == 'Crew') {
                app(StubCrew::class)->execute($user);
            }
        }

        app(CreateUserEmailVerificationCode::class)->execute($user);

        app(AddUserToSite::class)->execute($user, session('site'));

        event(new Registered($user));

        return redirect('login')->with('infoMessage', 'Please check your email to confirm');
    }
}
