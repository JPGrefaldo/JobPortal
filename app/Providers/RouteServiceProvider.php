<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('user', function ($value) {
            if (! Hashids::decode($value)) {
                abort(404);
            }
            return User::find(Hashids::decode($value)[0]);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')->group(base_path('routes/web/index.php'));

        Route::middleware('web')->group(function () {
            Route::middleware('role:Admin')->group(base_path('routes/web/admin.php'));
            Route::middleware('role:Crew')->group(base_path('routes/web/crew.php'));
            Route::middleware('role:Producer')->group(base_path('routes/web/producer.php'));
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->group(base_path('routes/api/index.php'));

        Route::prefix('api')->middleware('api')->group(function () {
            Route::prefix('admin')->middleware('role:Admin')->group(base_path('routes/api/admin.php'));
            Route::prefix('crew')->middleware('role:Crew')->group(base_path('routes/api/crew.php'));
            Route::prefix('producer')->middleware('role:Producer')->group(base_path('routes/api/producer.php'));
        });
    }
}
