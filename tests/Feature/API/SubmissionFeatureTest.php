<?php

namespace Tests\Feature\API;

use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Submission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class SubmissionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
      * @test
      * @covers \App\Http\Controllers\API\SubmissionController::index
      */
    public function can_fetch_job_and_all_submissions()
    {
        $producer = $this->createProducer();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $crew = $this->createCrew();

        factory(Submission::class)->create([
            'crew_id'         => $crew->id,
            'project_id'      => $project->id,
            'project_job_id'  => $projectJob->id,
        ]);

        $response = $this->actingAs($producer, 'api')
            ->get(
                route(
                    'project.job.submissions.index',
                    ['job' => $projectJob]
                )
            )
            ->assertSee('Sucessfully fetched job\'s submissions')
            ->assertSuccessful();

        $response->assertJsonFragment($projectJob->toArray());
        $response->assertJsonFragment($projectJob->submissions->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionController::store
     */
    public function can_store_submissions()
    {
        $crew     = $this->createCrew();
        $producer = $this->createProducer();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $data = [
            'crew_id'         => $crew->id,
            'project_id'      => $project->id,
            'project_job_id'  => $projectJob->id,
        ];

        $response = $this->actingAs($crew, 'api')
            ->postJson(
                route(
                    'project.job.submissions.store',
                    ['job' => $projectJob]
                ),
                $data
            )
            ->assertSee('Submission successfully added')
            ->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonFragment($projectJob->submissions->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::approve
     */
    public function can_approve_submissions()
    {
        $producer   = $this->createProducer();
        $projectJob = $this->createSubmission($producer);

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.submissions.approve',
                ['job' => $projectJob]
            ))
            ->assertSee('Submission is successfully approved')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::reject
     */
    public function can_reject_submissions()
    {
        $producer   = $this->createProducer();
        $projectJob = $this->createSubmission($producer);

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.submissions.reject',
                ['job' => $projectJob]
            ))
            ->assertSee('Submission is successfully rejected')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::restore
     */
    public function can_restore_submissions()
    {
        $producer   = $this->createProducer();
        $projectJob = $this->createSubmission($producer);

        $this->actingAs($producer, 'api')
        ->postJson(route(
            'producer.projects.submissions.reject',
            ['job' => $projectJob]
        ))
        ->assertSee('Submission is successfully rejected')
        ->assertStatus(Response::HTTP_OK);

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.submissions.restore',
                ['job' => $projectJob]
            ))
            ->assertSee('Submission is successfully restored')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::index
     */
    public function cannot_fetch_submmissions_as_crew()
    {
        $crew       = $this->createCrew();
        $projectJob = $this->createProjectAndJob();

        $this->actingAs($crew, 'api')
            ->get(route(
                'project.job.submissions.index',
                ['job' => $projectJob]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionController::store
     */
    public function must_be_crew_to_store_submissions()
    {
        $user       = $this->createUser();
        $projectJob = $this->createProjectAndJob();
        $data       = [];

        $this->actingAs($user, 'api')
            ->postJson(
                route(
                    'project.job.submissions.store',
                    ['job' => $projectJob]
                ),
                $data
            )
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::approve
     */
    public function must_be_producer_to_approve_submissions()
    {
        $producer   = $this->createProducer();
        $projectJob = $this->createSubmission($producer);
        $user       = $this->createUser();

        $this->actingAs($user, 'api')
            ->postJson(route(
                'producer.projects.submissions.approve',
                ['job' => $projectJob]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();

        $crew       = $this->createCrew();

        $this->actingAs($crew, 'api')
            ->postJson(route(
                'producer.projects.submissions.approve',
                ['job' => $projectJob]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::reject
     */
    public function must_be_producer_to_reject_submissions()
    {
        $producer   = $this->createProducer();
        $projectJob = $this->createSubmission($producer);
        $user       = $this->createUser();

        $this->actingAs($user, 'api')
            ->postJson(route(
                'producer.projects.submissions.reject',
                ['job' => $projectJob]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();

        $crew       = $this->createCrew();

        $this->actingAs($crew, 'api')
            ->postJson(route(
                'producer.projects.submissions.reject',
                ['job' => $projectJob]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::restore
     */
    public function must_be_producer_to_restore_submissions()
    {
        $producer   = $this->createProducer();
        $projectJob = $this->createSubmission($producer);
        $user       = $this->createUser();

        $this->actingAs($user, 'api')
            ->postJson(route(
                'producer.projects.submissions.restore',
                ['job' => $projectJob]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();

        $crew       = $this->createCrew();

        $this->actingAs($crew, 'api')
            ->postJson(route(
                'producer.projects.submissions.restore',
                ['job' => $projectJob]
            ))
            ->assertSee('User does not have the right roles.')
            ->assertForbidden();
    }

    protected function createProjectAndJob()
    {
        $producer = $this->createProducer();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        return $projectJob;
    }

    private function createSubmission($producer)
    {
        $project  = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $crew = $this->createCrew();

        factory(Submission::class)->create([
            'crew_id'         => $crew->id,
            'project_id'      => $project->id,
            'project_job_id'  => $projectJob->id,
        ]);

        return $projectJob;
    }
}
