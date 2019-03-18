<?php

namespace Tests\Unit\Actions\Crew;

use App\Actions\Crew\CleanVideoLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CleanVideoLinkTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Actions\Crew\CleanVideoLink::execute
     */
    public function execute_valid_youtube()
    {
        $this->assertEquals(
            'https://www.youtube.com/embed/playlist?list=PLGJSQdu-6kDFdD3wJC0TG3Y5BEFNsibdc',
            app(CleanVideoLink::class)->execute('http://www.youtube.com/playlist?list=PLGJSQdu-6kDFdD3wJC0TG3Y5BEFNsibdc')
        );
    }

    /**
     * @test
     * @covers \App\Actions\Crew\CleanVideoLink::execute
     */
    public function execute_valid_vimeo()
    {
        $this->assertEquals(
            'https://player.vimeo.com/video/321603291',
            app(CleanVideoLink::class)->execute('https://vimeo.com/321603291')
        );
    }

    /**
     * @test
     * @covers \App\Actions\Crew\CleanVideoLink::execute
     * @expectedException \Exception
     */
    public function execute_invalid()
    {
        app(CleanVideoLink::class)->execute('https://google.com');
    }
}
