<?php

namespace Laravel\Nova\Tests\Controller;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Actions\ActionEvent;
use Laravel\Nova\Tests\Fixtures\Role;
use Laravel\Nova\Tests\Fixtures\User;
use Laravel\Nova\Tests\IntegrationTest;
use Laravel\Nova\Tests\Fixtures\IdFilter;
use Laravel\Nova\Tests\Fixtures\UserPolicy;

class ResourceDetachTest extends IntegrationTest
{
    public function setUp()
    {
        parent::setUp();

        $this->authenticate();
    }

    public function test_can_detach_resources()
    {
        $user = $this->createUser();
        $role = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();
        $role3 = factory(Role::class)->create();

        $user->roles()->attach($role);
        $user->roles()->attach($role2);
        $user->roles()->attach($role3);

        $response = $this->withExceptionHandling()
                        ->deleteJson('/nova-api/roles/detach?viaResource=users&viaResourceId=1&viaRelationship=roles', [
                            'resources' => [$role->id, $role2->id],
                        ]);

        $response->assertStatus(200);

        $this->assertCount(1, User::first()->roles);

        $this->assertCount(2, ActionEvent::all());
        $this->assertEquals('Detach', ActionEvent::first()->name);
        $this->assertEquals($role->id, ActionEvent::where('target_id', $role->id)->first()->target->id);
    }

    public function test_can_detach_resources_via_search()
    {
        $user = $this->createUser();
        $role = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();
        $role3 = factory(Role::class)->create();

        $user->roles()->attach($role);
        $user->roles()->attach($role2);
        $user->roles()->attach($role3);

        $response = $this->withExceptionHandling()
                        ->deleteJson('/nova-api/roles/detach?search=1&viaResource=users&viaResourceId=1&viaRelationship=roles', [
                            'resources' => 'all',
                        ]);

        $response->assertStatus(200);

        $this->assertCount(2, User::first()->roles);

        $this->assertCount(1, ActionEvent::all());
        $this->assertEquals('Detach', ActionEvent::first()->name);
        $this->assertEquals($role->id, ActionEvent::where('target_id', $role->id)->first()->target->id);
    }

    public function test_can_detach_resources_via_filters()
    {
        $user = $this->createUser();
        $role = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();
        $role3 = factory(Role::class)->create();

        $user->roles()->attach($role);
        $user->roles()->attach($role2);
        $user->roles()->attach($role3);

        $filters = base64_encode(json_encode([
            [
                'class' => IdFilter::class,
                'value' => 1,
            ],
        ]));

        $response = $this->withExceptionHandling()
                        ->deleteJson('/nova-api/roles/detach?filters='.$filters.'&viaResource=users&viaResourceId=1&viaRelationship=roles', [
                            'resources' => 'all',
                        ]);

        $response->assertStatus(200);

        $this->assertCount(2, User::first()->roles);

        $this->assertCount(1, ActionEvent::all());
        $this->assertEquals('Detach', ActionEvent::first()->name);
        $this->assertEquals($role->id, ActionEvent::where('target_id', $role->id)->first()->target->id);
    }

    public function test_cant_detach_resources_not_authorized_to_detach()
    {
        $user = $this->createUser();
        $role = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();
        $role3 = factory(Role::class)->create();

        $user->roles()->attach($role);
        $user->roles()->attach($role2);
        $user->roles()->attach($role3);

        $_SERVER['nova.user.authorizable'] = true;
        $_SERVER['nova.user.detachRole'] = false;

        Gate::policy(User::class, UserPolicy::class);

        $response = $this->withExceptionHandling()
                        ->deleteJson('/nova-api/roles/detach?viaResource=users&viaResourceId=1&viaRelationship=roles', [
                            'resources' => [$role->id, $role2->id],
                        ]);

        unset($_SERVER['nova.user.authorizable']);
        unset($_SERVER['nova.user.detachRole']);

        $response->assertStatus(200);
        $this->assertCount(3, User::first()->roles);
        $this->assertCount(0, ActionEvent::all());
    }
}
