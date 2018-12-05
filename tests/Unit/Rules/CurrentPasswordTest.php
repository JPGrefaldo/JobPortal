<?php

namespace Tests\Unit\Rules;

use App\Models\User;
use App\Rules\CurrentPassword;
use App\Rules\Facebook;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrentPasswordTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Rules\CurrentPassword::passes
     */
    public function valid()
    {
        $user = factory(User::class)->create([
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
     * @covers
     */
    public function invalid()
    {
        $user = factory(User::class)->create([
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
