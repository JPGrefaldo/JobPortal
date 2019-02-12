<?php

namespace Tests\Unit\Services;

use App\Services\SocialLinksServices;
use Tests\TestCase;

class SocialLinksServicesTest extends TestCase
{
    /**
     * @var \App\Services\SocialLinksServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(SocialLinksServices::class);
    }

    /**
     * @test
     * @covers \App\Services\SocialLinksServices::cleanVimeo
     */
    public function clean_vimeo()
    {
        // videos
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service::cleanVimeo('https://player.vimeo.com/video/230046783')
        );
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service::cleanVimeo('https://vimeo.com/230046783')
        );
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service::cleanVimeo('vimeo.com/230046783')
        );

        // channels
        $this->assertEquals(
            'https://vimeo.com/mackevision',
            $this->service::cleanVimeo('https://vimeo.com/mackevision')
        );
        $this->assertEquals(
            'https://vimeo.com/channels/393360',
            $this->service::cleanVimeo('https://vimeo.com/channels/393360')
        );

        // albums
        $this->assertEquals(
            'https://vimeo.com/album/1719434',
            $this->service::cleanVimeo('https://vimeo.com/album/1719434')
        );
    }

    /**
     * @test
     * @covers \App\Services\SocialLinksServices::cleanVimeo
     */
    public function clean_vimeo_invalid()
    {
        $this->assertEquals(
            '',
            $this->service::cleanVimeo('https://player.vimeo.com/video/')
        );

        $this->assertEquals(
            '',
            $this->service::cleanVimeo('https://vimeo.com/')
        );

        $this->assertEquals(
            '',
            $this->service::cleanVimeo('https://not-vimeo.com/')
        );
    }
}
