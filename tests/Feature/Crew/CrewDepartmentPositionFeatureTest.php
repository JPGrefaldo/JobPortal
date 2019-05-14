<?php

namespace Tests\Feature\Crews;

use App\Models\CrewResume;
use App\Models\Position;
use App\Models\ProjectJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class CrewDepartmentPositionTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::store
     */
    public function store()
    {
        // given
        // $this->withoutExceptionHandling();

        Storage::fake('s3');
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'resume'            => UploadedFile::fake()->create('resume.pdf'),
            'bio'               => 'This is the bio',
            'gear'              => 'This is the gear',
            'union_description' => 'Some union description',
            'reel_link'         => 'https://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $response = $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data);

        $response->assertSuccessful();

        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseHas('crew_gears', [
            'crew_id'     => $crew->id,
            'description' => $data['gear'],
        ]);

        $this->assertDatabaseHas('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::applJob
    */
    public function cannot_apply_job_without_general_resume()
    {
        // $this->withoutExceptionHandling();

        $crew     = $this->createCrew();
        $job      = factory(ProjectJob::class)->create();

        $response = $this->actingAs($crew)
           ->postJson(route('crew.job.apply', $job->id));

        $response->assertStatus(403)
            ->assertSee('Please upload General Resume');

        $this->assertDatabaseMissing('submissions', [
            'crew_id'              => $crew->id,
            'project_id'           => $job->project_id,
            'project_job_id'       => $job->project_id,
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewPositionController::applJob
    */
    public function applyJob()
    {
        // $this->withoutExceptionHandling();

        $crew     = $this->createCrew();
        $job      = factory(ProjectJob::class)->create();

        factory(CrewResume::class)->create(['crew_id' => $crew->id]);

        $response = $this->actingAs($crew)
            ->postJson(route('crew.job.apply', $job->id));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'success',
                'submission' => [
                    'crew_id'              => $crew->id,
                    'project_id'           => $job->project_id,
                    'project_job_id'       => $job->project_id,
                ]
            ]);

        $this->assertDatabaseHas('submissions', [
            'crew_id'              => $crew->id,
            'project_id'           => $job->project_id,
            'project_job_id'       => $job->project_id,
        ]);
    }
}
