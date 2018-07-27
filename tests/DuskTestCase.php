<?php

namespace Tests;

use Tests\Support\CreatesModels;
use Laravel\Dusk\TestCase as BaseTestCase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
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
                UrlUtils::getHostNameFromBaseUrl(config('app.url'))
            )->first();
        }

        return self::$site;
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            // '--headless'
            '--start-maximized',
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
}
