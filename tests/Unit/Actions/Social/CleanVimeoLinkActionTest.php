<?php

namespace Tests\Actions\Social;

use App\Actions\Social\CleanVimeoLinkAction;
use Tests\TestCase;

class CleanVimeoLinkActionTest extends TestCase
{
    /**
     * @var CleanVimeoLinkAction
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(CleanVimeoLinkAction::class);
    }

    /**
     * @test
     * @covers CleanVimeoLinkAction::execute
     */
    public function clean_vimeo()
    {
        // videos
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service->execute('https://player.vimeo.com/video/230046783')
        );
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service->execute('https://vimeo.com/230046783')
        );
        $this->assertEquals(
            'https://player.vimeo.com/video/230046783',
            $this->service->execute('vimeo.com/230046783')
        );


        $this->assertEquals(
            'https://player.vimeo.com/video/337361057',
            $this->service->execute('https://vimeo.com/337361057')
        );
    }

    /**
     * @test
     * @covers CleanVimeoLinkAction::execute
     */
    public function clean_vimeo_invalid()
    {
        $this->assertEquals(
            '',
            $this->service->execute('https://player.vimeo.com/video/')
        );

        $this->assertEquals(
            '',
            $this->service->execute('https://vimeo.com/')
        );

        $this->assertEquals(
            '',
            $this->service->execute('https://not-vimeo.com/')
        );
    }
}
