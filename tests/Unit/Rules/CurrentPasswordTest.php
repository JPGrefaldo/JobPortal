<?php

namespace Tests\Unit\Rules;

use App\Rules\CurrentPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CurrentPasswordTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Rules\CurrentPassword::passes
     */
    public function valid()
    {
        $user = $this->createUser([
            'password' => \Hash::make('test'),
        ]);

        $this->actingAs($user);

        $result = $this->app['validator']->make(
            [
                'current_password' => 'test',
            ],
            [
                'current_password' => [
                    'required',
                    new CurrentPassword(),
                ],
            ]);

        $this->assertTrue($result->passes());
    }

    /**
     * @test
     * @covers \App\Rules\CurrentPassword::passes
     */
    public function invalid()
    {
        $user = $this->createUser([
            'password' => \Hash::make('test'),
        ]);

        $this->actingAs($user);

        $result = $this->app['validator']->make(
            [
                'current_password' => 'WRONG',
            ],
            [
                'current_password' => [
                    'required',
                    new CurrentPassword(),
                ],
            ]);

        $this->assertFalse($result->passes());
        $this->assertEquals(
            'Invalid current password',
            $result->errors()->first()
        );
    }
}
