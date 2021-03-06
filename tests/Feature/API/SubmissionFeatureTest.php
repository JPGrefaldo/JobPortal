<?php

namespace Tests\Feature\API;

use App\Models\CrewResume;
use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Submission;
use Carbon\Carbon;
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

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $crew = $this->createCrew();

        factory(Submission::class)->create([
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
        ]);

        $response = $this->actingAs($producer, 'api')
            ->get(
                route(
                    'project.job.submissions.index',
                    ['job' => $projectJob]
                )
            )
            ->assertSuccessful()
            ->assertSee('Sucessfully fetched job\'s submissions');

        $response->assertJsonFragment($projectJob->toArray());
        $response->assertJsonFragment($projectJob->submissions->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::index
     */
    public function can_fetch_all_approved_submissions()
    {
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $crew = $this->createCrew();
        $crew2 = $this->createCrew();

        factory(Submission::class)->create([
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
            'approved_at'    => Carbon::now(),
        ]);

        factory(Submission::class)->create([
            'crew_id'        => $crew2->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
            'approved_at'    => Carbon::now(),
        ]);

        $response = $this->actingAs($producer, 'api')
            ->get(
                route(
                    'fetch.submissions.by.approved',
                    ['job' => $projectJob]
                )
            )
            ->assertSuccessful()
            ->assertSee('Sucessfully fetched job\'s submissions');

        $response->assertJsonFragment($projectJob->submissions->first()->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionController::store
     */
    public function can_store_submissions()
    {
        // $this->withoutExceptionHandling();

        $crew = $this->createCrew();
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $data = [
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
            'note'           => 'Some note',
        ];

        factory(CrewResume::class)->create(['crew_id' => $crew->id]);

        $response = $this->actingAs($crew, 'api')
            ->postJson(
                route(
                    'crew.submissions.store',
                    ['job' => $projectJob]
                ),
                $data
            )
            ->assertStatus(Response::HTTP_CREATED)
            ->assertSee('Submission successfully added');

        $response->assertJsonFragment([
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
        ]);

        $submission = $projectJob->submissions()->first();
        $this->assertArrayHas(['body' => 'Some note'], $submission->note->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionController::approve
     */
    public function can_approve_submissions()
    {
        $producer = $this->createProducer();
        $projectJob = $this->seedSubmission($producer);

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.approve.submissions',
                ['job' => $projectJob->id]
            ))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Submission is successfully approved');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::reject
     */
    public function can_reject_submissions()
    {
        $producer = $this->createProducer();
        $projectJob = $this->seedSubmission($producer);

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.submissions.reject',
                ['job' => $projectJob]
            ))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Submission is successfully rejected');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::restore
     */
    public function can_restore_submissions()
    {
        $producer = $this->createProducer();
        $projectJob = $this->seedSubmission($producer);

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.submissions.reject',
                ['job' => $projectJob]
            ))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Submission is successfully rejected');

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.submissions.restore',
                ['job' => $projectJob]
            ))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Submission is successfully restored');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::swap
     */
    public function can_swap_submissions()
    {
        $producer = $this->createProducer();
        $projectJob = $this->seedSubmission($producer);
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $crew = $this->createCrew();

        $submissionToReject = factory(Submission::class)->create([
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
            'approved_at'    => Carbon::now(),
        ]);

        $crew2 = $this->createCrew();

        $submissionToApprove = factory(Submission::class)->create([
            'crew_id'        => $crew2->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
            'rejected_at'    => Carbon::now(),
        ]);

        $data = [
            'submissionToReject'  => $submissionToReject->id,
            'submissionToApprove' => $submissionToApprove->id,
        ];

        $this->assertNotEquals(null, $submissionToReject->approved_at);
        $this->assertNotEquals(null, $submissionToApprove->rejected_at);

        $this->actingAs($producer, 'api')
            ->postJson(route(
                'producer.projects.swap.submissions',
                $data
            ))
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Submission successfully swapped.');

        $this->assertEquals(null, $submissionToReject->fresh()->approved_at);
        $this->assertEquals(null, $submissionToApprove->fresh()->rejected_at);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionController::store
     */
    public function cannot_store_submissions_without_resume()
    {
        // $this->withoutExceptionHandling();

        $crew = $this->createCrew();
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $data = [
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
            'note'           => 'Some note',
        ];

        $this->actingAs($crew, 'api')
            ->postJson(
                route(
                    'crew.submissions.store',
                    ['job' => $projectJob]
                ),
                $data
            )
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertSee('Please upload General Resume');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionController::index
     */
    public function cannot_fetch_submmissions_as_crew()
    {
        $crew = $this->createCrew();
        $projectJob = $this->createProjectAndJob();

        $this->actingAs($crew, 'api')
            ->get(route(
                'project.job.submissions.index',
                ['job' => $projectJob]
            ))
            ->assertForbidden()
            ->assertSee('User does not have the right roles.');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionController::store
     */
    public function cannot_store_a_submission_without_crew_role()
    {
        $user = $this->createUser();
        $projectJob = $this->createProjectAndJob();
        $data = [];

        $this->actingAs($user, 'api')
            ->postJson(
                route(
                    'crew.submissions.store',
                    ['job' => $projectJob]
                ),
                $data
            )
            ->assertForbidden()
            ->assertSee('User does not have the right roles.');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::approve
     */
    public function cannot_approve_submissions_the_non_producer_role()
    {
        $producer = $this->createProducer();
        $projectJob = $this->seedSubmission($producer);
        $user = $this->createUser();

        $this->actingAs($user, 'api')
            ->postJson(route(
                'producer.projects.approve.submissions',
                ['job' => $projectJob->id]
            ))
            ->assertForbidden()
            ->assertSee('User does not have the right roles.');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::approve
     */
    public function cannot_reject_submissions_the_non_producer_role()
    {
        $producer = $this->createProducer();
        $projectJob = $this->seedSubmission($producer);
        $user = $this->createUser();

        $this->actingAs($user, 'api')
            ->postJson(route(
                'producer.projects.submissions.reject',
                ['job' => $projectJob]
            ))
            ->assertForbidden()
            ->assertSee('User does not have the right roles.');
    }

    /**
     * @test
     * @covers \App\Http\Controllers\API\SubmissionsController::approve
     */
    public function cannot_restore_submissions_the_non_producer_role()
    {
        $producer = $this->createProducer();
        $projectJob = $this->seedSubmission($producer);
        $user = $this->createUser();

        $this->actingAs($user, 'api')
            ->postJson(route(
                'producer.projects.submissions.restore',
                ['job' => $projectJob->id]
            ))
            ->assertForbidden()
            ->assertSee('User does not have the right roles.');
    }

    protected function createProjectAndJob()
    {
        $producer = $this->createProducer();

        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        return $projectJob;
    }

    private function seedSubmission($producer)
    {
        $project = factory(Project::class)->create([
            'user_id' => $producer->id,
        ]);

        $projectJob = factory(ProjectJob::class)->create([
            'project_id' => $project->id,
        ]);

        $crew = $this->createCrew();
        factory(CrewResume::class)->create(['crew_id' => $crew->id]);

        factory(Submission::class)->create([
            'crew_id'        => $crew->id,
            'project_id'     => $project->id,
            'project_job_id' => $projectJob->id,
        ]);

        return $projectJob;
    }
}
