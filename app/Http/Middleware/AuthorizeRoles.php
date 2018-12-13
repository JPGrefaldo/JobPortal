<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthorizeRoles
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param \Closure $next
     * @param array ...$roles
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (! in_array(Role::ADMIN, $roles)) {
            $roles[] = Role::ADMIN;
        }

        $userRoles = $this->auth->user()->roles;

        if (! $userRoles->count() ||
            ! $userRoles->whereIn('name', $roles)->count()) {
            return ($request->is('api/*'))
                ? response('Request Unauthorized', 401)
                : redirect('/');
        }

        return $next($request);
    }

    /**
     * @param array ...$params
     * @return string
     */
    public static function parameterize(...$params)
    {
        return 'roles:' . implode(',', $params);
    }
}
