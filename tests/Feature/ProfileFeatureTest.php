<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Services\AuthServices;
use App\Models\User;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ProfileFeatureTest extends TestCase
{
	use DatabaseMigrations;
     /** @test */
    public function test_visit_profile()
    {

    
    	$user = factory('App\Models\User')->create();
    	$remoteSites = factory('App\Models\Site')->create();

    	$response = $this->actingAs($user)
                         ->put('/my-profile/' . $user->id);

        $response->assertSee('My Profile');

        $response = $this->get('/my-profile/'. $user->id . '/edit');

    }

         /** @test */
    public function test_visit_edit_profile()
    {

    	$user = factory('App\Models\User')->create();

    	$response = $this->get('/my-profile');

        $response->assertSee($user->id);

        $response = $this->get('/my-profile/'. $user->id . '/edit');

    }

}
