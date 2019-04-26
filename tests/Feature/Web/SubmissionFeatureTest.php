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
     * @covers App\Http\Controllers\SubmissionsController::store
     */
    public function show()
    {
        $producer = $this->createProducer();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id
        ]);

        $crew = $this->createCrew();
        
        factory(Submission::class)->create([
            'crew_id'        => $crew->id,
            'project_job_id'  => $projectJob->id
        ]);

        $response = $this->actingAs($producer)
            ->get(
                route(
                    'project.job.submissions.show',
                    [   
                        'project' => $project->id,
                        'job' => $projectJob->id
                    ]
                )
            )
            ->assertSuccessful();
        
        $response->assertSee('Submissions');
    }
}