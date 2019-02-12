<?php

namespace Tests\Unit\Services;

use App\Models\Department;
use App\Services\DepartmentsServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentsServicesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Services\DepartmentsServices
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = app(DepartmentsServices::class);
    }

    /**
     * @test
     * @covers  \App\Services\DepartmentsServices::create
     */
    public function create()
    {
        $this->service->create([
            'name'        => 'Lighting',
            'description' => 'Some Description',
        ]);

        $this->assertDatabaseHas('departments', [
            'name'        => 'Lighting',
            'description' => 'Some Description',
        ]);
    }

    /**
     * @test
     * @covers \App\Services\DepartmentsServices::filterData
     */
    public function filter_data()
    {
        $data = [
            'name'         => 'Lighting',
            'description'  => 'Some Description',
            'not_included' => 'asdasdasd',
        ];

        $this->assertEquals(
            [
                'name'        => 'Lighting',
                'description' => 'Some Description',
            ],
            $this->service->filterData($data)
        );
    }

    /**
     * @test
     * @covers \App\Services\DepartmentsServices::formatData
     */
    public function format_data()
    {
        $this->assertSame(
            [
                'name'        => 'Production Sound',
                'description' => '',
            ],
            $this->service->formatData([
                'name'        => 'Production sound',
                'description' => null,
            ])
        );
    }

    /**
     * @test
     * @covers \App\Services\DepartmentsServices::update
     */
    public function update()
    {
        $department = factory(Department::class)->create();
        $data       = [
            'name'        => 'New Name',
            'description' => 'New Description',
        ];

        $this->service->update($data, $department);

        $department->refresh();

        $this->assertArrayHas(
            [
                'name'        => 'New Name',
                'description' => 'New Description',
            ],
            $department->toArray()
        );
    }
}
