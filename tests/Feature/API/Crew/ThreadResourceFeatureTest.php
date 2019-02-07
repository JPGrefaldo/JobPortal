<?php

namespace Tests\Feature\API\Crew;

use App\Http\Resources\ThreadResource;
use App\Models\Crew;
use App\Models\CrewProject;
use App\Models\Project;
use App\Models\ProjectThread;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ThreadResourceFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\ThreadsController::index
     */
    public function index()
    {
        // given
        $user = $this->createCrew();
        $crew = factory(Crew::class)->create();
        $project = factory(Project::class)->create();
        $crewProject = factory(CrewProject::class)->create([
            'crew_id' => $crew->id,
            'project_id' => $project->id,
        ]);
        $threads = factory(Thread::class, 3)->create();

        foreach ($threads as $thread) {
            $projectThreads = factory(ProjectThread::class)->create([
                'project_id' => $project->id,
                'thread_id' => $thread->id,
            ]);
        }

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('crew.threads.index', $project));

        // then
        $response->assertSuccessful();

        $json = $response->json();

        $resource = ThreadResource::collection($threads);

        $resourceResponse = $resource->response()->getData(true);

        $this->assertEquals(
            $resourceResponse['data'],
            $json['data']
        );
    }
}
