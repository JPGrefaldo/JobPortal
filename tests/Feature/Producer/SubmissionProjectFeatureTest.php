<?php

namespace Tests\Feature\Producer;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use App\Models\Project;
use App\Models\ProjectJob;

class SubmissionProjectFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

   /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::submission
     */
    public function submission()
    {
        $producer = $this->createProducer();

        $project  = factory(Project::class)->create([
            'user_id' => $producer->id
        ]);

        $project_job = factory(ProjectJob::class)->create([
            'project_id' => $project->id
        ]);
    }
}
