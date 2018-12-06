<?php

namespace App\Providers;

use App\Database\SQLiteSchemaGrammar;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * On MySQL databases, Varchars are case insensitive on search by default.
     * To replicate this on sqlite, we need to register a custom grammar to
     * put COLLATE NOCASE on string types on column creation.
     */
    protected function setSqliteSchemaGrammarOnMigrate()
    {
        $this->app->afterResolving('migrator', function ($migrator) {
            /** @var \Illuminate\Database\Connection $db */
            $db = $this->app['db.connection'];

            if ($db->getDriverName() === 'sqlite') {
                $db->setSchemaGrammar($db->withTablePrefix(new SQLiteSchemaGrammar()));
            };
        });
    }
}
