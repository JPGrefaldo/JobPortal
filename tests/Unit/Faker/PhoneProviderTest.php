<?php

namespace Tests\Unit\Faker;

use App\Faker\PhoneProvider;
use Faker\Generator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhoneProviderTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->faker = app(Generator::class);
        $this->faker->addProvider(new PhoneProvider($this->faker));
    }

    /** @test */
    public function test_phone_number()
    {
        $number = $this->faker->phoneNumber;

        $this->assertEquals('10', strlen($number));
        $this->assertTrue(ctype_digit($number));
    }
}
