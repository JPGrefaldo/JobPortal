<?php

namespace Tests;

use App\Exceptions\Handler;
use App\Models\Site;
use App\Utils\UrlUtils;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\CreatesModels;
use Tests\Support\CustomAsserts;
use Tests\Support\SeedDatabaseAfterRefresh;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var null | \App\Models\Site
     */
    private static $site = null;

    use CreatesApplication, CreatesModels, CustomAsserts;

    /**
     * Add custom setup traits
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[SeedDatabaseAfterRefresh::class])) {
            $this->seedDatabaseAfterRefresh();
        }

        return $uses;
    }

    /**
     * @return Site|null
     */
    protected function getCurrentSite()
    {
        if (! self::$site) {
            self::$site = Site::where(
                'hostname',
                UrlUtils::getHostNameFromBaseUrl(config('app.url'))
            )->first();
        }

        return self::$site;
    }

    /**
     * Disable suppressing errors when HTTP testing
     * Add $this->disableExceptionHandling(); to top of test
     */
    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler
        {
            public function __construct()
            {
            }

            public function report(\Exception $e)
            {
            }

            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }
}
