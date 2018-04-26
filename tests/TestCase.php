<?php

namespace Tests;

use App\Models\Site;
use App\Utils\UrlUtils;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\CreatesModels;
use Tests\Support\SeedDatabaseAfterRefresh;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var null | \App\Models\Site
     */
    private static $site = null;

    use CreatesApplication, CreatesModels;

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
        if (!self::$site) {
            self::$site = Site::where(
                'hostname',
                UrlUtils::getHostNameFromBaseUrl(env('APP_URL'))
            )->first();
        }

        return self::$site;
    }
}
