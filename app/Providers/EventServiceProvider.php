<?php

namespace App\Providers;

use App\Events\ManagerAdded;
use App\Events\ManagerDeleted;
use App\Listeners\SendManagerConfirmationEmail;
use App\Listeners\SendManagerDeletedEmail;
use App\Listeners\SendUserConfirmationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\Manager;
use App\Observers\ManagerObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendUserConfirmationEmail::class
        ],

        ManagerAdded::class => [
            SendManagerConfirmationEmail::class
        ],

        ManagerDeleted::class => [
            SendManagerDeletedEmail::class
        ]
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
    }
}
