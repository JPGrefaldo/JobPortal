<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSignupRequest;
use App\Models\Role;
use App\Models\UserNotificationSetting;
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

        $user = app(UsersServices::class)->create(array_only($data, [
            'first_name',
            'last_name',
            'email',
            'password',
            'phone',
        ]));

        UserNotificationSetting::create([
            'user_id'     => $user->id,
            'receive_sms' => ($data['type'] === Role::PRODUCER)
                ? 1
                : array_get($data, 'receive_sms', 0),
        ]);

        app(AuthServices::class)->createByRoleName(
            $data['type'],
            $user,
            session('site')
        );

        event(new Registered($user));
        session()->flash('register-success', 'Please check your email to confirm');

        return redirect('login');
    }
}
