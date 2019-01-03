<?php

namespace Tests\Unit;

use App\Models\Crew;
use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\ProjectType;
use App\Models\RemoteProject;
use App\ProjectThread;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @covers \App\Models\Project::type
     */
    public function type()
    {
        $projectType = factory(ProjectType::class)->create();

        $project = factory(Project::class)->create([
            'project_type_id' => $projectType->id,
        ]);

        $this->assertEquals($projectType->name, $project->type->name);
    }

    /**
     * @test
     * @covers \App\Models\Project::remotes
     */
    public function remotes()
    {
        $project = factory(Project::class)->create();

        $remoteProject = factory(RemoteProject::class, 3)->create([
            'project_id' => $project->id,
        ]);

        $this->assertCount(3, $project->remotes);
    }

    /**
     * @test
     * @covers \App\Models\Project::jobs
     */
    public function jobs()
    {
        $project = factory(Project::class)->create();

        $jobs = factory(ProjectJob::class, 3)->create([
            'project_id' => $project->id,
        ]);

        $this->assertCount(3, $project->jobs);
    }

    /**
     * @test
     * @covers \App\Models\Project::contributors
     */
    public function contributors()
    {
        $project = factory(Project::class)->create();
        $crews = factory(Crew::class, 3)->create();

        $project->contributors()->attach($crews);

        $this->assertCount(3, $project->contributors);
    }

    /**
     * @test
     * @covers \App\Models\Project::owner
     */
    public function owner()
    {
        $project = factory(Project::class)->create();
        $producer = $this->createUser();

        $project->owner()->associate($producer);

        $this->assertEquals(
            $project->owner->first_name,
            $producer->first_name
        );
    }

    /**
     * @test
     * @covers \App\Models\Project::threads
     */
    public function threads()
    {
        $project = factory(Project::class)->create();
        $thread = factory(Thread::class)->create();

        $project->threads()->attach($thread);

        $this->assertCount(1, ProjectThread::all());
        $this->assertDatabaseHas('project_thread', [
            'project_id' => $project->id,
            'thread_id' => $thread->id,
        ]);
    }
}
