<?php

namespace Tests\Feature\Console;

use App\Models\Role;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\Project;
use App\Models\ProjectJob;

class FakeSubmissionsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    private const CMD = 'fake:submissions';

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function can_create_submissions_on_new_created_crew_users()
    {
        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating submissions from 10 new users with crew role')
                ->expectsOutput('Done creating submissions')
                ->run();

        $submissions = Submission::all();
        $this->assertEquals(10, count($submissions));
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function can_create_submissions_on_existing_crew_users()
    {
        $users = factory(User::class, 10)->create();
        $users->map(function($user) {
            $user->assignRole(Role::CREW);
        });

        $command = $this->artisan(self::CMD, [ 'new' => 'false' ]);
        $command->expectsOutput('Creating submissions from existing users with crew role')
                ->expectsOutput('Done creating submissions')
                ->run();

        $submissions = Submission::all();
        $this->assertEquals(10, count($submissions));
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_create_submissions_from_new_users_when_no_existing_crew_users()
    {
        $command = $this->artisan(self::CMD, [ 'new' => 'false' ]);
        $command->expectsOutput('Creating submissions from existing users with crew role')
                ->expectsOutput('No users found with crew role, creating submissions from 10 new users with crew role instead')
                ->expectsOutput('Done creating submissions')
                ->run();

        $submissions = Submission::all();
        $this->assertEquals(10, count($submissions));
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_create_a_user_with_producer_role_in_the_process()
    {
        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating submissions from 10 new users with crew role')
                ->expectsOutput('Done creating submissions')
                ->run();
        
        $user   = User::role(Role::PRODUCER)->first();

        $this->assertNotEmpty($user->toArray());
        $this->assertEquals(11, $user->id);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_create_a_project_in_the_process()
    {
        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating submissions from 10 new users with crew role')
                ->expectsOutput('Done creating submissions')
                ->run();
        
        $project = Project::all();

        $this->assertNotEmpty($project[0]->toArray());
        $this->assertEquals(1, $project[0]->id);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_create_a_project_job_in_the_process()
    {
        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating submissions from 10 new users with crew role')
                ->expectsOutput('Done creating submissions')
                ->run();
        
        $projectJob = ProjectJob::all();

        $this->assertNotEmpty($projectJob[0]->toArray());
        $this->assertEquals(1, $projectJob[0]->id);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_not_include_the_users_with_producer_role_when_creating_submission()
    {
        $command = $this->artisan(self::CMD, [ 'new' => 'false' ]);
        $command->expectsOutput('Creating submissions from existing users with crew role')
                ->expectsOutput('No users found with crew role, creating submissions from 10 new users with crew role instead')
                ->expectsOutput('Done creating submissions')
                ->run();

        $producer    = User::role(Role::PRODUCER)->first();
        $submissions = Submission::all();

        $submissions->map(function($submission) use($producer) {
            $this->assertTrue($producer->id !== $submission->crew_id);
        });
    }
}
