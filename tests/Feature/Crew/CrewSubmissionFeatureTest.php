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

class CrewSubmissionFeatureTest extends TestCase
{
    use RefreshDatabase,
        SeedDatabaseAfterRefresh,
        WithFaker;

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
            ->postJson(route('crew.jobs.store', $job->id));

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

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_position_requires_gear()
    {
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create([
            'has_gear' => 1,
        ]);

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'resume'            => UploadedFile::fake()->create('resume.doc'),
            'union_description' => 'Some union description',
            'reel_link'         => 'http://www.youtube.com/embed/G8S81CEBdNs',
        ];

        $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data)
            ->assertJsonValidationErrors('gear');

        $this->assertDatabaseMissing('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseMissing('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\CrewProfileController::store
     */
    public function create_position_dont_require_gear()
    {
        $crew     = $this->createCrew();
        $position = factory(Position::class)->create();

        $data = [
            'position_id'       => $position->id,
            'bio'               => 'This is the bio',
            'resume'            => UploadedFile::fake()->create('resume.doc'),
            'union_description' => 'Some union description',
            'reel_link'         => "http://www.youtube.com/embed/G8S81CEBdNs",
        ];

        $this->actingAs($crew)
            ->postJson(route('crew-position.store', $position), $data)
            ->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('crew_position', [
            'crew_id'           => $crew->id,
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        $this->assertDatabaseMissing('crew_reels', [
            'crew_id' => $crew->id,
            'path'    => $data['reel_link'],
        ]);
    }
}
