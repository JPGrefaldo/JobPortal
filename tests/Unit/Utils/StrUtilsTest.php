<?php

namespace Tests\Unit\Utils;

use App\Utils\StrUtils;
use Tests\TestCase;

class StrUtilsTest extends TestCase
{
    /**
     * @test
     * @covers \App\Utils\StrUtils::stripNonNumeric
     */
    public function stripe_non_numeric_characters()
    {
        $this->assertEquals(
            '15555555555',
            StrUtils::stripNonNumeric(('+1 (555) 555-5555'))
        );
    }

    /**
     * @test
     * @covers \App\Utils\StrUtils::cleanYouTube
     */
    public function clean_youtube()
    {
        $this->assertEquals(
            'https://www.youtube.com/embed/G8S81CEBdNs',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/G8S81CEBdNs',
            StrUtils::cleanYouTube('http://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/G8S81CEBdNs',
            StrUtils::cleanYouTube('https://www.youtube.com/embed/G8S81CEBdNs')
        );
        $this->assertEquals(
            'https://www.youtube.com/embed/2-_rLbU6zJo',
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
        $this->assertEquals(
            'https://www.youtube.com/embed/G8S81CEBdNs',
            StrUtils::cleanYouTube('https://www.youtube.com/watch?v=G8S81CEBdNs')
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

    /**
     * @test
     * @covers \App\Utils\StrUtils::formatPhone
     */
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

    /**
     * @test
     * @covers \App\Utils\StrUtils::convertNull
     */
    public function convert_null()
    {
        $this->assertSame(
            '',
            StrUtils::convertNull(null)
        );

        $this->assertSame(
            'some string',
            StrUtils::convertNull('some string')
        );
    }

    /**
     * @test
     * @covers \App\Utils\StrUtils::formatName
     */
    public function format_name()
    {
        $this->assertSame(
            'John',
            StrUtils::formatName('John')
        );

        $this->assertSame(
            'John James',
            StrUtils::formatName('John jAmeS')
        );

        $this->assertSame(
            'Jean-Luc',
            StrUtils::formatName('JeAn-luc')
        );

        $this->assertSame(
            "D'Amore",
            StrUtils::formatName("D'amore")
        );

        $this->assertSame(
            "D'Angelo Jean-Claude",
            StrUtils::formatName("D'angelo Jean-claude")
        );

        $this->assertSame(
            "D'Angelo O'Reilly",
            StrUtils::formatName("D'angelo O'reilly")
        );

        $this->assertSame(
            "D'Angelo Jean-Luc Jean-Claude",
            StrUtils::formatName("D'angelo Jean-luc Jean-claude")
        );

        $this->assertSame(
            "McDermott",
            StrUtils::formatName("McDermott")
        );

        $this->assertSame(
            "McDermott",
            StrUtils::formatName("MCDERMOTT")
        );

        $this->assertSame(
            "McDermott",
            StrUtils::formatName("mcdermott")
        );

        $this->assertSame(
            "D'Angelo Jean-Luc Jean-Claude McDermott McDermott",
            StrUtils::formatName("D'angelo Jean-luc Jean-claude mcdermott MCDERMOTT")
        );
    }

    /**
     * @test
     * @covers \App\Utils\StrUtils::stripHTTPS
     */
    public function strip_http()
    {
        $this->assertSame(
            'url.com/test',
            StrUtils::stripHTTPS('https://url.com/test')
        );


        $this->assertSame(
            'url.com/test',
            StrUtils::stripHTTPS('http://url.com/test')
        );

        $this->assertSame(
            'url.com/test',
            StrUtils::stripHTTPS('url.com/test')
        );

        $this->assertSame(
            '',
            StrUtils::stripHTTPS('')
        );
    }
}
