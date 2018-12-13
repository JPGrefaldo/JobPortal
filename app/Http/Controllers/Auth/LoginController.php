<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends AbstractLoginController
{
    /**
     * @var string
     */
    private $error = '';

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->isValidUser($request) && $this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $token = JWTAuth::fromUser($this->guard()->user());

        session()->flash('token', $token);

        return parent::sendLoginResponse($request);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    private function isValidUser(Request $request)
    {
        if (! $this->guard()->validate($this->credentials($request))) {
            return false;
        }

        $user = $this->guard()->getLastAttempted();

        if (! $user->isConfirmed()) {
            $this->error = 'Your account is not confirmed.\n Check your email (and spam) for the confirmation link';
        } elseif (! $user->isActive()) {
            $this->error = 'Your account has been closed. Please contact us for assistance in re-opening your account.';
        } elseif ($user->banned) {
            $this->error = 'Your account has been banned. Please contact us for assistance in re-opening your account.';
        } elseif (! $user->sites->contains(session('site'))) {
            $this->error = 'Your account is not registered in this site.';
        }

        return ($this->error === '');
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param string  $error
     *
     * @return void
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [$this->error ?: trans('auth.failed')],
        ]);
    }
}
