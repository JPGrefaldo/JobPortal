<?php

use Tests\TestCase;

class TestHelperFunctionsTest extends TestCase
{
    /** @test */
    public function stripe_non_numeric_characters()
    {
        $this->assertEquals('15555555555', stripNonNumeric('+1 (555) 555-5555'));
    }

    /** @test */
    public function create_test_us_phone_number()
    {
        $number = createTestUSPhoneNumber();

        $this->assertEquals('10', strlen($number));
        $this->assertTrue(ctype_digit($number));
    }
}