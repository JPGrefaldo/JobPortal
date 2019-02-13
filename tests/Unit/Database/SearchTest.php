<?php

namespace Tests\Unit\Database;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers 
     */
    public function case_insensitive_search_on_strings()
    {
        $user = $this->createUser(['first_name' => 'John', 'last_name' => 'Doe']);

        $this->assertEquals(
            1,
            User::whereFirstName('john')->whereLastName('doe')->count()
        );
    }
}
