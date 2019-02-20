<?php

namespace Tests\Feature\API\Crew;

use App\Http\Resources\ProjectResource;
use App\Models\CrewProject;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectResourceFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Crew\ProjectsController::index
     */
    public function index()
    {
        // $this->withoutExceptionHandling();

        // given
        $user = $this->createCrew();
        $crew = $user->crew;
        factory(CrewProject::class, 3)->create([
            'crew_id' => $crew->id,
        ]);
        $projects = Project::all();

        $this->assertCount(3, $projects);

        // when
        $response = $this->actingAs($user, 'api')
            ->getJson(route('crew.projects.index'));

        // then
        $response->assertSuccessful();

        $json = $response->json();

        $resource = ProjectResource::collection($projects);

        $resourceResponse = $resource->response()->getData(true);

        $this->assertEquals($resourceResponse['data'], $json['data']);
    }
}
