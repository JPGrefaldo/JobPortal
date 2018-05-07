<?php

namespace Tests\Unit\Services;

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
    public function test_create()
    {
        $department = $this->service->create([
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
                'name'        => 'Lighting',
                'description' => 'Some Data',
            ],
            $this->service->formatData([
                'name'        => 'Lighting',
                'description' => 'Some Data',
            ])
        );

        $this->assertSame(
            [
                'name'        => 'Lighting',
                'description' => '',
            ],
            $this->service->formatData([
                'name'        => 'Lighting',
                'description' => null,
            ])
        );


    }
}
