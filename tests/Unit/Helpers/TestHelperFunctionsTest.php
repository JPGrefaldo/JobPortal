<?php

use Tests\TestCase;

class TestHelperFunctionsTest extends TestCase
{
    /** @test */
    public function create_test_us_phone_number()
    {
        $number = createTestUSPhoneNumber();

        $this->assertEquals('10', strlen($number));
        $this->assertTrue(ctype_digit($number));
    }
}