<?php

namespace App\Providers;

use App\Events\ProjectDenied;
use App\Listeners\SendProjectDeniedEmail;
use App\Listeners\SendUserConfirmationEmail;
use App\Models\Manager;
use App\Models\Project;
use App\Models\ProjectJob;
use App\Observers\ManagerObserver;
use App\Observers\ProjectJobObserver;
use App\Observers\ProjectObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendUserConfirmationEmail::class,
        ],

        ProjectDenied::class => [
            SendProjectDeniedEmail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Manager::observe(ManagerObserver::class);
        Project::observe(ProjectObserver::class);
        ProjectJob::observe(ProjectJobObserver::class);
    }
}
