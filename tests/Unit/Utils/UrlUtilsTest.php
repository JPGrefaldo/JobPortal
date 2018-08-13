<?php

namespace Tests\Unit\Utils;

use App\Utils\UrlUtils;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlUtilsTest extends TestCase
{
    /**
     * @test
     * @covers \App\Utils\UrlUtils::getHostNameFromBaseUrl
     */
    public function get_host_name_from_base_url()
    {
        $this->assertEquals(
            'dev-crewcalls.test',
            UrlUtils::getHostNameFromBaseUrl('http://dev-crewcalls.test')
        );

        $this->assertEquals(
            'dev-crewcalls.test',
            UrlUtils::getHostNameFromBaseUrl('www.dev-crewcalls.test')
        );
    }
}
