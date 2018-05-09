<?php

namespace Tests\Unit\Services;

use App\Services\PositionsServices;
use Tests\Support\Data\DepartmentID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionsServicesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\PositionsServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(PositionsServices::class);
    }

    /** @test */
    public function create()
    {
        $data = [
            'name'          => 'Some Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => 1,
            'has_union'     => 1,
        ];

        $position = $this->service->create($data);

        $this->assertDatabaseHas('positions', [
            'id' => $position->id,
        ]);

        $this->assertArraySubset(
            [
                'name'          => 'Some Position',
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => true,
                'has_union'     => true,
            ],
            $position->toArray()
        );
    }

    /** @test */
    public function filter_data()
    {
        $data = [
            'name'          => 'Some Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => 1,
            'has_union'     => 1,
            'not_included'  => 1,
        ];

        $this->assertSame(
            [
                'name'          => 'Some Position',
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => 1,
                'has_union'     => 1,
            ],
            $this->service->filterData($data)
        );
    }

    /** @test */
    public function prepare_data()
    {
        $this->assertSame(
            [
                'name'      => 'Some Position', // formatted name
                'has_gear'  => 0, // default value
                'has_union' => 0, // default value
            ],
            $this->service->prepareData([
                'name' => 'some position',
            ])
        );
    }
}
