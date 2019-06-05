<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class LogoutInactiveUser
{
    /**
     * @var Guard
     */
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $this->auth->check()) {
            return $next($request);
        }

        $user = $this->auth->user();

        if ($user->isActive()) {
            return $next($request);
        }

        $this->auth->logout();
        $request->session()->invalidate();

        $error = ($user->banned)
            ? 'Your account has been banned (' . $user->banned->reason . '). Please contact us for assistance in re-opening your account.'
            : 'Your account has been closed. Please contact us for assistance in re-opening your account.';

        return redirect('login')->withErrors([
            'email' => [$error],
        ]);
    }
}
