<?php

namespace Tests\Unit\Services;

use App\Services\ProjectsServices;
use Tests\Support\Data\ProjectTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsServicesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\ProjectsServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(ProjectsServices::class);
    }

    /** @test */
    public function create()
    {
        $user = $this->createProducer();
        $data = [
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => 1,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'user_id'                => $user->id,
        ];

        $project = $this->service->create($data);

        $this->assertArraySubset([
            'title'                  => 'Some Title',
            'production_name'        => 'Some Production Name',
            'production_name_public' => true,
            'project_type_id'        => ProjectTypeID::TV,
            'description'            => 'Some Description',
            'location'               => 'Some Location',
            'status'                 => 0,
            'user_id'                => $user->id
        ], $project->refresh()->toArray());
    }
}
