<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use App\Models\Role;
use Closure;

class AuthorizeProducer
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->user()->hasRole(Role::PRODUCER)) {
            return redirect('/');
        }

        return $next($request);
    }
}
