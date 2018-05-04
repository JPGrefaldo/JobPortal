<?php

namespace Tests\Unit\Utils;

use App\Utils\StrUtils;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StrUtilsTest extends TestCase
{
    /** @test */
    public function stripe_non_numeric_characters()
    {
        $this->assertEquals('15555555555', StrUtils::stripNonNumeric(('+1 (555) 555-5555')));
    }

    /** @test */
    public function clean_you_tube()
    {
        $this->assertEquals('https://www.youtube.com/embed/G8S81CEBdNs',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals('https://www.youtube.com/embed/G8S81CEBdNs',
            StrUtils::cleanYouTube('http://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals('https://www.youtube.com/embed/G8S81CEBdNs',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals('https://www.youtube.com/embed/2-_rLbU6zJo',
            StrUtils::cleanYouTube('https://youtu.be/2-_rLbU6zJo')
        );

        $this->assertEquals(
            'https://www.youtube.com/embed/WI5AF1DCQlc',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/WI5AF1DCQlc?list=PL1qxp3AdQJDQYIS0Vjj1lyz2K_lSGXzUm')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/2-_rLbU6zJo',
            StrUtils::cleanYouTube('https://www.youtube.com/watch?v=2-_rLbU6zJo')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/cesu4Ye1xN4',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/watch?v=cesu4Ye1xN4&feature=youtube_gdata_player')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/0W7PlcDeJYo',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/watch?v=0W7PlcDeJYo#action=share')
        );

        //Channels
        $this->assertEquals(
            'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
            StrUtils::cleanYouTube('https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw')
        );
        $this->assertEquals(
            'https://www.youtube.com/channel/UCHBOnWRvXSZ2xzBXyoDnCJw',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/channel/UCHBOnWRvXSZ2xzBXyoDnCJw')
        );

        //Playlist
        $this->assertEquals(
            'https://www.youtube.com/embed/playlist?list=PLGJSQdu-6kDFdD3wJC0TG3Y5BEFNsibdc',
            StrUtils::cleanYouTube('http://www.youtube.com/playlist?list=PLGJSQdu-6kDFdD3wJC0TG3Y5BEFNsibdc')
        );
    }

    /** @test */
    public function format_phone()
    {
        $this->assertEquals(
            '(123) 456-7891',
            StrUtils::formatPhone('1234567891')
        );

        $this->assertEquals(
            '(201) 886-0269',
            StrUtils::formatPhone('201-886-0269')
        );

        $this->assertEquals(
            '(201) 886-0269',
            StrUtils::formatPhone('201.886.0269')
        );
    }
}
