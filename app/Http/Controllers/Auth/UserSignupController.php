<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\AddUserToSite;
use App\Actions\Auth\CreateUserEmailVerificationCode;
use App\Actions\Auth\StubUserNotifications;
use App\Actions\Crew\CreateCrewAccount;
use App\Actions\Crew\CreateProducerAccount;
use App\Actions\User\CreateUser;
use App\Actions\User\PostCreateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSignupRequest;
use App\Models\Role;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class UserSignupController extends Controller
{
    /**
     * @return Factory|View
     */
    public function show()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.signup');
    }

    /**
     * Handle post request to signup
     *
     * @param UserSignupRequest $request
     *
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function signup(UserSignupRequest $request)
    {
        $data = $request->validated();

        $user = app(CreateUser::class)->execute(Arr::only($data, [
            'first_name',
            'last_name',
            'nickname',
            'email',
            'password',
            'phone',
        ]));

        app(PostCreateUser::class)->execute($user);

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
