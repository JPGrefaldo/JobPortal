<?php

namespace Tests\Feature\API;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Http\Response;

class SubmissionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

   /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::index
     */
    public function can_fetch_job_and_all_submissions()
    {
        $this->withoutExceptionHandling();

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

        $response = $this->actingAs($producer, 'api')
            ->get(
                route(
                    'project.job.submissions.index',
                    ['job' => $projectJob->id]
                )
            )
            ->assertSee('Sucessfully fetched job\'s submissions')
            ->assertSuccessful();

        $response->assertJsonFragment($projectJob->toArray());
        $response->assertJsonFragment($projectJob->submissions->toArray());

    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::store
     */
    public function can_create_submissions()
    {
        $crew       = $this->createCrew();
        $projectJob = $this->createProjectAndJob();

        $crew = $this->createCrew();
        
        $data = [
            'crew_id'        => $crew->id,
            'project_job_id'  => $projectJob->id
        ];

        $response = $this->actingAs($crew, 'api')
            ->post(
                route(
                    'project.job.submissions.create',
                    ['job' => $projectJob->id]
                ),
                $data,
                [
                    'Accept' => 'application/json'
                ]
            )
            ->assertSee('Submission successfully added')
            ->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment($projectJob->submissions->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::index
     */
    public function cannot_fetch_submmissions_the_crew_role()
    {
        $crew       = $this->createCrew();
        $projectJob = $this->createProjectAndJob();

        $this->actingAs($crew, 'api')
            ->get(route(
                'project.job.submissions.index',
                ['job' => $projectJob->id]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::store
     */
    public function cannot_create_submissions_the_non_crew_role()
    {
        $user       = $this->createUser();
        $projectJob = $this->createProjectAndJob();
        $data       = [];

        $this->actingAs($user, 'api')
            ->post(
                route(
                    'project.job.submissions.create',
                    ['job' => $projectJob->id]
                ),
                $data,
                [
                    'Accept' => 'application/json'
                ]
            )
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    public function createProjectAndJob()
    {
        $producer = $this->createProducer();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id
        ]);

        return $projectJob;
    }
}