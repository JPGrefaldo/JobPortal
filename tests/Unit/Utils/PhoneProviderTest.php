<?php

namespace Tests\Unit\Utils;

use App\Faker\PhoneProvider;
use App\Utils\StrUtils;
use Faker\Generator;
use Tests\TestCase;

class PhoneProviderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = app(Generator::class);
        $this->faker->addProvider(new PhoneProvider($this->faker));
    }

    /**
     * @test
     * @covers \App\Utils\StrUtils::stripNonNumeric
     */
    public function test_phone_number()
    {
        $fakePhoneNumber = $this->faker->phoneNumber;
        $number = StrUtils::stripNonNumeric($fakePhoneNumber);

        $this->assertEquals('10', strlen($number), "$fakePhoneNumber doesn't yeild 10 charactrs after format");
        $this->assertTrue(ctype_digit($number));
    }
}
