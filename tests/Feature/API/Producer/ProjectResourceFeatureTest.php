<?php

namespace Tests\Feature\API\Producer;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class ProjectResourceFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Producer\ProjectsController::index
     */
    public function index()
    {
        // $this->withoutExceptionHandling();

        // given
        $producer = $this->createProducer();
        $projects = factory(Project::class, 3)->create([
            'user_id' => $producer->id,
        ]);

        $this->assertCount(3, Project::all());

        // when
        $response = $this->actingAs($producer, 'api')
            ->getJson(route('producer.projects.index'));

        // then
        $response->assertSuccessful();

        $json = $response->json();

        $resource = ProjectResource::collection($projects);

        $resourceResponse = $resource->response()->getData(true);

        $this->assertEquals($resourceResponse['data'], $json['data']);
    }
}
