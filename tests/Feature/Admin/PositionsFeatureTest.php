<?php

namespace Tests\Feature\Admin;

use App\Models\Position;
use App\Models\User;
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
     */
    public function index()
    {
        // given
        $user = factory(User::class)->states('withAdminRole')->create();
        $positions = Position::all();

        // when
        $response = $this->actingAs($user)->getJson(route('admin.positions'));

        // then
        $response->assertJson($positions->toArray());
    }

    /**
     * @test
     * @covers
     */
    public function create()
    {
        $user = $this->createAdmin();
        $data = [
            'name'              => 'Some Position',
            'department_id'     => DepartmentID::PRODUCTION,
            'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
            'has_gear'          => 1,
            'has_union'         => 1,
        ];

        $response = $this->actingAs($user)
                         ->post('admin/positions', $data);

        $response->assertSuccessful();

        $position = Position::whereName('Some Position')
                            ->first();

        $this->assertArraySubset(
            [
                'name'          => 'Some Position',
                'department_id' => DepartmentID::PRODUCTION,
                'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
                'has_gear'      => true,
                'has_union'     => true,
            ],
            $position->toArray()
        );
    }

    /**
     * @test
     * @covers
     */
    public function create_not_required()
    {
        $user = $this->createAdmin();
        $data = [
            'name'              => 'Some Position',
            'department_id'     => DepartmentID::PRODUCTION,
            'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
        ];

        $response = $this->actingAs($user)
                         ->post('admin/positions', $data);

        $response->assertSuccessful();

        $position = Position::whereName('Some Position')
                            ->first();

        $this->assertArraySubset(
            [
                'name'              => 'Some Position',
                'department_id'     => DepartmentID::PRODUCTION,
                'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
                'has_gear'          => false,
                'has_union'         => false,
            ],
            $position->toArray()
        );
    }

    /**
     * @test
     * @covers
     */
    public function create_formatted_name()
    {
        $user = $this->createAdmin();
        $data = [
            'name'              => 'some position',
            'department_id'     => DepartmentID::PRODUCTION,
            'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
            'has_gear'          => 1,
            'has_union'         => 1,
        ];

        $response = $this->actingAs($user)
                         ->post('admin/positions', $data);

        $response->assertSuccessful();

        $position = Position::whereName('some position')
                            ->first();

        $this->assertArraySubset(
            [
                'name'              => 'Some Position',
                'department_id'     => DepartmentID::PRODUCTION,
                'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
                'has_gear'          => true,
                'has_union'         => true,
            ],
            $position->toArray()
        );
    }

    /**
     * @test
     * @covers
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
                         ->post('admin/positions', $data);

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
     * @covers
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
                         ->post('admin/positions', $data);

        $response->assertRedirect('/');
    }

    /**
     * @test
     * @covers
     */
    public function update()
    {
        $user     = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data     = [
            'name'              => 'Updated Position',
            'department_id'     => DepartmentID::PRODUCTION,
            'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
            'has_gear'          => 1,
            'has_union'         => 1,
        ];

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset(
            [
                'name'              => 'Updated Position',
                'department_id'     => DepartmentID::PRODUCTION,
                'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
                'has_gear'          => true,
                'has_union'         => true,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /**
     * @test
     * @covers
     */
    public function update_not_required()
    {
        $user     = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data     = [
            'name'              => 'Updated Position',
            'department_id'     => DepartmentID::PRODUCTION,
            'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
        ];

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset(
            [
                'name'              => 'Updated Position',
                'department_id'     => DepartmentID::PRODUCTION,
                'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
                'has_gear'          => false,
                'has_union'         => false,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /**
     * @test
     * @covers
     */
    public function update_formatted_name()
    {
        $user     = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data     = [
            'name'              => 'updated position',
            'department_id'     => DepartmentID::PRODUCTION,
            'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
            'has_gear'          => true,
            'has_union'         => true,
        ];

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset(
            [
                'name'              => 'Updated Position',
                // name is formatted
                'department_id'     => DepartmentID::PRODUCTION,
                'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
                'has_gear'          => true,
                'has_union'         => true,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /**
     * @test
     * @covers
     */
    public function update_same()
    {
        $user     = $this->createAdmin();
        $data     = [
            'name'              => 'Updated Position',
            'department_id'     => DepartmentID::PRODUCTION,
            'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
            'has_gear'          => true,
            'has_union'         => true,
        ];
        $position = factory(Position::class)->create($data);

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset(
            [
                'name'              => 'Updated Position',
                'department_id'     => DepartmentID::PRODUCTION,
                'position_type_id'  => PositionTypeID::PRE_PRODUCTION,
                'has_gear'          => true,
                'has_union'         => true,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /**
     * @test
     * @covers
     */
    public function update_invalid_data()
    {
        $user     = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data     = [
            'name'          => '',
            'department_id' => 999,
            'has_gear'      => 'asdasd',
            'has_union'     => 'asdasd',
        ];

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

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
     * @covers
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
                         ->put('admin/positions/999', $data);

        $response->assertNotFound();
    }

    /**
     * @test
     * @covers
     */
    public function update_unauthorized()
    {
        $user     = $this->createCrew();
        $data     = [
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => true,
            'has_union'     => true,
        ];
        $position = factory(Position::class)->create($data);

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertRedirect('/');
    }
}
