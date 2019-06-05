<?php

namespace App\Providers;

use App\Database\SQLiteSchemaGrammar;
use App\View\InitialJS;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setSqliteSchemaGrammarOnMigrate();
        Schema::defaultStringLength(191);

        $this->app->singleton(InitialJS::class, function ($app) {
            return (new InitialJS());
        });
    }

    /**
     * On MySQL databases, Varchars are case insensitive on search by default.
     * To replicate this on sqlite, we need to register a custom grammar to
     * put COLLATE NOCASE on string types on column creation.
     */
    protected function setSqliteSchemaGrammarOnMigrate()
    {
        $this->app->afterResolving('migrator', function ($migrator) {
            /** @var Connection $db */
            $db = $this->app['db.connection'];

            if ($db->getDriverName() === 'sqlite') {
                $db->setSchemaGrammar($db->withTablePrefix(new SQLiteSchemaGrammar()));
            };
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
