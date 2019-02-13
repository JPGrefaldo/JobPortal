<?php

namespace Tests\Feature\Admin;

use App\Models\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Data\DepartmentID;
use Tests\Support\Data\PositionTypeID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;

class PositionsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::index
     */
    public function index()
    {
        $user = $this->createAdmin();

        $positions = Position::all();

        $response = $this->actingAs($user)->getJson(route('admin.positions'));

        $response->assertJson($positions->toArray());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::store
     */
    public function create()
    {
        $user = $this->createAdmin();
        $data = [
            'name'             => 'Some Position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
            'has_gear'         => 1,
            'has_union'        => 1,
        ];

        $response = $this->actingAs($user)
                         ->post(route('admin.positions'), $data);

        $response->assertSuccessful();

        $position = Position::whereName('Some Position')
            ->first();

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
     * @covers \App\Http\Controllers\Admin\PositionsController::store
     */
    public function create_not_required()
    {
        $user = $this->createAdmin();
        $data = [
            'name'             => 'Some Position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
        ];

        $response = $this->actingAs($user)
                         ->post(route('admin.positions'), $data);

        $response->assertSuccessful();

        $position = Position::whereName('Some Position')
            ->first();

        $this->assertArrayHas(
            [
                'name'             => 'Some Position',
                'department_id'    => DepartmentID::PRODUCTION,
                'position_type_id' => PositionTypeID::PRE_PRODUCTION,
                'has_gear'         => false,
                'has_union'        => false,
            ],
            $position->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::store
     */
    public function create_formatted_name()
    {
        $user = $this->createAdmin();
        $data = [
            'name'             => 'some position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
            'has_gear'         => 1,
            'has_union'        => 1,
        ];

        $response = $this->actingAs($user)
                         ->post(route('admin.positions'), $data);

        $response->assertSuccessful();

        $position = Position::whereName('some position')
            ->first();

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
     * @covers \App\Http\Controllers\Admin\PositionsController::store
     */
    public function create_invalid_data()
    {
        $user = $this->createAdmin();
        $data = [
            'name'          => '',
            'department_id' => 999,
            'has_gear'      => 'asdasd',
            'has_union'     => 'asdasd',
        ];

        $response = $this->actingAs($user)
                         ->post(route('admin.positions'), $data);

        $response->assertSessionHasErrors(
            [
                'name', // is required
                'department_id', // must exist in the departments table
                'has_gear', // must be a boolean
                'has_union' // must be a boolean
            ]
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::store
     */
    public function create_unauthorized()
    {
        $user = $this->createCrew();
        $data = [
            'name'          => 'Some Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => 1,
            'has_union'     => 1,
        ];

        $response = $this->actingAs($user)
                         ->post(route('admin.positions'), $data);

        $response->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::update
     */
    public function update()
    {
        $user = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data = [
            'name'             => 'Updated Position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
            'has_gear'         => 1,
            'has_union'        => 1,
        ];

        $response = $this->actingAs($user)
                        ->put(route('admin.positions.update', ['position' => $position->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'             => 'Updated Position',
                'department_id'    => DepartmentID::PRODUCTION,
                'position_type_id' => PositionTypeID::PRE_PRODUCTION,
                'has_gear'         => true,
                'has_union'        => true,
            ],
            $position->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::update
     */
    public function update_not_required()
    {
        $user = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data = [
            'name'             => 'Updated Position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
        ];

        $response = $this->actingAs($user)
                         ->put(route('admin.positions.update', ['position' => $position->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'             => 'Updated Position',
                'department_id'    => DepartmentID::PRODUCTION,
                'position_type_id' => PositionTypeID::PRE_PRODUCTION,
                'has_gear'         => false,
                'has_union'        => false,
            ],
            $position->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::update
     */
    public function update_formatted_name()
    {
        $user = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data = [
            'name'             => 'updated position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
            'has_gear'         => true,
            'has_union'        => true,
        ];

        $response = $this->actingAs($user)
                         ->put(route('admin.positions.update', ['position' => $position->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'             => 'Updated Position',
                // name is formatted
                'department_id'    => DepartmentID::PRODUCTION,
                'position_type_id' => PositionTypeID::PRE_PRODUCTION,
                'has_gear'         => true,
                'has_union'        => true,
            ],
            $position->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::update
     */
    public function update_same()
    {
        $user = $this->createAdmin();
        $data = [
            'name'             => 'Updated Position',
            'department_id'    => DepartmentID::PRODUCTION,
            'position_type_id' => PositionTypeID::PRE_PRODUCTION,
            'has_gear'         => true,
            'has_union'        => true,
        ];
        $position = factory(Position::class)->create($data);

        $response = $this->actingAs($user)
                         ->put(route('admin.positions.update', ['position' => $position->id]), $data);

        $response->assertSuccessful();

        $this->assertArrayHas(
            [
                'name'             => 'Updated Position',
                'department_id'    => DepartmentID::PRODUCTION,
                'position_type_id' => PositionTypeID::PRE_PRODUCTION,
                'has_gear'         => true,
                'has_union'        => true,
            ],
            $position->refresh()
                ->toArray()
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::update
     */
    public function update_invalid_data()
    {
        $user = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data = [
            'name'          => '',
            'department_id' => 999,
            'has_gear'      => 'asdasd',
            'has_union'     => 'asdasd',
        ];

        $response = $this->actingAs($user)
                         ->put(route('admin.positions.update', ['position' => $position->id]), $data);

        $response->assertSessionHasErrors(
            [
                'name',
                // is required
                'department_id',
                // must exist in the departments table
                'has_gear',
                // must be a boolean
                'has_union'
                // must be a boolean
            ]
        );
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::update
     */
    public function update_not_exist()
    {
        $user = $this->createAdmin();
        $data = [
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => true,
            'has_union'     => true,
        ];

        $response = $this->actingAs($user)
                         ->put(route('admin.positions.update', ['position' => '999']), $data);

        $response->assertNotFound();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Admin\PositionsController::update
     */
    public function update_unauthorized()
    {
        $user = $this->createCrew();
        $data = [
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => true,
            'has_union'     => true,
        ];
        $position = factory(Position::class)->create($data);

        $response = $this->actingAs($user)
                         ->put(route('admin.positions.update', ['position' => $position->id]), $data);

        $response->assertForbidden();
    }
}
