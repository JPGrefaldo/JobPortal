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
     */
    public function type()
    {
        // given
        $projectType = factory(ProjectType::class)->create();

        // when
        $project = factory(Project::class)->create([
            'project_type_id' => $projectType->id,
        ]);


        // then
        $this->assertEquals($projectType->name, $project->type->name);
    }

    /**
     * @test
     */
    public function remotes()
    {
        // given
        $project = factory(Project::class)->create();

        // when
        $remoteProject = factory(RemoteProject::class, 3)->create([
            'project_id' => $project->id,
        ]);

        // then
        $this->assertCount(3, $project->remotes);
    }

    /**
     * @test
     */
    public function jobs()
    {
        // given
        $project = factory(Project::class)->create();

        // when
        $jobs = factory(ProjectJob::class, 3)->create([
            'project_id' => $project->id,
        ]);

        // then
        $this->assertCount(3, $project->jobs);
    }

    /**
     * @test
     */
    public function contributors()
    {
        // given
        $project = factory(Project::class)->create();
        $crews = factory(Crew::class, 3)->create();

        // when
        $project->contributors()->attach($crews);

        // then
        $this->assertCount(3, $project->contributors);
    }

    /**
     * @test
     */
    public function owner()
    {
        // given
        $project = factory(Project::class)->create();
        $producer = $this->createUser();

        // when
        $project->owner()->associate($producer);

        // then
        $this->assertEquals(
            $project->owner->first_name,
            $producer->first_name
        );
    }

    /**
     * @test
     */
    public function threads()
    {
        // given
        $project = factory(Project::class)->create();
        $thread = factory(Thread::class)->create();

        // when
        $project->threads()->attach($thread);

        // then
        $this->assertCount(1, ProjectThread::all());
        $this->assertDatabaseHas('project_thread', [
            'project_id' => $project->id,
            'thread_id' => $thread->id,
        ]);
    }

    /**
     * @test
     */
    public function get_attribute_test()
    {
        // given
        $project = factory(Project::class)->create([
            'title' => 'The Hitchhiker\'s Guide to the Galaxy'
        ]);

        // then
        $this->assertEquals('TH', $project->acronym);
    }
}
