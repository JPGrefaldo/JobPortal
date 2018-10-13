<?php

namespace Tests\Unit\Utils;

use App\Utils\FormatUtils;
use App\Utils\StrUtils;
use Tests\TestCase;

class FormatUtilsTest extends TestCase
{
    /**
     * @test
     * @covers \App\Utils\FormatUtils::email
     */
    public function email()
    {
        $this->assertSame('test@test.com', FormatUtils::email('Test@TEST.com'));
    }

    /**
     * @test
     * @covers \App\Utils\FormatUtils::name
     */
    public function name()
    {
        $this->assertSame('Test User', FormatUtils::name('test user'));
        $this->assertSame('D\'Angelo Jean-Luc Jean-Claude McDermott McDermott',
            FormatUtils::name('D\'angelo Jean-luc Jean-claude mcdermott MCDERMOTT')
        );
    }
}
