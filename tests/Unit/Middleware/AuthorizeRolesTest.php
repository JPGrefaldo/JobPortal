<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\AuthorizeRoles;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizeRolesTest extends TestCase
{
    /**
     * @test
     * @covers \App\Http\Middleware\AuthorizeRoles::parameterize
     */
    public function parameterize()
    {
        $this->assertEquals(
            'roles:Admin,Crew,Producer',
            AuthorizeRoles::parameterize('Admin', 'Crew', 'Producer')
        );
        $this->assertEquals(
            'roles:Producer',
            AuthorizeRoles::parameterize('Producer')
        );
    }
}
