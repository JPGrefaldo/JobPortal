<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class UserHasPosition
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
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (! $this->auth->user()->crew->hasPosition($request->position)) {
        //     return redirect(route('dashboard'))->withErrors([
        //         'position' => ['You do not have this position'],
        //     ]);
        // }

        return $next($request);
    }
}
