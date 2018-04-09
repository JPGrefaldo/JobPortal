<?php

use Tests\TestCase;

class UserFunctionsTest extends TestCase
{
    /** @test */
    public function stripe_non_numeric_characters()
    {
        $this->assertEquals('15555555555', stripNonNumeric('+1 (555) 555-5555'));
    }
}