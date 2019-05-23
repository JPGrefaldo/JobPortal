<?php

namespace Tests\Feature\Crews;

use App\Models\CrewResume;
use App\Models\ProjectJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewSubmissionFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::store
    */
    public function cannot_apply_to_job_without_general_resume()
    {
        // $this->withoutExceptionHandling();

        $crew     = $this->createCrew();
        $job      = factory(ProjectJob::class)->create();

        $response = $this->actingAs($crew)
            ->postJson(route('crew.jobs.store', $job));

        $response->assertStatus(400)
            ->assertSee('Please upload General Resume');

        $this->assertDatabaseMissing('submissions', [
            'crew_id'              => $crew->id,
            'project_id'           => $job->project_id,
            'project_job_id'       => $job->project_id,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::store
    */
    public function store()
    {
        // $this->withoutExceptionHandling();

        $crew     = $this->createCrew();
        $job      = factory(ProjectJob::class)->create();

        factory(CrewResume::class)->create(['crew_id' => $crew->id]);

        $response = $this->actingAs($crew)
            ->postJson(route('crew.jobs.store', $job));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'success'
            ]);

        $this->assertDatabaseHas('submissions', [
            'crew_id'              => $crew->id,
            'project_id'           => $job->project_id,
            'project_job_id'       => $job->project_id,
        ]);
    }
}
