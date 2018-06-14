<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterFeatureTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
/** @test */
    public function test_register()
    {
        $this->visit('/signup')
            ->type('Me', 'first_name')
            ->type('Me', 'last_name')
            ->type('someone@outlook.com', 'email')
            ->type('someone@outlook.com', 'email_confirmation')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->press('submit')
            ->seeInDatabase('users', ['email' => 'someone@outlook.com']);
    }
    
}
