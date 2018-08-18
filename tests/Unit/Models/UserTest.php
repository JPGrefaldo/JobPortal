<?php

namespace Tests\Unit\Models;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\ProjectJob;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\UserSites;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function roles()
    {
        $role = Role::whereName(Role::PRODUCER)->firstOrFail();
        $user = factory(User::class)->create();
        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->assertEquals(1, $user->roles->count());
        $this->assertEquals("Producer", $user->roles->first()->name);
    }

    /** @test */
    public function sites()
    {
        $user = factory(User::class)->create();
        $site = $this->getCurrentSite();
        UserSites::create([
            'user_id' => $user->id,
            'site_id' => $site->id,
        ]);

        $this->assertEquals(1, $user->sites->count());
        $this->assertEquals($site->name, $user->sites->first()->name);
    }

    /**
     * @test
     * @expectedException App\Exceptions\ElectoralFraud
     */
    public function can_not_endorse_oneself()
    {
        $user       = factory(User::class)->create();
        $projectJob = factory(ProjectJob::class)->create();

        $user->endorse($user, $projectJob);

        $this->assertDatabaseMissing('endorsements', [
            'project_job_id' => $projectJob->id,
            'endorser_id'    => $user->id,
            'endorsee_id'    => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function hasPosition()
    {
        // $this->withOutExceptionHandling();
        // given
        $user            = factory(User::class)->create();
        $crew            = factory(Crew::class)->create(['user_id' => $user->id]);
        $appliedPosition = factory(Position::class)->create();
        $randomPosition  = factory(Position::class)->create();

        // when
        $crewPosition = factory(CrewPosition::class)->create(['crew_id' => $user->crew->id, 'position_id' => $appliedPosition->id]);

        // then
        $this->assertTrue($user->hasPosition($appliedPosition));
        $this->assertFalse($user->hasPosition($randomPosition));
    }
}
