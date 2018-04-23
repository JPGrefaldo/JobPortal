<?php

namespace Tests\Unit\Services;

use App\Services\CrewReelsServices;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrewReelsServicesTest extends TestCase
{
    /**
     * @var \App\Services\CrewReelsServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(CrewReelsServices::class);
    }

    /** @test */
    public function test_clean_url()
    {
        // youtube
        $this->assertEquals(
            'https://www.youtube.com/embed/G8S81CEBdNs',
            $this->service::cleanUrl('https://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/G8S81CEBdNs',
            $this->service::cleanUrl('http://www.youtube.com/embed/G8S81CEBdNs')
        );

        // vimeo
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service::cleanUrl('https://vimeo.com/230046783')
        );
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service::cleanUrl('https://player.vimeo.com/video/230046783')
        );

    }
}
