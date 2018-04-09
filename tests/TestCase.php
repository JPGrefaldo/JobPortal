<?php

namespace Tests;

use App\Site;
use App\Utils\UrlUtils;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\SeedDatabaseAfterRefresh;

include __DIR__ . DIRECTORY_SEPARATOR . 'TestHelperFunctions.php';

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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
        return Site::where(
            'hostname',
            UrlUtils::getHostNameFromBaseUrl(env('APP_URL'))
        )->first();
    }
}
