<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;

class SetSite
{
    /**
     * Set the current site in the session
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $site = $request->session()->get('site');
        $hostname = $request->getHost();

        if ($site instanceof Site && $site->hostname === $hostname) {
            return $next($request);
        }

        $site = Site::whereHostname($hostname)->first();

        if (! $site) {
            return response($hostname . ' is not registered.', 403);
        }

        $request->session()->put('site', $site);

        return $next($request);
    }
}
