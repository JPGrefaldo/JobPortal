<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSignupRequest;
use App\Models\Role;
use App\Models\UserNotificationSetting;
use App\Services\AuthServices;
use App\Services\UsersServices;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserSignupController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('auth.register');
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

        UserNotificationSetting::create([
            'user_id'     => $user->id,
            'receive_sms' => (in_array(Role::PRODUCER, $data['type']))
                ? 1
                : array_get($data, 'receive_sms', 0),
        ]);

        foreach ($data['type'] as $_ => $type) {
            app(AuthServices::class)->createByRoleName(
                $type,
                $user,
                session('site')
            );
        }

        event(new Registered($user));
        session()->flash('register-success', 'Please check your email to confirm');

        return redirect('login');
    }
}
