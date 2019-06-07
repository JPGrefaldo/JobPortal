<?php

namespace Tests\Feature\API\Crew;

use App\Models\CrewIgnoredJob;
use App\Models\CrewPosition;
use App\Models\Position;
use App\Models\Project;
use App\Models\ProjectJob;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectJobControllerTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers App\Http\Controllers\API\Crew/ProjectJobController::ignore
     */
    public function can_ignore_a_job()
    {
        $crew   = $this->createCrew();
        $job    = $this->seedOpenJob($crew);

        $this->actingAs($crew, 'api')
            ->postJson(route('crew.ignore.jobs', $job))
            ->assertSee('Successfully ignored the job')
            ->assertSuccessful();
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\Crew/ProjectJobController::unignore
     */
    public function can_unignore_a_job()
    {
        $crew   = $this->createCrew();
        $job    = $this->seedIgnoredJob($crew);

        $this->assertCount(1, CrewIgnoredJob::all());

        $this->actingAs($crew, 'api')
            ->postJson(route('crew.unignore.jobs', $job))
            ->assertSee('Successfully unignored the job')
            ->assertSuccessful();

        $this->assertCount(0, CrewIgnoredJob::all());
    }


    /**
     * @test
     * @covers App\Http\Controllers\API\Crew/ProjectJobController::ignored
     */
    public function can_fetch_ignored_jobs()
    {
        $crew   = $this->createCrew();
        $job    = $this->seedIgnoredJob($crew);

        $this->assertCount(1, ProjectJob::all());
        $this->assertCount(1, CrewIgnoredJob::all());

        $response = $this->actingAs($crew, 'api')
            ->get(route('crew.ignored.jobs'))
            ->assertSee('Successfully fetched crew\'s ignored jobs')
            ->assertSuccessful();

        $response->assertJson(
            [
                'jobs' => [$job->toArray()]
            ]
        );
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\Crew/ProjectJobController::submissions
     */
    public function can_fetch_submissions()
    {
        $crew       = $this->createCrew();
        $submission = $this->seedNewSubmission($crew);

        $response = $this->actingAs($crew, 'api')
            ->get(route('crew.submissions'))
            ->assertSee('Successfully fetched crew\'s submissions')
            ->assertSuccessful();

        $response->assertJson(
            [
                'jobs' => [$submission->toArray()]
            ]
        );
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\Crew/ProjectJobController::submissions
     */
    public function should_only_fetch_submissions_that_are_less_than_90_days()
    {
        // $this->withoutExceptionHandling();

        $crew           = $this->createCrew();
        $newSubmission  = $this->seedNewSubmission($crew);
        $oldSubmission  = $this->seedOldSubmission($crew);

        $this->assertCount(2, ProjectJob::all());

        $response = $this->actingAs($crew, 'api')
            ->get(route('crew.submissions'))
            ->assertSee('Successfully fetched crew\'s submissions')
            ->assertSuccessful();

        $response->assertJson(
            [
                'jobs' => [$newSubmission->toArray()]
            ]
        );
        $response->assertJsonMissing(
            [
                'jobs' => [$oldSubmission->toArray()]
            ]
        );
    }

    /**
     * @test
     * @covers App\Http\Controllers\API\Crew/ProjectJobController::ignored
     */
    public function should_only_return_ignored_jobs()
    {
        $crew           = $this->createCrew();
        $jobIgnored     = $this->seedIgnoredJob($crew);
        $jobOpen        = $this->seedOpenJob($crew);
        $jobSubmission  = $this->seedNewSubmission($crew);

        $this->assertCount(3, ProjectJob::all());
        $this->assertCount(1, CrewIgnoredJob::all());

        $response = $this->actingAs($crew, 'api')
            ->get(route('crew.ignored.jobs'))
            ->assertSee('Successfully fetched crew\'s ignored jobs')
            ->assertSuccessful();


        $response->assertJson(
            [
                'jobs' => [$jobIgnored->toArray()]
            ]
        );
        $response->assertJsonMissing(
            [
                'jobs' => [$jobOpen->toArray()]
            ]
        );
        $response->assertJsonMissing(
            [
                'jobs' => [$jobSubmission->toArray()]
            ]
        );
    }

    /**
    * @test
    * @covers App\Http\Controllers\API\Crew/ProjectJobController::ignored
    */
    public function should_only_return_ignored_jobs_matched_to_crew_position()
    {
        $crew       = $this->createCrew();
        $position   = factory(Position::class)->create([
            'name' => 'Cameraman',
        ]);
        factory(CrewPosition::class)->create([
            'crew_id'       => $crew->id,
            'position_id'   => $position->id
        ]);

        $project    = factory(Project::class)->create();
        $jobIgnored = $this->createProjectJob($project, $position);
        factory(CrewIgnoredJob::class)->create([
            'crew_id'        => $crew->id,
            'project_job_id' => $jobIgnored->id
        ]);

        $crew2          = $this->createCrew();
        $notMatchedJob  = $this->seedIgnoredJob($crew2);

        $this->assertCount(2, ProjectJob::all());
        $this->assertCount(2, CrewIgnoredJob::all());
        $this->assertCount(2, CrewPosition::all());

        $response = $this->actingAs($crew, 'api')
            ->get(route('crew.ignored.jobs'))
            ->assertSee('Successfully fetched crew\'s ignored jobs')
            ->assertSuccessful();


        $response->assertJson(
            [
                'jobs' => [$jobIgnored->toArray()]
            ]
        );
        $response->assertJsonMissing(
            [
                'jobs' => [$notMatchedJob->toArray()]
            ]
        );
    }

    private function seedOpenJob($crew)
    {
        $project    = factory(Project::class)->create();
        $position   = $this->createCrewPosition($crew->id);
        $job        = $this->createProjectJob($project, $position);

        return $job;
    }

    private function seedIgnoredJob($crew)
    {
        $project    = factory(Project::class)->create();
        $position   = $this->createCrewPosition($crew->id);
        $job        = $this->createProjectJob($project, $position);

        factory(CrewIgnoredJob::class)->create(
            [
                'crew_id'        => $crew->id,
                'project_job_id' => $job->id
            ]
        );

        return $job;
    }

    private function seedNewSubmission($crew)
    {
        $project    = factory(Project::class)->create();
        $position   = $this->createCrewPosition($crew->id);
        $job        = $this->createProjectJob($project, $position);

        factory(Submission::class)->create(
            [
                'crew_id'          => $crew->id,
                'project_id'       => $project->id,
                'project_job_id'   => $job->id
            ]
        );

        return $job;
    }

    private function seedOldSubmission($crew)
    {
        $project    = factory(Project::class)->create();
        $position   = $this->createCrewPosition($crew->id);
        $job        = $this->createProjectJob($project, $position);

        factory(Submission::class)->create(
            [
                'crew_id'          => $crew->id,
                'project_id'       => $project->id,
                'project_job_id'   => $job->id,
                'created_at'       => Carbon::now()->subDays(91),
            ]
        );

        return $job;
    }

    private function createCrewPosition($crewId)
    {
        $position = factory(Position::class)->create(
            [
                'name' => 'Prosthetics/FX Makeup'
            ]
        );
        factory(CrewPosition::class)->create(
            [
                'crew_id'       => $crewId,
                'position_id'   => $position->id
            ]
        );

        return $position;
    }

    private function createProjectJob($project, $position)
    {
        return factory(ProjectJob::class)->create(
            [
                'project_id'    => $project->id,
                'position_id'   => $position->id,
                'rush_call'     => 0
            ]
        );
    }
}
