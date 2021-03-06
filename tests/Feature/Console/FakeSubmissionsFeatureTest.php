<?php

namespace Tests\Feature\Console;

use App\Actions\Crew\StubCrew;
use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Role;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FakeSubmissionsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    private const CMD = 'fake:submissions';
    private const CMD_NEW = 'fake:submissions --new';

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function can_create_submissions_with_new_users_using_default_count()
    {
        $command = $this->artisan(self::CMD_NEW);
        $command->expectsOutput('Creating submissions with 10 new users with crew role')
            ->expectsOutput('Done creating submissions')
            ->run();

        $this->assertCount(10, Submission::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function can_create_submissions_with_new_users_using_custom_count()
    {
        $command = $this->artisan(self::CMD_NEW . ' --users=5');
        $command->expectsOutput('Creating submissions with 5 new users with crew role')
            ->expectsOutput('Done creating submissions')
            ->run();

        $this->assertCount(5, Submission::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function can_create_submissions_on_existing_crew_users()
    {
        $users = factory(User::class, 10)->create();
        $users->map(function ($user) {
            $user->assignRole(Role::CREW);
            app(StubCrew::class)->execute($user);
        });

        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating submissions from existing users with crew role')
            ->expectsOutput('Done creating submissions')
            ->run();

        $this->assertCount(10, Submission::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_create_submissions_with_new_users_when_no_existing_crew_users()
    {
        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating submissions from existing users with crew role')
            ->expectsOutput('No existing users found with crew role, creating submissions with 10 new users with crew role instead')
            ->expectsOutput('Done creating submissions')
            ->run();

        $this->assertCount(10, Submission::all());
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_create_a_user_with_producer_role_in_the_process()
    {
        $users = User::all();
        $this->assertCount(0, $users);

        $command = $this->artisan(self::CMD_NEW);
        $command->expectsOutput('Creating submissions with 10 new users with crew role')
            ->expectsOutput('Done creating submissions')
            ->run();

        $user = User::role(Role::PRODUCER)->first();

        $this->assertNotEmpty($user->toArray());
        $this->assertCount(11, User::all());
        $this->assertEquals(1, $user->id);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeSubmissions::handle
     */
    public function should_create_a_project_in_the_process()
    {
        $command = $this->artisan(self::CMD_NEW);
        $command->expectsOutput('Creating submissions with 10 new users with crew role')
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
        $command = $this->artisan(self::CMD_NEW);
        $command->expectsOutput('Creating submissions with 10 new users with crew role')
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
        $command = $this->artisan(self::CMD);
        $command->expectsOutput('Creating submissions from existing users with crew role')
            ->expectsOutput('No existing users found with crew role, creating submissions with 10 new users with crew role instead')
            ->expectsOutput('Done creating submissions')
            ->run();

        $producer = User::role(Role::PRODUCER)->first();
        $submissions = Submission::all();

        $submissions->map(function ($submission) use ($producer) {
            $this->assertTrue($producer->id !== $submission->crew_id);
        });
    }
}
