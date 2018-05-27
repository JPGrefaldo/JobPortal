<?php

namespace Tests\Feature\Admin;

use App\Models\Position;
use Tests\Support\Data\DepartmentID;
use Tests\Support\SeedDatabaseAfterRefresh;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PositionsFeatureTest extends TestCase
{
    use RefreshDatabase, SeedDatabaseAfterRefresh;

    /** @test */
    public function create()
    {
        $user = $this->createAdmin();
        $data = [
            'name'          => 'Some Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => 1,
            'has_union'     => 1,
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
                'has_gear'      => true,
                'has_union'     => true,
            ],
            $position->toArray()
        );
    }

    /** @test */
    public function create_not_required()
    {
        $user = $this->createAdmin();
        $data = [
            'name'          => 'Some Position',
            'department_id' => DepartmentID::PRODUCTION,
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
                'has_gear'      => false,
                'has_union'     => false,
            ],
            $position->toArray()
        );
    }

    /** @test */
    public function create_formatted_name()
    {
        $user = $this->createAdmin();
        $data = [
            'name'          => 'some position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => 1,
            'has_union'     => 1,
        ];

        $response = $this->actingAs($user)
                         ->post('admin/positions', $data);

        $response->assertSuccessful();

        $position = Position::whereName('some position')
                            ->first();

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

    /** @test */
    public function create_unauthorized()
    {
        $user = $this->createCrewUser();
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

    /** @test */
    public function update()
    {
        $user     = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data     = [
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => 1,
            'has_union'     => 1,
        ];

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'name'          => 'Updated Position',
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => true,
                'has_union'     => true,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /** @test */
    public function update_not_required()
    {
        $user     = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data     = [
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
        ];

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'name'          => 'Updated Position',
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => false,
                'has_union'     => false,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /** @test */
    public function update_formatted_name()
    {
        $user     = $this->createAdmin();
        $position = factory(Position::class)->create();
        $data     = [
            'name'          => 'updated position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => true,
            'has_union'     => true,
        ];

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'name'          => 'Updated Position',
                // name is formatted
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => true,
                'has_union'     => true,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /** @test */
    public function update_same()
    {
        $user     = $this->createAdmin();
        $data     = [
            'name'          => 'Updated Position',
            'department_id' => DepartmentID::PRODUCTION,
            'has_gear'      => true,
            'has_union'     => true,
        ];
        $position = factory(Position::class)->create($data);

        $response = $this->actingAs($user)
                         ->put('admin/positions/' . $position->id, $data);

        $response->assertSuccessful();

        $this->assertArraySubset([
                'name'          => 'Updated Position',
                'department_id' => DepartmentID::PRODUCTION,
                'has_gear'      => true,
                'has_union'     => true,
            ],
            $position->refresh()
                     ->toArray()
        );
    }

    /** @test */
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

    /** @test */
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

    /** @test */
    public function update_unauthorized()
    {
        $user     = $this->createCrewUser();
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
