<?php

namespace Tests\Unit\Services;

use App\Models\Department;
use App\Services\DepartmentsServices;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    /** @test */
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

    /** @test */
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

    /** @test */
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

    /** @test */
    public function update()
    {
        $department = factory(Department::class)->create();
        $data       = [
            'name'        => 'New Name',
            'description' => 'New Description',
        ];

        $this->service->update($data, $department);

        $department->refresh();

        $this->assertArraySubset(
            [
                'name'        => 'New Name',
                'description' => 'New Description',
            ],
            $department->toArray()
        );
    }
}