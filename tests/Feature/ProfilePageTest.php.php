<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilePageTest.php extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_visit_profile()
    {
        $this->visit('/my-profile/524');
    }
}
