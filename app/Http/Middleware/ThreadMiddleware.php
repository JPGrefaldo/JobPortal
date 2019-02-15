<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class ThreadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $thread = $request->thread;
        $user = auth()->user();

        if (! $thread->hasParticipant($user->id)) {
            return abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
