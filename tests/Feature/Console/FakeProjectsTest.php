<?php

namespace Tests\Feature\Console;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class FakeProjectsTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    const CMD = 'fake:projects';
    const HOST_NAME = 'test-crewcalls.dev';

    public function setUp(): void
    {
        parent::setUp();

        config([
            'app.name' => 'Crewcalls Test',
            'app.url'  => 'http://' . self::HOST_NAME,
        ]);

        factory(Site::class)->create([
            'name'     => 'Crewcalls Test',
            'hostname' => self::HOST_NAME,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeProjects::handle
     */
    public function create_projects_with_jobs()
    {
        $user = $this->createProducer();

        $this->assertEmpty(Project::count());
        $this->assertEmpty(ProjectJob::count());

        $command = $this->artisan(self::CMD);

        $command->expectsOutput('Projects created.')
            ->run();

        $this->assertNotEmpty(Project::count());

        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
        ]);

        $this->assertNotEmpty(ProjectJob::count());

        $this->assertDatabaseHas('project_jobs', [
            'project_id' => Project::whereUserId($user->id)->first()->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeProjects::handle
     */
    public function create_projects_with_number()
    {
        $user = $this->createProducer();
        $number = rand(1, 10);


        $command = $this->artisan(self::CMD, [
            'number' => $number,
        ]);

        $command->expectsOutput('Projects created.')
            ->run();

        $this->assertEquals($number, Project::count());

        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeProjects::handle
     */
    public function create_projects_with_user_id()
    {
        $number = rand(2, 10);

        for ($i = 1; $i <= $number; $i++) {
            $user = $this->createProducer();
        }

        $command = $this->artisan(self::CMD, [
            'user' => $user->id,
        ]);

        $command->expectsOutput('Projects created.')
            ->run();

        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseMissing('projects', [
            'user_id' => 1,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeProjects::handle
     */
    public function create_projects_with_status()
    {
        $user = $this->createProducer();

        $command = $this->artisan(self::CMD, [
            'status' => 2,
        ]);

        $command->expectsOutput('Projects created.')
            ->run();

        $this->assertDatabaseHas('projects', [
            'user_id' => $user->id,
            'status'  => 2,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeProjects::handle
     */
    public function create_projects_with_not_approved()
    {
        $user = $this->createProducer();

        $command = $this->artisan(self::CMD, [
            'approved' => false,
        ]);

        $command->expectsOutput('Projects created.')
            ->run();

        $this->assertDatabaseHas('projects', [
            'user_id'      => $user->id,
            'approved_at'  => null,
        ]);
    }

    /**
     * @test
     * @covers \App\Console\Commands\FakeProjects::handle
     */
    public function create_projects_with_no_jobs()
    {
        $user = $this->createProducer();

        $this->assertEmpty(ProjectJob::count());

        $command = $this->artisan(self::CMD, [
            'jobs' => 0,
        ]);

        $command->expectsOutput('Projects created.')
            ->run();

        $this->assertDatabaseHas('projects', [
            'user_id'      => $user->id,
        ]);

        $this->assertEmpty(ProjectJob::count());
    }

}
