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
}
