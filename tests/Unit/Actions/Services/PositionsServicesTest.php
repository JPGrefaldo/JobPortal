<?php

namespace Tests\Unit\Actions\Services;

use App\Models\Position;
use App\Services\PositionsServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\DepartmentID;
use Tests\Support\Data\PositionTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class PositionsServicesTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @var \App\Services\PositionsServices
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app(PositionsServices::class);
    }

    /**
     * @test
     * @covers \App\Services\PositionsServices::create
     */
    public function create()
    {
        $data = [
            'name'             => 'Some Position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
            'has_gear'         => 1,
            'has_union'        => 1,
        ];

        $position = $this->service->create($data);

        $this->assertDatabaseHas('positions', [
            'id' => $position->id,
        ]);

        $this->assertArrayHas(
            [
                'name'             => 'Some Position',
                'department_id'    => DepartmentID::PRODUCTION,
                'position_type_id' => PositionTypeID::PRE_PRODUCTION,
                'has_gear'         => true,
                'has_union'        => true,
            ],
            $position->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Services\PositionsServices::filterData
     */
    public function filter_data()
    {
        $this->assertSame(
            [
                'name'          => 'Some Position',
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => 1,
                'has_union'     => 1,
            ],
            $this->service->filterData([
                'name'          => 'Some Position',
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => 1,
                'has_union'     => 1,
                'not_included'  => 1,
            ])
        );
    }

    /**
     * @test
     * @covers \App\Services\PositionsServices::prepareData
     */
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

    /**
     * @test
     * @covers \App\Services\PositionsServices::update
     */
    public function update()
    {
        $position = factory(Position::class)->create();
        $data = [
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => 1,
            'has_union'     => 1,
        ];

        $position = $this->service->update($data, $position);

        $this->assertArrayHas([
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => true,
            'has_union'     => true,
        ], $position->refresh()->toArray());
    }
}
