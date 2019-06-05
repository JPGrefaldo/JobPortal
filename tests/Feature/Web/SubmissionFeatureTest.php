<?php

namespace Tests\Feature\Web;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SubmissionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Http\Controllers\SubmissionController::store
     */
    public function show()
    {
        $crew = $this->createCrew();
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        factory(Submission::class)->create([
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
        ]);

        $response = $this->actingAs($producer)
            ->get(
                route(
                    'project.job.submissions.show',
                    [
                        'project' => $project->id,
                        'job'     => $projectJob->id,
                    ]
                )
            )
            ->assertSuccessful();

        $response->assertSee('Submission');
    }

    /**
     * @test
     * @covers App\Http\Controllers\SubmissionController::show
     */
    public function should_include_crew_how_many_roles_applied_in_a_project()
    {
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJobs = factory(ProjectJob::class, 3)->create([
            'project_id' => $project->id,
        ]);

        $crew = $this->createCrew();

        $projectJobs->map(function ($projectJob) use ($crew, $project) {
            factory(Submission::class)->create([
                'crew_id'        => $crew->id,
                'project_id'     => $project->id,
                'project_job_id' => $projectJob->id,
            ]);
        });

        $projectJobs->map(function ($job) use ($project) {
            $submissions = $job->submissions()->get();

            $submissions->map(function ($submission) use ($project) {
                $this->assertEquals(
                    3,
                    Submission::where(
                        [
                            'crew_id'    => $submission->crew_id,
                            'project_id' => $project->id,
                        ]
                    )->count()
                );
            });
        });
    }
}
